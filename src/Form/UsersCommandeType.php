<?php

namespace App\Form;

use App\Entity\Users;
use Doctrine\DBAL\Types\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType as TypeTextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

class UsersCommandeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Nom',TypeTextType::class,[
                'required'=>false,
                'constraints' => [
                    new NotBlank(['message'=>'veuillez saisir une valeur']),
                ],
            ])
            ->add('Prenom',TypeTextType::class,[
                'required'=>false,
                'constraints' => [
                    new NotBlank(['message'=>'veuillez saisir une valeur']),
                ],
            ])
            ->add('Email',TypeTextType::class,[
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
