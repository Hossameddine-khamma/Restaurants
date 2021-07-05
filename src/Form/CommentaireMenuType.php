<?php

namespace App\Form;

use App\Entity\CommentairesMenus;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\RangeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class CommentaireMenuType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('Valeur',TextareaType::class,[
            'required'=>false,
            'constraints' => [
                new NotBlank(['message'=>'veuillez saisir une valeur']),
            ],
        ])
        ->add('Note')
        ->add('Valider',SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => CommentairesMenus::class,
        ]);
    }
}
