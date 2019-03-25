<?php

namespace App\Controller;

use App\Entity\Booking;
use App\Form\BookingType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomePageController extends AbstractController
{
    /**
     * @Route("/", name="home_page")
     */
    public function Booking(Request $request, ObjectManager $manager)
    {
        $booking = new Booking();
        $form = $this->createForm(BookingType::class, $booking);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if (!$this->getUser()) {
                $this->addFlash(
                    'warning',
                    "Vous devez vous connectez pour réserver"
                );
                return $this->redirectToRoute("login");
            }

            $booking->setUser($this->getUser());
            $manager->persist($booking);
            $manager->flush();
            return $this->redirectToRoute("booking");
        }
        return $this->render('home_page/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
