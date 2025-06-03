<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\User;

final class VerificacionController extends AbstractController
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }


    #[Route('/auth/verificacion/{token}', methods: ['get'])]
    public function show(string $token): Response
    {
        $user = $this->em->getRepository(User::class)->findOneBy(['token' => $token]);
        if (!$user) 
        {
            return $this->json([
                'estado' => 'error',
                'mensaje' => 'Recurso no disponible'
            ], Response::HTTP_NOT_FOUND);
        }
        $user->setToken('');
        // $user->setEstado($this->em->getRepository(Estado::class)->find(1));
        $this->em->flush();

        return $this->redirect("http://localhost:4200/login");
    }
}
