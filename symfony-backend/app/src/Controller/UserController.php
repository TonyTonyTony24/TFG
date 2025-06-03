<?php
namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use App\Dto\RegistroDto;
use App\Dto\LoginDto;;
use App\Entity\Estado;
use App\Entity\User;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mime\Address;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
final class UserController extends AbstractController
{
    private $em;
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }
    #[Route('/auth/login', methods: ['post'])]
    public function login(
        Request $request,
        #[MapRequestPayload] LoginDto $dto,
        UserPasswordHasherInterface $passwordHaser
    ): JsonResponse {
        //Buscamos el usuario por email
        $user = $this->em->getRepository(User::class)->findOneBy([
            'email' => $dto->email,
            'estado' => $this->em->getRepository(Estado::class)->findOneBy(['nombre' => 'Verificado']),
        ]);
        if (!$user) {
            return $this->json([
                'estado' => 'error',
                'mensaje' => "El usuario no existe o no está verificado"
            ], Response::HTTP_BAD_REQUEST);
        }
        //verificar contraseña
        if ($passwordHaser->isPasswordValid($user, $dto->password)) {
            //generar JWT
            $fecha = date_create(date('Y-m-d'));
            $timestamp = date_add($fecha, date_interval_create_from_date_string('1 day'));
            $payload = [
                'iss' => $request->getUriForPath(""),
                'aud' => $user->getId(),
                'iat' => time(),
                'exp' => strtotime($timestamp->format('Y-m-d')),
                'name' => $user->getName(),
                'role' => $user->getRoles()
            ];
            $jwt = JWT::encode($payload, $_ENV['JWT_SECRET'], 'HS512');
            //DEVOLVER TOKEN Y DATOS DEL USER
            $response = $this->json([
                'estado' => 'ok',
                'mensaje' => 'Login correcto',
                'token' => $jwt
            ]);
            $cookie = new Cookie(
                name: 'X-AUTH-TOKEN',
                value: $jwt,
                expire: new \DateTimeImmutable('+1 day'),
                path: '/',
                domain: null,
                secure: true,
                httpOnly: true,
                raw: false,
                sameSite: Cookie::SAMESITE_STRICT
            );
            $response->headers->setCookie($cookie);
            return $response;
        } else {
            return $this->json([
                'estado' => 'error',
                'mensaje' => "las credenciales son incorrectas"
            ], Response::HTTP_BAD_REQUEST);
        }
    }
    #[Route('/auth/me', methods: ['get'])]
    public function me(Request $request): JsonResponse
    {
        $jwt = $request->cookies->get('X-AUTH-TOKEN');
        if (!$jwt) {
            return $this->json(['error' => 'No autenticado'], 401);
        }
        try {
            $payload = JWT::decode($jwt, new Key($_ENV['JWT_SECRET'], 'HS512'));
            return $this->json([
                'id' => $payload->aud,
                'name' => $payload->name,
                'role' => $payload->role,
                'exp' => $payload->exp
            ]);
        } catch (\Exception $e) {
            return $this->json(['error' => 'Token inválido'], 401);
        }
    }
    #[Route('/auth/logout', methods: ['get'])]
    public function logout(Request $request): JsonResponse
    {
        $response = new JsonResponse(['message' => 'Logout exitoso']);
        $response->headers->clearCookie('X-AUTH-TOKEN');
        return $response;
    }
    //registro
    #[Route('auth/register', methods: ['post'])]
    // #[IsGranted('ROLE_SUPERADMIN')]
    public function created(
        Request $request,
        #[MapRequestPayload] RegistroDto $dto,
        UserPasswordHasherInterface $passwordHaser,
        MailerInterface $mailer
    ): JsonResponse {
        //verificar si el email existe
        $existe = $this->em->getRepository(User::class)->findOneBy(['email' => $dto->email]);
        if ($existe) {
            return $this->json([
                'estado' => 'error',
                'mensaje' => "El correo {$dto->email} ya está siendo usado por otro usuario"
            ], Response::HTTP_BAD_REQUEST);
        }
        // Verificar que existe un estado con ID 2
        $estado = $this->em->getRepository(Estado::class)->findOneBy(['nombre' => 'Pendiente']);
        if (!$estado) {
            $estado = new Estado();
            $estado->setNombre('Pendiente');
            $this->em->persist($estado);
            $this->em->flush();
        }
        // Crear el nuevo usuario
        $token = sha1(uniqid() . rand(1, 100000) . time());
        $entity = new User();
        $entity->setName($dto->name);
        $entity->setEmail($dto->email);
        $entity->setPassword($passwordHaser->hashPassword($entity, $dto->password));
        $entity->setRoles(['ROLE_USER']); // Asignar rol por defecto
        $entity->setEstado($estado); // Asigna el estado encontrado o creado
        $entity->setToken($token);
        $this->em->persist($entity);
        $this->em->flush();
        $url = $request->getUriForPath("/auth/verificacion/" . $token);
        $email = (new Email())
            ->from(new Address('test@test.com', 'VALIDACION'))
            ->to($dto->email)
            ->subject('Verificación de cuenta GMV')
            ->html('<html style="font-family: Arial, sans-serif; background-color: #F4F7FC; color: #333;">
                <body style="margin: 0; padding: 20px; background-color: #F4F7FC;">
                <div style="max-width: 600px; margin: 0 auto; background-color: #FFFFFF; padding: 30px; border-radius: 10px; box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);">
                <h1 style="font-size: 24px; color: #003366; text-align: center;">¡Bienvenido a GMV!</h1>
                <p style="font-size: 16px; color: #333333;">Hola, ' . $dto->name . ':</p>
                <p style="font-size: 16px; color: #333333;">Te has registrado exitosamente. Para activar tu cuenta, por favor haz clic en el siguiente enlace:</p>
                <p style="text-align: center;">
                    <a href="' . $url . '" style="font-size: 18px; font-weight: bold; color: #FFFFFF; background-color: #003366; padding: 10px 20px; border-radius: 5px; text-decoration: none;">Activar mi cuenta</a>
                </p>
                <p style="font-size: 16px; color: #333333;">Si no puedes hacer clic en el enlace, copia y pega la siguiente URL en tu navegador favorito:</p>
                <p style="font-size: 16px; color: #003366; word-wrap: break-word; text-align: center;">
                    <code style="background-color: #F1F1F1; padding: 5px 10px; font-size: 14px; color: #003366; border-radius: 5px; margin-top: 2px;">' . $url . '</code>
                </p>
                <br/>
                <p style="font-size: 16px; color: #333333;">Gracias por unirte a BuBooks. ¡Estamos emocionados de tenerte con nosotros!</p>
                </div>
                </body>
                </html>');
        try {
            $mailer->send($email);
            return $this->json([
                'estado' => 'ok',
                'mensaje' => "Se creó el registro exitosamente"
            ], Response::HTTP_CREATED);
        } catch (TransportExceptionInterface $e) {
            return $this->json([
                'estado' => 'error',
                'mensaje' => 'Ups ocurrió un error inesperado ' . $e,
            ], Response::HTTP_BAD_REQUEST);
        }
    }
    #[Route('auth/users', methods: ['get'])]
    public function getUsers(): JsonResponse
    {
        $users = $this->em->getRepository(User::class)->findAll();
        if (empty($users)) {
            return $this->json(['estado' => 'error', 'mensaje' => 'No hay usuarios registrados'], Response::HTTP_NOT_FOUND);
        }
        $data = array_map(function (User $user) {
            return [
                'id' => $user->getId(),
                'name' => $user->getName(),
                'email' => $user->getEmail(),
                'roles' => $user->getRoles(),
                'estado' => $user->getEstado()->getNombre(),
            ];
        }, $users);
        return $this->json(['estado' => 'ok', 'data' => $data], Response::HTTP_OK);
    }
}