<?php

namespace App\Repository;

use App\Entity\ContactAction;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method ContactAction|null find($id, $lockMode = null, $lockVersion = null)
 * @method ContactAction|null findOneBy(array $criteria, array $orderBy = null)
 * @method ContactAction[]    findAll()
 * @method ContactAction[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ContactActionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ContactAction::class);
    }

    // /**
    //  * @return ContactAction[] Returns an array of ContactAction objects
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
    public function findOneBySomeField($value): ?ContactAction
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
