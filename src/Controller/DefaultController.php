<?php

namespace App\Controller;

use App\Entity\Menus;
use App\Entity\Restaurants;
use App\Repository\MenusRepository;
use App\Repository\RestaurantsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="menus")
     */
    public function menus(MenusRepository $menusRepository): Response
    {
        return $this->render('default/index.html.twig', [
            "Menus"=>$menusRepository->findAll()
        ]);
    }

    /**
     * @Route("/restaurants", name="restaurants")
     */
    public function restaurants(RestaurantsRepository $restaurantsRepository): Response
    {
        return $this->render('default/restaurants.html.twig', [
            "restaurants"=>$restaurantsRepository->findAll()
        ]);
    }
    
    /**
     * @Route("/menu/{id}/restaurants", name="menuRestaurants")
     */
    public function menuRestaurants(Menus $menu, RestaurantsRepository $restaurantsRepository): Response
    {
        return $this->render('default/restaurants.html.twig', [
            "restaurants"=>$restaurantsRepository->findRestaurantsWhithMenu($menu)
        ]);
    }
    /**
     * @Route("/restaurants/{id}/menu", name="restaurantsMenu")
     */
    public function restaurantsMenu(Restaurants $restaurant): Response
    {
        return $this->render('default/Menus.html.twig', [
            "Menus"=>$restaurant->getMenus()
        ]);
    }
}
