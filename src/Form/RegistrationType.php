<?php

namespace App\Form;

use App\Entity\User;
use App\Form\ApplicationType;
use Symfony\Component\Intl\Intl;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class RegistrationType extends ApplicationType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $countries = Intl::getRegionBundle()->getCountryNames();
        $builder
            ->add('firstName', TextType::class, $this->getConfiguration("Prenom", "Votre prénom"))
            ->add('lastName', TextType::class, $this->getConfiguration("Nom", "Votre nom"))
            ->add('email', EmailType::class, $this->getConfiguration("Email", "Votre adresse email"))
            ->add('adress', TextType::class, $this->getConfiguration("Addresse", "Votre adresse addresse postale"))
            ->add('city', TextType::class, $this->getConfiguration("Ville", "Votre commune"))
            ->add('pays', ChoiceType::class, $this->getConfiguration("Pays", "Votre pays", ['placeholder' => 'Votre pays', 'choices' => array_flip($countries)]))
            ->add('zipcode', TextType::class, $this->getConfiguration("Code postale", "Votre adresse code postale"))
            ->add('phone1', TextType::class, $this->getConfiguration("Telephone 1", "Votre numéro de télephone"))
            ->add('phone2', TextType::class, $this->getConfiguration("Telephone 2 *", "Votre numéro de télephone", ['required' => false]))
            ->add('organisation', TextType::class, $this->getConfiguration("Organisation *", "Votre nom de société", ['required' => false]))
            ->add('hash', PasswordType::class, $this->getConfiguration("Mot de passe", "Choisissez un bont mot de passe"))
            ->add('passwordConfirm', PasswordType::class, $this->getConfiguration("Confirmation de mot de passe", "Veuillez confirmer votre mot de passe"))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'validation_groups' => ["Default", "register"],
        ]);
    }
}
