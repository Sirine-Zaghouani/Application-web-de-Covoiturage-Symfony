<?php

namespace App\Form;

use App\Entity\Avis;
use App\Entity\AvisDemande;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddAvisDemandesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('contenu')

            //  ->add('annonce')

            ->add('submit',SubmitType::class,['label'=>"Ajouter"])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => AvisDemande::class,
        ]);
    }
}
