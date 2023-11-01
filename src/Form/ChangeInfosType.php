<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;

class ChangeInfosType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email',EmailType::class,[
                'label'=>'Mon adresse email',
                'invalid_message'=>'Entrez un email valide',
            ])
            ->add('nom',TextType::class, [
                'label'=>'Mon nom',
                'invalid_message'=>'Le nom est trop courte. Il doit contenir min 2 et max 30 caractères .',
                'constraints'=>new Length([
                    'min'=>2,
                    'max'=>30,
                ])
            ])
            ->add('prenom',TextType::class, [
                'label'=>'Mon prénom',
                'invalid_message'=>'Le prénom est trop courte. Il doit contenir min 2 et max 30 caractères .',
                'constraints'=>new Length([
                    'min'=>2,
                    'max'=>30
                ]),
            ])
            ->add('adresse',TextType::class, [
                'label'=>'Mon adresse de résidence',
                'invalid_message'=>'Le adresse est trop courte. Il doit contenir min 5 et max 30 caractères .',
                'constraints'=>new Length([
                    'min'=>2,
                    'max'=>30
                ]),
            ])
            ->add('civilite', ChoiceType::class, [
                'choices'  => [
                    'Femme' => 'femme',
                    'Homme' => 'homme',

                ],
            ])
            ->add('profession',TextType::class, [
                'label'=>'Mon profession',
                'constraints'=>new Length([
                    'min'=>2,
                    'max'=>30
                ]),
                'invalid_message'=>'La profession est trop courte. Il doit contenir min 2 et max 30 caractères .',

            ])

            ->add('telephone',NumberType::class, [
                'constraints'=>new Length(8),
                'invalid_message'=>'Entrez un numéro de téléphone valide',
                'label'=>'Mon numéro de téléphone',
            ])
            ->add('naissance',BirthdayType::class, [
                'label'=>'Mon date de naissance',
                'placeholder' => [
                    'year' => 'Année', 'month' => 'Mois', 'day' => 'Jour',
                ],
            ])
            ->add('old_password',PasswordType::class,[
                'label'=>'Mon mot de passe actuel',
                'mapped'=>false,
                'attr'=>[
                    'placeholder'=>'Veuilleez saisir votre mot de passe actuel'
                ]
            ])
            ->add('submit',SubmitType::class,[
                'label'=>"Mettre à jour"
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
