<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\User;
use App\Entity\Estado;

class VerificacionController extends AbstractController
{
    private $em;
    
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em; 
    }
    
    #[Route('/auth/verificacion/{token}', methods:['get'])]
    public function show($token): Response
    {
        // Find user with the token who has 'Pendiente' status
        $estadoPendiente = $this->em->getRepository(Estado::class)->findOneBy(['nombre' => 'Pendiente']);
        
        if (!$estadoPendiente) {
            return $this->json([
                'estado' => 'error', 
                'mensaje' => "Estado 'Pendiente' no encontrado" 
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        
        $user = $this->em->getRepository(User::class)->findOneBy([
            'token' => $token, 
            'estado' => $estadoPendiente
        ]);
        
        if (!$user) {
            return $this->json([
                'estado' => 'error', 
                'mensaje' => "Token inválido o expirado" 
            ], Response::HTTP_NOT_FOUND);
        }
        
        // Find the 'Verificado' estado before setting it
        $estadoVerificado = $this->em->getRepository(Estado::class)->findOneBy(['nombre' => 'Verificado']);
        
        if (!$estadoVerificado) {
            // Create 'Verificado' estado if it doesn't exist
            $estadoVerificado = new Estado();
            $estadoVerificado->setNombre('Verificado');
            $this->em->persist($estadoVerificado);
            $this->em->flush();
        }
        
        // Update user
        $user->setToken('');
        $user->setEstado($estadoVerificado);
        $this->em->flush();
        
        return $this->redirect('http://localhost:4200/auth');
    }
}