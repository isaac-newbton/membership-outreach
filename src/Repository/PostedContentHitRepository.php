<?php

namespace App\Repository;

use App\Entity\PostedContentHit;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method PostedContentHit|null find($id, $lockMode = null, $lockVersion = null)
 * @method PostedContentHit|null findOneBy(array $criteria, array $orderBy = null)
 * @method PostedContentHit[]    findAll()
 * @method PostedContentHit[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PostedContentHitRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PostedContentHit::class);
    }

    // /**
    //  * @return PostedContentHit[] Returns an array of PostedContentHit objects
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
    public function findOneBySomeField($value): ?PostedContentHit
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
