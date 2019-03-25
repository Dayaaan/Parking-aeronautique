<?php

namespace App\Controller;

use App\Service\Navigation;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ContactController extends AbstractController
{
    /**
     * @Route("/contact", name="contact")
     */
    public function index(Navigation $navigation)
    {

        return $this->render('contact/index.html.twig', [
            'navigation' => $navigation,
        ]);
    }
}
