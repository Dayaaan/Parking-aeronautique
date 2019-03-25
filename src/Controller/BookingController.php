<?php

namespace App\Controller;

use App\Entity\Booking;
use App\Service\Navigation;
use App\Form\BookingEditType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BookingController extends AbstractController
{
    /**
     * Permet de reservé un parking
     * @Route("/booking", name="booking")
     */
    public function booking(Request $request, ObjectManager $manager, Navigation $navigation)
    {
        $allBooking = $this->getDoctrine()->getRepository(Booking::class)->findAll($this->getUser()->getId());

        $booking = end($allBooking);
        
        $form = $this->createForm(BookingEditType::class, $booking);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $this->getUser();
            $booking->setUser($user);

            $manager->persist($booking);
            $manager->flush();

        }
        return $this->render('booking/booking.html.twig', [
            'form' => $form->createView(),
            'booking' => $booking,
            'navigation' => $navigation,
        ]);
    }
    /**
     * Permet d'éditer une réservation
     * @Route("/booking/{id}/edit", name="booking_edit")
     *
     * @return Response
     */
    public function edit(Booking $booking, Request $request, ObjectManager $manager, Navigation $navigation) {

        $form = $this->createForm(BookingEditType::class, $booking);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($booking);
            $manager->flush();

            $this->addFlash(
                'success',
                "La réservation n°{$booking->getId()} a bien été enregistrer"
            );
            return $this->redirectToRoute("user", [
                'id' => $this->getUser()->getId(),
            ]);
        }

        return $this->render("booking/edit.html.twig", [
            'booking' => $booking,
            'form' => $form->createView(),
            'navigation' => $navigation
        ]);
    }
}
