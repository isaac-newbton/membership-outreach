<?php

namespace App\Repository;

use App\Entity\SurveyTemplate;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method SurveyTemplate|null find($id, $lockMode = null, $lockVersion = null)
 * @method SurveyTemplate|null findOneBy(array $criteria, array $orderBy = null)
 * @method SurveyTemplate[]    findAll()
 * @method SurveyTemplate[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SurveyTemplateRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SurveyTemplate::class);
    }

    // /**
    //  * @return SurveyTemplate[] Returns an array of SurveyTemplate objects
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
    public function findOneBySomeField($value): ?SurveyTemplate
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
