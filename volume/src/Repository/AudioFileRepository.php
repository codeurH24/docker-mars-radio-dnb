<?php

namespace App\Repository;


use App\Entity\Audiofile;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method AudioFile|null find($id, $lockMode = null, $lockVersion = null)
 * @method AudioFile|null findOneBy(array $criteria, array $orderBy = null)
 * @method AudioFile[]    findAll()
 * @method AudioFile[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AudioFileRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Audiofile::class);
    }


    public function search($value): ?array
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.title LIKE :val')
            ->setParameter('val', '%'.addcslashes($value, '%_').'%')
            ->getQuery()
            ->getResult()
        ;
    }
    
    
    public function findOneBySomeField($value): ?AudioFile
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.title = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    
}
