<?php

namespace App\Repository;

use App\Entity\Survey;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Survey|null find($id, $lockMode = null, $lockVersion = null)
 * @method Survey|null findOneBy(array $criteria, array $orderBy = null)
 * @method Survey[]    findAll()
 * @method Survey[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SurveyRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Survey::class);
    }

    public function findWithDueDatesByStatus(?int $status = null){
        $builder = $this->createQueryBuilder('s')
            ->andWhere('s.dueDate is not null')
            ->orderBy('s.dueDate', 'ASC')
        ;
        if(isset($status)){
            $builder->andWhere('s.status = :val')->setParameter('val', $status);
        }
        return $builder->getQuery()->getResult();
    }

    public function findWithoutDueDatesByStatus(?int $status = null){
        $builder = $this->createQueryBuilder('s')
            ->andWhere('s.dueDate is null')
            ->orderBy('s.id', 'ASC')
        ;
        if(isset($status)){
            $builder->andWhere('s.status = :val')->setParameter('val', $status);
        }
        return $builder->getQuery()->getResult();
    }

    // /**
    //  * @return Survey[] Returns an array of Survey objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Survey
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
