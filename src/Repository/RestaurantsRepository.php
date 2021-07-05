<?php

namespace App\Repository;

use App\Entity\Restaurants;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Restaurants|null find($id, $lockMode = null, $lockVersion = null)
 * @method Restaurants|null findOneBy(array $criteria, array $orderBy = null)
 * @method Restaurants[]    findAll()
 * @method Restaurants[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RestaurantsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Restaurants::class);
    }

    /**
    * @return Restaurants[] Returns an array of Restaurants objects
    */
    
    public function findRestaurantsWhithMenu($menu)
    {
        $allRestaurants=$this->findAll();
        $reastaurants=array();
        foreach($allRestaurants as $reastaurant){
            $menus = array();
            foreach($reastaurant->getMenus() as $m){
                array_push($menus,$m->getId());
            }
            if(in_array($menu->getId(),$menus)){
                array_push($reastaurants,$reastaurant);
            }
        }
        return $reastaurants;
    }
    
   
    
    // /**
    //  * @return Restaurants[] Returns an array of Restaurants objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Restaurants
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
