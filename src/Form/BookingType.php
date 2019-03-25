<?php

namespace App\Form;

use App\Entity\Booking;
use App\Entity\Advantage;
use App\Form\AdvantageType;
use App\Repository\AdvantageRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class BookingType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('startDate', TextType::class, [
                'attr' => ['placeholder' => "Date d'arrivée"],
            ])
            ->add('endDate', TextType::class, [
                'attr' => ['placeholder' => "Date d'arrivée"],
            ])
            ->add('parking',null, [
                'placeholder' => false,
                'label' => 'Choix du parking',
                'attr' => ['class' => 'mon_select'],
            ])
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
