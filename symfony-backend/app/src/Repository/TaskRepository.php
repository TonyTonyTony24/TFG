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

    //    /**
    //     * @return Task[] Returns an array of Task objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('t')
    //            ->andWhere('t.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('t.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Task
    //    {
    //        return $this->createQueryBuilder('t')
    //            ->andWhere('t.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }

    public function findAllOrdered(string $orden = 'ASC')
    {
        $orden = strtoupper ($orden) === 'DESC' ? 'DESC' : 'ASC';
        return $this->createQueryBuilder('t')
            ->orderBy('t.id', $orden)
            ->getQuery()
            ->getResult();
        
        
    }

    public function createAtOrdered(string $orden = 'ASC')
    {
        $orden = strtoupper ($orden) === 'DESC' ? 'DESC' : 'ASC';
        return $this->createQueryBuilder('t')
            ->orderBy('t.createdAt', $orden)
            ->getQuery()
            ->getResult();
        
        
    }

}
