<?php

namespace App\Form;

use App\Entity\Commandes;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class CommandeContinuerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Type',ChoiceType::class,[
                'choices'  => [
                    'Sur Place' => true,
                    'A emporter' => false,
                ],
                'constraints' => [
                    new NotBlank(['message'=>'veuillez choisir une valeur']),
                ],
            ])
            ->add('Heure',DateTimeType::class,[
                'date_widget'=> 'single_text',
                'hours'=>[11,12,13,14,18,19,20,21],
                'constraints' => [
                    new NotBlank(['message'=>'veuillez saisir une valeur']),
                ],
            ])
            ->add('valider',SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Commandes::class,
        ]);
    }
}
