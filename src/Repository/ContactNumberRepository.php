<?php

namespace App\Repository;

use App\Entity\ContactNumber;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method ContactNumber|null find($id, $lockMode = null, $lockVersion = null)
 * @method ContactNumber|null findOneBy(array $criteria, array $orderBy = null)
 * @method ContactNumber[]    findAll()
 * @method ContactNumber[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ContactNumberRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ContactNumber::class);
    }

    // /**
    //  * @return ContactNumber[] Returns an array of ContactNumber objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ContactNumber
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
