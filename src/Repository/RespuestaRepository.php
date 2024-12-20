<?php

namespace App\Repository;

use App\Entity\Respuesta;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Respuesta>
 */
class RespuestaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Respuesta::class);
    }

    public function getEstadisticas(int $preguntaId): array
    {
        $qb = $this->getEntityManager()->createQueryBuilder();

        // Consulta para contar las respuestas agrupadas por opción
        $resultados = $qb->select('o.id AS opcion_id, o.texto AS opcion_texto, COUNT(r.id) AS total_respuestas')
            ->from('App\Entity\Opcion', 'o')
            ->leftJoin('o.respuestas', 'r') // Join opcional para incluir opciones sin respuestas
            ->where('o.pregunta = :preguntaId')
            ->setParameter('preguntaId', $preguntaId)
            ->groupBy('o.id')
            ->orderBy('o.id', 'ASC')
            ->getQuery()
            ->getResult();

        return $resultados;
    }


    public function countRespuestasPorOpcion(int $preguntaId): array
    {
        return $this->createQueryBuilder('r')
            ->select('r.respuesta, COUNT(r.respuesta) AS cantidad')  // Seleccionamos la respuesta y el conteo de id
            ->where('r.pregunta = :preguntaId')              // Filtramos por pregunta específica
            ->setParameter('preguntaId', $preguntaId)        // Establecemos el parámetro de pregunta
            ->groupBy('r.respuesta')                          // Agrupamos por la columna respuesta
            ->getQuery()                                      // Ejecutamos la consulta
            ->getResult();                                    // Obtenemos el resultado
    }
    
    

    
    //    /**
    //     * @return Respuesta[] Returns an array of Respuesta objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('r')
    //            ->andWhere('r.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('r.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Respuesta
    //    {
    //        return $this->createQueryBuilder('r')
    //            ->andWhere('r.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
