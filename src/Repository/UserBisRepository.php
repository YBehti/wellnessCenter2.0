<?php

namespace App\Repository;

use App\Entity\UserBis;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method UserBis|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserBis|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserBis[]    findAll()
 * @method UserBis[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserBisRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, UserBis::class);
    }

    // /**
    //  * @return UserBis[] Returns an array of UserBis objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?UserBis
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
