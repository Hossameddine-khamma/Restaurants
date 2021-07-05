<?php

namespace App\Repository;

use App\Entity\CommentairesMenus;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CommentairesMenus|null find($id, $lockMode = null, $lockVersion = null)
 * @method CommentairesMenus|null findOneBy(array $criteria, array $orderBy = null)
 * @method CommentairesMenus[]    findAll()
 * @method CommentairesMenus[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CommentairesMenusRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CommentairesMenus::class);
    }

    // /**
    //  * @return CommentairesMenus[] Returns an array of CommentairesMenus objects
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
    public function findOneBySomeField($value): ?CommentairesMenus
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
