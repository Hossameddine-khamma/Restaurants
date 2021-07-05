<?php

namespace App\Controller;

use App\Entity\Commandes;
use App\Entity\Menus;
use App\Entity\Restaurants;
use App\Entity\Users;
use App\Form\CommandeContinuerType;
use App\Form\UsersCommandeType;
use App\Repository\CommandesRepository;
use App\Repository\MenusRepository;
use App\Repository\RestaurantsRepository;
use App\Repository\UsersRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
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
            "Menus"=>$restaurant->getMenus(),
            "IdRestaurant"=>$restaurant->getId()
        ]);
    }

    /**
     * @Route("/users", name="users")
     */
    public function users(Request $request, EntityManagerInterface $em,UsersRepository $usersRepository, CommandesRepository $commandesRepository)/*: Response*/
    {
        $session =$request->getSession();
        //$session->clear();
        //dd($session);
        $securityContext = $this->container->get('security.authorization_checker');
        if ($securityContext->isGranted('IS_AUTHENTICATED_REMEMBERED') || $securityContext->isGranted('IS_AUTHENTICATED_FULLY')) {
            $user = $this->get('security.token_storage')->getToken()->getUser();
            $roles=$user->getRoles();
            if(in_array("ROLE_EMPLOYE",$roles)){
                return $this->redirectToRoute('employe',['id'=>$user->getId()]);
            }
            if(in_array("ROLE_confirmed",$roles)){
                return $this->redirectToRoute('user');
            }
        }
        else if(!$session->get('NotActivatedUsers')){
            $user=new Users();
            $form= $this->createForm(UsersCommandeType::class,$user);

            $form->handleRequest($request);
            if($form->isSubmitted() && $form->isValid()){
                if(!$usersRepository->findOneBy(["Email"=>$user->getEmail()])){
                    $user->setActivationToken(md5(uniqid()));
                    $em->persist($user);
                    $em->flush();
                    $session->set('NotActivatedUsers',$user);
                    //dd($this->NotactivatedUser);
                    return $this->redirectToRoute('menus');
                }

                $session->set('NotActivatedUsers',$user);
                    //dd($this->NotactivatedUser);
                    return $this->redirectToRoute('menus');
                
            }

            return $this->render('users/NotactivatedUser.html.twig',[
                'form'=>$form->createView()
            ]);
        }else if($session->get('NotActivatedUsers')){

            $user=$usersRepository->findOneBy(['Email' => $session->get('NotActivatedUsers')->getEmail()]);
            //dd($user->getCommandes()[0]->getRestaurants()->getNom());
            return $this->render('users/user.html.twig',[
                //il faut utiliser que les commandes non valider 
                'commande'=>$usersRepository->findNotvalidatedCommande($user),
                'restaurants'=>$commandesRepository->findRestaurantOfusersValidCommandes($user->getId())
            ]);

        }
        
    }

    /**
     * @Route("/Commandes/ajouter/{menu}/{restaurant}", name="addCommande")
     */
    public function addCommande(Menus $menu,Restaurants $restaurant,Request $request, UsersRepository $usersRepository, EntityManagerInterface $em)
    {
        
        $session =$request->getSession();
        if(!$session->get('NotActivatedUsers')){
            return $this->redirectToRoute('users');
        }else{
            $user=$usersRepository->findOneBy(['Email' => $session->get('NotActivatedUsers')->getEmail()]);
            if(!$usersRepository->findNotvalidatedCommande($user)){
                $commande= new Commandes();
                $commande->setUsers($user);
                $commande->addMenu($menu);
                $commande->setRestaurants($restaurant);
                $commande->setStatus(false);

                $em->persist($commande);
                $em->flush();
            }else{
                $commande= $usersRepository->findNotvalidatedCommande($user);
                $commande->addMenu($menu);

                $em->persist($commande);
                $em->flush();
                //verifier le restaurant
                //$commande->setRestaurants($restaurant);
            }
            $em->persist($commande);
            $em->flush();

            return $this->redirectToRoute('restaurantsMenu',['id'=>$restaurant->getid()]);
        }
    }

    /**
     * @Route("/Commandes/{commande}/continuer", name="CommandeContinuer")
     */
    public function CommandeContinuer(Commandes $commande,Request $request, EntityManagerInterface $em)
    {
        $form = $this->createForm(CommandeContinuerType::class,$commande);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $commande->setStatus(true);
            $em->persist($commande);
            $em->flush();

            $session =$request->getSession();
            $session->clear();

            //route de valication de commande
            return $this->redirectToRoute('menus');
        }
        return $this->render('default/commandeContinuer.html.twig',[
            //il faut utiliser que les commandes non valider 
            'form'=>$form->createView()
        ]);
    }
}
