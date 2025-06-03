<?php

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use App\Dto\RegistroDto;
use App\Dto\LoginDto;;

use App\Entity\User;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

use Symfony\Component\Mime\Email;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Adress;
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
        $user = $this->em->getRepository(User::class)->findOneBy(['email' => $dto->email]);
        if (!$user) {
            return $this->json([
                'estado' => 'error',
                'mensaje' => "Las credenciales son incorrectas"
            ], Response::HTTP_BAD_REQUEST);
        }
        if ($passwordHaser->isPasswordValid($user, $dto->password)) {
            $fecha = date_create(date('Y-m-d'));
            $timestamp = date_add($fecha, date_interval_create_from_date_string('1 days'));
            $payload = [
                'iss' => $request->getUriForPath(""),
                'aud' => $user->getId(),
                'iat' => time(),
                'exp' => strtotime($timestamp->format('Y-m-d'))
            ];

            $jwt = JWT::encode($payload, $_ENV['JWT_SECRET'], 'HS512');
            return $this->json([
                'id' => $user->getId(),
                'name' => $user->getName(),
                'token' => $jwt
                
            ]);
        } else {
            return $this->json([
                'estado' => 'error',
                'mensaje' => "Las credenciales son incorrectas"
            ], Response::HTTP_BAD_REQUEST);
        }
    }


    #[Route('/auth/registro', methods: ['post'])]
    public function created(
        Request $request,
        #[MapRequestPayload] RegistroDto $dto,
        UserPasswordHasherInterface $passwordHaser,
        MailerInterface $mailer
    ): JsonResponse {
        $existe = $this->em->getRepository(User::class)->findOneBy(['email' => $dto->email]);
        if ($existe) {
            return $this->json([
                'estado' => 'error',
                'mensaje' => "El correo {$dto->email} ya está siendo usado por otro usuario"
            ], Response::HTTP_BAD_REQUEST);
        }

        $token = sha1(uniqid() . rand(1, 100000) . time());
        $entity = new User();
        $entity->setName($dto->name);
        $entity->setEmail($dto->email);
        $entity->setPassword($passwordHaser->hashPassword($entity, $dto->password));
        $entity->setRoles(['ROLE_USER']);
        $entity->setToken($token);
        $this->em->persist($entity);
        $this->em->flush();

        $url = $request->getUriForPath("/auth/verificacion/" . $token);

        $email = (new Email())
            ->from(new Address('test@test.com', 'Test'))
            ->to($dto->email)
            ->subject('Verificación de cuenta')
            ->html('<h1>Verificación de cuenta</h1>
        Hola ' . $dto->name . ', por favor verifica tu cuenta haciendo click en el siguiente enlace: <a href="' . $url . '">Verificar cuenta</a></p>
        <p>Si no fuiste tú, ignora este mensaje</p>');
        try {
            $mailer->send($email);
            return $this->json([
                'estado' => 'ok',
                'mensaje' => "Se creó el registro exitosamente"
            ], Response::HTTP_OK);
        } catch (TransportExceptionInterface $th) {
            return $this->json([
                'estado' => 'error',
                'mensaje' => "Ocurrió un error"
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}
