<?php

namespace App\Form;

use App\Entity\Booking;
use App\Entity\Advantage;
use App\Form\ApplicationType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class BookingEditType extends ApplicationType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('marque')
            ->add('modele')
            ->add('plaque')
            ->add('destination')
            ->add('numberVolAller')
            ->add('numberVolRetour')
            ->add('parking')
            ->add('advantages', EntityType::class, array(
                'class' => Advantage::class,
                'choice_label' => 'fullAdvantage',
                'multiple' => true,
                'expanded' => true,
                'required' => false,
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Booking::class,
        ]);
    }
}
