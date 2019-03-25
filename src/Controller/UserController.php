<?php
namespace App\Controller;
use App\Entity\User;
use App\Service\Navigation;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UserController extends AbstractController
{
    /**
     * @Route("/user/{id}", name="user")
     */
    public function index(User $user, Navigation $navigation)
    {
        
        return $this->render('user/index.html.twig', [
            'navigation' => $navigation,
            'user' => $user,
        ]);
    }
}