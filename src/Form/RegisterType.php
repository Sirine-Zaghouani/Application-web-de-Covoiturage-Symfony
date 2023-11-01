<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;

class RegisterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email',EmailType::class,[
                'label'=>'Adresse email',
                'invalid_message'=>'Entrez un email valide',

            ])
            ->add('nom',TextType::class, [
                'label'=>'Nom',
                'invalid_message'=>'Le nom est trop courte. Il doit contenir min 2 et max 30 caractères .',
                'constraints'=>new Length([
                    'min'=>2,
                    'max'=>30
                ])
            ])
            ->add('prenom',TextType::class, [
                'label'=>'Prénom',
                'invalid_message'=>'Le prénom est trop courte. Il doit contenir min 2 et max 30 caractères .',
                'constraints'=>new Length([
                    'min'=>2,
                    'max'=>30
                ]),

            ])
            ->add('adresse',TextType::class, [
                'label'=>'Adresse de résidence',
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
                'label'=>'Profession',
                'constraints'=>new Length([
                    'min'=>2,
                    'max'=>30
                ]),
                'invalid_message'=>'La profession est trop courte. Il doit contenir min 2 et max 30 caractères .',

            ])
            ->add('telephone',NumberType::class, [
                'constraints'=>new Length(8),
                'invalid_message'=>'Entrez un numéro de téléphone valide',
                'label'=>'Numéro de téléphone',
            ])
            ->add('naissance',BirthdayType::class, [
                'label'=>'Date de naissance',
                'placeholder' => [
                    'year' => 'Année', 'month' => 'Mois', 'day' => 'Jour',
                ],
            ])
            ->add('password',RepeatedType::class, [
                'type'=>PasswordType::class,
                'invalid_message'=>'le mot de passe de confirmation doivent etre identique',
                'label'=>'Mot de passe ',
                'required'=>true,
                'first_options'=>['label'=>'Mot de passe'],
                'second_options'=>['label'=>'Confirmer votre mot de passe']

            ])
            ->add('submit',SubmitType::class,[
                'label'=>"S'inscrire"
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
