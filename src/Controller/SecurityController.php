<?php

namespace App\Controller;

use App\Form\IdantifiantType;
use App\Repository\UsersRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    /**
     * @Route("/activation/{token}", name="activation")
     */
    public function activation($token, UsersRepository $usersRepo,Request $request, UserPasswordEncoderInterface $passwordEncoder )
    {
        $user = $usersRepo->findOneBy(['Activation_Token'=>$token]);

        if(!$user){
            throw $this->createNotFoundException('cet utilisateur n\'exicte pas');
        }
        $form=$this->createForm(IdantifiantType::class,$user);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){

            $pass=$passwordEncoder->encodePassword($user,$user->getPassword());
            $user->setPassword($pass);

            $user->setActivationToken(null);
            $user->setRoles(['ROLE_confirmed']);
            
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            $this->addFlash('message','Vous avez bien activé votre compte');
            
            return $this->redirectToRoute('app_login');
        }

        return $this->render('users/identifiant.html.twig',[
            'form'=>$form->createView()
        ]);
        

    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout()
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}
