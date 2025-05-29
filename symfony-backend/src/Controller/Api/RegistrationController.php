<?php
// src/Controller/Api/RegistrationController.php
namespace App\Controller\Api;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class RegistrationController
{
    /**
     * @Route("/api/registro", name="api_registro", methods={"POST"})
     */
    public function register(
        Request $request,
        UserPasswordHasherInterface $passwordHasher,
        EntityManagerInterface $em
    ): JsonResponse {
        $data = json_decode($request->getContent(), true);

        if (!isset($data['email'], $data['nombre'], $data['password'])) {
            return new JsonResponse(['mensaje' => 'Datos incompletos'], 400);
        }

        if ($em->getRepository(User::class)->findOneBy(['email' => $data['email']])) {
            return new JsonResponse(['mensaje' => 'Email ya registrado'], 409);
        }

        $user = new User();
        $user->setEmail($data['email']);
        $user->setNombreUsuario($data['nombre']);

        $hashedPassword = $passwordHasher->hashPassword($user, $data['password']);
        $user->setPassword($hashedPassword);

        $em->persist($user);
        $em->flush();

        return new JsonResponse(['mensaje' => 'Usuario registrado'], 201);
    }
}
