<?php

namespace App\Controller;

use App\Service\UserCreator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    #[Route('/crear-usuario', name: 'crear_usuario')]
    public function crearUsuario(UserCreator $userCreator): Response
    {
        $user = $userCreator->createUser('correo@ejemplo.com', 'claveSegura123');

        return new Response('Usuario creado con ID: ' . $user->getId());
    }
}
