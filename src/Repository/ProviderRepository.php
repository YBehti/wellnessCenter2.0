<?php

namespace App\Repository;

use App\Entity\Provider;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Provider|null find($id, $lockMode = null, $lockVersion = null)
 * @method Provider|null findOneBy(array $criteria, array $orderBy = null)
 * @method Provider[]    findAll()
 * @method Provider[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProviderRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Provider::class);
    }


    public function findByCp($searchPostCode,$searchService,$searchProvider){

        dump($searchPostCode);
        $qb = $this->createQueryBuilder('p');

           if($searchProvider !== ""){

                $qb->andWhere('p.name = :providers')
                   ->setParameter('providers',$searchProvider);
           }

            if($searchPostCode !== ""){

                $qb->leftJoin('p.post_code', 'post_code')
                    ->addSelect('post_code')
                    ->andWhere('post_code.post_code LIKE :post_code')
                    ->setParameter('post_code',$searchPostCode);
            }

            if($searchService){

                $qb->leftJoin('p.services','services')
                    ->addSelect('services')
                    ->andWhere('services.name LIKE :services')
                    ->setParameter('services',$searchService);
            }






        return $qb->getQuery()->getResult();
    }








    // /**
    //  * @return Provider[] Returns an array of Provider objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Provider
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */


}
