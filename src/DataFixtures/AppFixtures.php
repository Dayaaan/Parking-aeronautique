<?php

namespace App\DataFixtures;

use App\Entity\Role;
use App\Entity\User;
use App\Entity\Parking;
use App\Entity\Payment;
use App\Entity\Advantage;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
        private $encoder;
        public function __construct(UserPasswordEncoderInterface $encoder) {
            $this->encoder = $encoder;
        }
        
        public function load(ObjectManager $manager)
        {
                $parking = new Parking();
                $parking->setName("Couvert")
                        ->setPlace(160)
                        ->setPrice(7.50)
                        ->setActive(true);
                
                $parking2 = new Parking();
                $parking2->setName("Exterieur")
                        ->setPlace(60)
                        ->setPrice(5.00)
                        ->setActive(true);

                $parking3 = new Parking();
                $parking3->setName("2 roues")
                        ->setPlace(50)
                        ->setPrice(5.00)
                        ->setActive(true);
                $manager->persist($parking);
                $manager->persist($parking2);
                $manager->persist($parking3);

                $payment = new Payment();
                $payment->setName("Paiement en ligne par carte bancaire")
                        ->setActive(true);
                
                $payment2 = new Payment();
                $payment2->setName("Paiement sur place")
                        ->setActive(true);
                
                $payment3 = new Payment();
                $payment3->setName("Paiement par cheque")
                        ->setActive(true);
                
                $payment4 = new Payment();
                $payment4->setName("Paiement par virement bancaire")
                        ->setActive(true);
                $manager->persist($payment);
                $manager->persist($payment2);
                $manager->persist($payment3);
                $manager->persist($payment4);

                $adminRole = new Role();
                $adminRole->setTitle("ROLE_ADMIN");
                $manager->persist($adminRole);

                $adminUser = new User();
                $adminUser->setFirstName("Martin")
                          ->setLastName("Nguyen")
                          ->setEmail("martin@gmail.com")
                          ->setHash($this->encoder->encodePassword($adminUser, "password"))
                          ->addUserRole($adminRole);
                
                $manager->persist($adminUser);

                $advantage = new Advantage();
                $advantage->setName("Etat des lieux numérique")
                        ->setPrice(5);
                $manager->persist($advantage);
                $manager->flush();
        
        }
}
