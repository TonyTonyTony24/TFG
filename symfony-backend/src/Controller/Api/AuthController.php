<?php

namespace App\Controller\Api;

use App\Service\UserCreator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class AuthController extends AbstractController
{
    #[Route('/api/register', name: 'api_register', methods: ['POST'])]
    public function register(Request $req, UserCreator $creator): JsonResponse
    {
        $data = json_decode($req->getContent(), true);
        if (empty($data['email']) || empty($data['password'])) {
            return $this->json(['error' => 'email y password son requeridos'], 400);
        }

        // Antes: $user = $creator->create(...);
        // Ahora:
        $user = $creator->createUser($data['email'], $data['password']);

        return $this->json(
            ['id' => $user->getId(), 'email' => $user->getEmail()],
            201
        );
    }
}