<?php

namespace App\Form;

use App\Entity\Users;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType as TypeTextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

class IdantifiantType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Identifiant',TypeTextType::class,[
                'required'=>false,
                'constraints' => [
                    new NotBlank(['message'=>'veuillez saisir une valeur']),
                ],
            ])
            ->add('password',PasswordType::class,[
                'constraints'=>[
                    new Regex([
                        'pattern' => '/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[-+!*$@%_])([-+!*$@%_\w]{8,15})$/',
                        'match' => true,
                        'message' => 'Un mot de passe valide aura:
                         de 8 à 15 caractères
                        , au moins une lettre minuscule
                        , au moins une lettre majuscule
                        , au moins un chiffre
                        et au moins un caractère spécial',
                    ]),
                ]
            ])
            ->add('confirmer',SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Users::class,
        ]);
    }
}
