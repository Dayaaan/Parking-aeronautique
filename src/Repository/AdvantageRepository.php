<?php

namespace App\Repository;

use App\Entity\Advantage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Advantage|null find($id, $lockMode = null, $lockVersion = null)
 * @method Advantage|null findOneBy(array $criteria, array $orderBy = null)
 * @method Advantage[]    findAll()
 * @method Advantage[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AdvantageRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Advantage::class);
    }

    // /**
    //  * @return Advantage[] Returns an array of Advantage objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('b.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Advantage
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
