<?php

namespace App\Controller;

use App\Service\Navigation;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ParkingController extends AbstractController
{
    /**
     * @Route("/parkings", name="parkings")
     */
    public function index(Navigation $navigation)
    {

        return $this->render('parkings/index.html.twig', [
            'navigation' => $navigation,
        ]);
    }

    /**
     * @Route("/parkings/interieur", name="parking_interieur")
     */
    public function interieur(Navigation $navigation) {

        return $this->render('parkings/interieur.html.twig', [
            'navigation' => $navigation,
        ]);
    }

    /**
     * @Route("/parkings/exterieur", name="parking_exterieur")
     */
    public function extérieur(Navigation $navigation) {
        return $this->render('parkings/exterieur.html.twig', [
            'navigation' => $navigation,
        ]);
    }

    /**
     * @Route("/parkings/2r", name="parking_deux_roues")
     */
    public function deuxRoues(Navigation $navigation) {
        
        return $this->render('parkings/2r.html.twig', [
            'navigation' => $navigation,
        ]);
    }
}
