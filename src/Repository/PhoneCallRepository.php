<?php

namespace App\Repository;

use App\Entity\PhoneCall;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method PhoneCall|null find($id, $lockMode = null, $lockVersion = null)
 * @method PhoneCall|null findOneBy(array $criteria, array $orderBy = null)
 * @method PhoneCall[]    findAll()
 * @method PhoneCall[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PhoneCallRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PhoneCall::class);
    }

    // /**
    //  * @return PhoneCall[] Returns an array of PhoneCall objects
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
    public function findOneBySomeField($value): ?PhoneCall
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
