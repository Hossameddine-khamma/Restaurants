<?php

namespace App\Controller;

use App\Entity\Commandes;
use App\Entity\Commentaires;
use App\Entity\CommentairesMenus;
use App\Entity\Restaurants;
use App\Entity\Users;
use App\Form\CommentaireMenuType;
use App\Form\CommentaireRestaurantType;
use App\Form\UsersValidationType;
use App\Repository\CommandesRepository;
use App\Repository\MenusRepository;
use App\Repository\RestaurantsRepository;
use App\Repository\UsersRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
* @Route("/user")
*/
class UsersController extends AbstractController
{
    /**
     * @Route("/", name="user")
     */
    public function index(CommandesRepository $CommandesRepository,UsersRepository $usersRepository)
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $user->getUsername();
        return $this->render('users/user.html.twig',[
            'commande'=>$usersRepository->findNotvalidatedCommande($user),
            'restaurants'=>$CommandesRepository->findRestaurantOfusersValidCommandes($user->getId())
        ]);
    }

    /**
     * @Route("/menus/{id}", name="userMenus")
     */
    public function userMenus(Restaurants $restaurant, CommandesRepository $CommandesRepository)
    {
        
        return $this->render('users/userMenus.html.twig',[
            'Menus'=>$CommandesRepository->findMenusOfusersValidCommandes($restaurant->getId())
        ]);
    }

     /**
     * @Route("/commentaire/{id}", name="userRestaurantsComentaire")
     */
    public function userRestaurantsComentaire( $id,Request $request,RestaurantsRepository $restaurantsRepository, EntityManagerInterface $em)
    {
        $restaurant=$restaurantsRepository->findOneBy(['id'=>$id]);
        $commantaire = new Commentaires();
        $commantaire->setRestaurant($restaurant);
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $commantaire->setUsers($user);

        $form = $this->createForm(CommentaireRestaurantType::class,$commantaire);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $em->persist($commantaire);
            $em->flush();

            $this->addFlash('message','Votre commentaire a bien était pris en compte');

                return $this->redirectToRoute('user');
        }

        return $this->render('users/restaurantCommentaire.html.twig',[
            'form'=>$form->createView()
        ]);
    }

     /**
     * @Route("/commentaire/menus/{id}", name="userMenusComentaire")
     */
    public function userMenusComentaire( $id,Request $request,MenusRepository $MenusRepository, EntityManagerInterface $em)
    {
        $menus=$MenusRepository->findOneBy(['id'=>$id]);
        $commantaire = new CommentairesMenus();
        $commantaire->setMenus($menus);
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $commantaire->setUser($user);

        $form = $this->createForm(CommentaireMenuType::class,$commantaire);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $em->persist($commantaire);
            $em->flush();

            $this->addFlash('message','Votre commentaire a bien était pris en compte');

                return $this->redirectToRoute('user');
        }

        return $this->render('users/restaurantCommentaire.html.twig',[
            'form'=>$form->createView()
        ]);
    }

    /**
     * @Route("/employe/{id}", name="employe")
     */
    public function employe(Users $employe,CommandesRepository $CommandesRepository)
    {
        $restaurant=$employe->getRestaurant();
       

        return $this->render('users/employe.html.twig',[
            'commandes'=>$CommandesRepository->findCommandesRestaurantNonValide($restaurant->getId()),
        ]);
    }

     /**
     * @Route("/employe/valider/{commande}-{client}", name="validerClient")
     */
    public function validerClient(Commandes $commande,Users $client, Request $request,EntityManagerInterface $em, \Swift_Mailer $mailer )
    {
        if($client->getActivationToken()){
            $form=$this->createForm(UsersValidationType::class,$client);
            $form->handleRequest($request);

            if($form->isSubmitted() && $form->isValid()){
                $token=$client->getActivationToken();
                $message = (new \Swift_Message('Hello Email'))
                ->setFrom('send@example.com')
                ->setTo($client->getEmail())
                ->setBody(
                    $this->renderView(
                        // templates/emails/registration.html.twig
                        'emails/index.html.twig',
                        ['token' => $token]
                    ),
                    'text/html'
                );

                $mailer->send($message);

                $commande->setValide(true);
                $em->persist($commande);
                $em->flush();
                $this->addFlash('message','Vous avez bien validé la commande');

                return $this->redirectToRoute('users');

            }
            return $this->render('users/validerClient.html.twig',[
                'form'=>$form->createView(),
            ]);
        }
        $commande->setValide(true);
        $em->persist($commande);
        $em->flush();
        $this->addFlash('message','Vous avez bien validé la commande');
        return $this->redirectToRoute('users');
    }
}
