<?php

namespace App\Repository;

use App\Entity\Commandes;
use App\Entity\Restaurants;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Commandes|null find($id, $lockMode = null, $lockVersion = null)
 * @method Commandes|null findOneBy(array $criteria, array $orderBy = null)
 * @method Commandes[]    findAll()
 * @method Commandes[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CommandesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Commandes::class);
    }


    /**
    * @return Commandes[] Returns an array of commandes objects
    */
    
    public function findCommandesRestaurantNonValide($id)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.Restaurants = :val')    
            ->andWhere('r.Valide = :val1')
            ->andWhere('r.Heure is not null')
            ->setParameters([
                'val'=> $id,
                'val1'=>false
                ])
            ->orderBy('r.Heure', 'DESC')
            ->getQuery()
            ->getResult()
        ;
    }

    /**
    * @return Restaurants[] Returns an array of Restaurants objects
    */
    
    public function findRestaurantOfusersValidCommandes($id)
    {
        
        $commandes=$this->createQueryBuilder('c')
            ->andWhere('c.users = :val')    
            ->andWhere('c.Valide = :val1')
            ->setParameters([
                'val'=> $id,
                'val1'=>true
                ])
            ->orderBy('c.Heure', 'DESC')
            ->getQuery()
            ->getResult()
        ;
        $restaurants=array();
        foreach($commandes as $commande){
            array_push($restaurants,$commande->getRestaurants());
        }
        return $restaurants;
    }

    /**
    * @return Menus[] Returns an array of Menus objects
    */
    
    public function findMenusOfusersValidCommandes($id)
    {
        
        $commandes=$this->createQueryBuilder('c')
            ->andWhere('c.Restaurants = :val')    
            ->andWhere('c.Valide = :val1')
            ->setParameters([
                'val'=> $id,
                'val1'=>true
                ])
            ->orderBy('c.Heure', 'DESC')
            ->getQuery()
            ->getResult()
        ;
        $Menus=array();
        foreach($commandes as $commande){
            foreach($commande->getMenus() as $menu){
                array_push($Menus,$menu);
            }
        }
        return $Menus;
    }


    // /**
    //  * @return Commandes[] Returns an array of Commandes objects
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
    public function findOneBySomeField($value): ?Commandes
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
