<?php

namespace App\Controller;

use App\Entity\Vehiculo;
use App\Repository\VehiculoRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;

#[Route('/api/vehiculos')]
class VehiculoController extends AbstractController
{
    #[Route('', methods: ['GET'])]
    public function listar(VehiculoRepository $repo): JsonResponse
    {
        $vehiculos = $repo->findAll();
        $data = array_map(function (Vehiculo $v) {
            return [
                'id' => $v->getId(),
                'marca' => $v->getMarca(),
                'modelo' => $v->getModelo(),
                'matricula' => $v->getMatricula(),
                'anio' => $v->getAnio(),
            ];
        }, $vehiculos);

        return $this->json($data);
    }

    #[Route('', methods: ['POST'])]
    public function crear(Request $request, EntityManagerInterface $em): JsonResponse
    {
        $datos = json_decode($request->getContent(), true);

        if (!$datos || !isset($datos['marca'], $datos['modelo'], $datos['matricula'], $datos['anio'])) {
            return $this->json(['error' => 'Datos incompletos'], 400);
        }

        $vehiculo = new Vehiculo();
        $vehiculo->setMarca($datos['marca']);
        $vehiculo->setModelo($datos['modelo']);
        $vehiculo->setMatricula($datos['matricula']);
        $vehiculo->setAnio($datos['anio']);

        $em->persist($vehiculo);
        $em->flush();

        return $this->json(['estado' => 'ok', 'mensaje' => 'Vehículo registrado correctamente'], 201);
    }
}
