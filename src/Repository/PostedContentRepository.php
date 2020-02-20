<?php

namespace App\Repository;

use App\Entity\PostedContent;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method PostedContent|null find($id, $lockMode = null, $lockVersion = null)
 * @method PostedContent|null findOneBy(array $criteria, array $orderBy = null)
 * @method PostedContent[]    findAll()
 * @method PostedContent[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PostedContentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PostedContent::class);
    }

    // /**
    //  * @return PostedContent[] Returns an array of PostedContent objects
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
    public function findOneBySomeField($value): ?PostedContent
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
