<?php

namespace App\Form;

use App\Entity\Annonce;
use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Time;

class AddAnnonceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('lieu_depart',TextType::class)
            ->add('lieu_arrivee',TextType::class)
            ->add('date_depart',DateType::class)
            ->add('heure_depart',TimeType::class)
            ->add('nombre_place',NumberType::class)
            ->add('prix',NumberType::class)
            ->add('description',TextType::class)
            ->add('description',TextType::class)
            ->add('submit',SubmitType::class,[
                'label'=>"Ajouter"
            ])
        ;
    }
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Annonce::class,
        ]);
    }
}
