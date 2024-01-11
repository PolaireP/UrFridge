<?php

namespace App\Form;

use App\Entity\Commentary;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CommentaryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('commentaryContent', TextareaType::class, [
                'required' => true,
                'label' => false,
                'attr' => [
                    'class' => 'recipe-commentary-write',
                    'placeholder' => 'Laissez votre avis',
                    'rows' => '1',
                    'required' => 'required',
                ],
            ])
            ->add('submit', SubmitType::class, [
                'attr' => [
                    'class' => 'recipe-commentary-submit',
                ],
                'label' => 'Envoyer',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Commentary::class,
        ]);
    }
}
