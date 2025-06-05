<?php

namespace App\Repository;

use App\Entity\Vehiculo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Vehiculo>
 *
 * @method Vehiculo|null find($id, $lockMode = null, $lockVersion = null)
 * @method Vehiculo|null findOneBy(array $criteria, array $orderBy = null)
 * @method Vehiculo[]    findAll()
 * @method Vehiculo[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VehiculoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Vehiculo::class);
    }

    // Añade métodos personalizados si los necesitas
}
