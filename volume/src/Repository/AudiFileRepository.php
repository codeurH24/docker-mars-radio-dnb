<?php

namespace App\Repository;

use App\Entity\AudiFile;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method AudiFile|null find($id, $lockMode = null, $lockVersion = null)
 * @method AudiFile|null findOneBy(array $criteria, array $orderBy = null)
 * @method AudiFile[]    findAll()
 * @method AudiFile[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AudiFileRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AudiFile::class);
    }

    // /**
    //  * @return AudiFile[] Returns an array of AudiFile objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?AudiFile
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
