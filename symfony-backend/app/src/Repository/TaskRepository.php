<?php

namespace App\Repository;

use App\Entity\Task;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Task>
 */
class TaskRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Task::class);
    }

    public function findAllOrdered(string $order = 'ASC')
    {
        // Validación estricta del parámetro
        $order = strtoupper($order) === 'DESC' ? 'DESC' : 'ASC';


        return $this->createQueryBuilder('t')
            ->orderBy('t.id', $order)
            ->getQuery()
            ->getResult();
    }


    public function createAtOrdered(string $order = 'ASC')
    {
        // Validación estricta del parámetro
        $order = strtoupper($order) === 'DESC' ? 'DESC' : 'ASC';


        return $this->createQueryBuilder('t')
            ->orderBy('t.createdAt', $order)
            ->getQuery()
            ->getResult();
    }


}
