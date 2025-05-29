<?php

namespace App\Controller\Api;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class TestController extends AbstractController
{
    #[Route('/api/protegida', name: 'api_protegida', methods: ['GET'])]
    #[IsGranted('ROLE_USER')]
    public function test(): JsonResponse
    {

        /** @var \App\Entity\User $user */
        $user = $this->getUser();

        return $this->json([
            'mensaje' => '¡Acceso autorizado! Este contenido es solo para usuarios autenticados.',
            'usuario' => $user->getEmail()
        ]);
    }
}
