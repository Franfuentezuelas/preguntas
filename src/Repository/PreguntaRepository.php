<?php

namespace App\Repository;

use App\Entity\Pregunta;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Pregunta>
 */
class PreguntaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Pregunta::class);
    }

    public function findActive(): ?Pregunta
    {
        $now = new \DateTime(); // Obtiene la fecha y hora actuales

        return $this->createQueryBuilder('p')
            ->andWhere('p.fechaInicio <= :now')
            ->andWhere('p.fechaFin >= :now')
            ->setParameter('now', $now)
            ->setMaxResults(1) // Opcional: Devuelve solo una pregunta activa
            ->getQuery()
            ->getOneOrNullResult(); // Devuelve la pregunta o null si no hay ninguna activa
    }
    
    

    //    /**
    //     * @return Pregunta[] Returns an array of Pregunta objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('p.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Pregunta
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
