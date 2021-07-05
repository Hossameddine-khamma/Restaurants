<?php

namespace App\Form;

use App\Entity\Users;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

class UsersValidationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('Nom',TextType::class,[
            'required'=>false,
            'constraints' => [
                new NotBlank(['message'=>'veuillez saisir une valeur']),
            ],
        ])
        ->add('Prenom',TextareaType::class,[
            'required'=>false,
            'constraints' => [
                new NotBlank(['message'=>'veuillez saisir une valeur']),
            ],
        ])
        ->add('Email',TextType::class,[
            'required'=>false,
            'constraints' => [

                new Regex([
                    'pattern' => '/[^@ \t\r\n]+@[^@ \t\r\n]+\.[^@ \t\r\n]+/',
                    'match' => true,
                    'message' => 'veuillez saisir une adresse mail correcte',
                ]),
                new NotBlank(['message'=>'veuillez saisir une valeur']),
            ]
        ])
            ->add('Adresse')
            ->add('valider',SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Users::class,
        ]);
    }
}
