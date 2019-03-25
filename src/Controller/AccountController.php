<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\AccountType;
use App\Service\Navigation;
use App\Entity\PasswordUpdate;
use App\Form\RegistrationType;
use App\Form\PasswordUpdateType;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AccountController extends AbstractController
{
    /**
     * @Route("/login", name="login")
     */
    public function login(AuthenticationUtils $utils, Navigation $navigation)
    {
        $error = $utils->getLastAuthenticationError();
        $username = $utils->getLastUsername();

        return $this->render('account/login.html.twig', [
            'hasError' => $error !== null,
            'username' => $username,
            'navigation' => $navigation,
        ]);
    }

    /**
     * @Route("/logout", name="logout")
     */
    public function logout() {
        //rien
    }

    /**
     * @Route("/register", name="register")
     */
    public function register(Navigation $navigation, Request $request, ObjectManager $manager, UserPasswordEncoderInterface $encoder) {

        $user = new User();
        $form = $this->createForm(RegistrationType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            //crypter le mot de passe
            $hash = $encoder->encodePassword($user, $user->getHash());
            $user->setHash($hash);
            $manager->persist($user);
            $manager->flush();
            $this->addFlash(
                'success',
                "votre compte a bien été créé ! Vous pouvez maintenant vous connecter"
            );
            return $this->redirectToRoute('login');
        }
        return $this->render('account/register.html.twig',[
            'form' => $form->createView(),
            'navigation' => $navigation
        ]);
    }

    /**
     * Permet d'afficher et de traiter le formulaire de modification de profile
     * @Route("/account/profile", name="profile")
     * @IsGranted("ROLE_USER")
     * @return Response
     */
    public function profile(Navigation $navigation, Request $request, ObjectManager $manager) {

        $user = $this->getUser();
        $form = $this->createForm(AccountType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($user);
            $manager->flush();
            $this->addFlash(
                'success',
                "Les données du profile ont bien été modifié !"
            );
        }
        return $this->render('account/profile.html.twig',
            [
                'form' => $form->createView(),
                'navigation' => $navigation,
            ]
        );
    }

    /**
     * Permet de modifier le mot de passe
     * @Route("/account/password-update" ,name="password")
     * @IsGranted("ROLE_USER")
     * @return Response
     */
    public function updatePassword(Navigation $navigation, Request $request, UserPasswordEncoderInterface $encoder, ObjectManager $manager) {
        $passwordUpdate = new PasswordUpdate();
        $user = $this->getUser();
        $form = $this->createForm(PasswordUpdateType::class, $passwordUpdate);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            //vérifier que le old password du formulaire soit le meme password de l'user
            if (!password_verify($passwordUpdate->getOldPassword(), $user->getHash())) {
                //Gerer l'erreur, (personnalisez l'erreur)
                $form->get('oldPassword')->addError(new FormError("Le mot de passe que vous avez taper n'est pas votre mot de passe actuel"));
            } else {
                $newPassword = $passwordUpdate->getNewPassword();
                $hash = $encoder->encodePassword($user, $newPassword);
                $user->setHash($hash);
                $manager->persist($user);
                $manager->flush();
                $this->addFlash(
                    'success',
                    "Votre mot de passe à bien été modifié"
                );
                return $this->redirectToRoute('home_page');
            }
         
        }
        return $this->render('account/password.html.twig',[
            'form' => $form->createView(),
            'navigation' => $navigation,
        ]);
    } 
}
