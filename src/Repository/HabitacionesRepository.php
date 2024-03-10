<?php

namespace App\Repository;

use App\Entity\Habitaciones;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Habitaciones>
 *
 * @method Habitaciones|null find($id, $lockMode = null, $lockVersion = null)
 * @method Habitaciones|null findOneBy(array $criteria, array $orderBy = null)
 * @method Habitaciones[]    findAll()
 * @method Habitaciones[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class HabitacionesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Habitaciones::class);
    }

    //    /**
    //     * @return Habitaciones[] Returns an array of Habitaciones objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('h')
    //            ->andWhere('h.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('h.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Habitaciones
    //    {
    //        return $this->createQueryBuilder('h')
    //            ->andWhere('h.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
