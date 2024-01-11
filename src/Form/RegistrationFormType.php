<?php

namespace App\Form;

use App\Entity\Person;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstname', options: [
                'required' => true,
                'label' => false,
                'attr' => [
                    'placeholder' => 'Prénom',
                    'class' => 'reg-input',
                    'autocomplete' => 'given-name',
                    'id' => 'firstname',
                ],
            ])
            ->add('lastname', options: [
                'required' => true,
                'label' => false,
                'attr' => [
                    'placeholder' => 'Nom',
                    'class' => 'reg-input',
                    'autocomplete' => 'family-name',
                    'id' => 'lastname',
                ],
            ])
            ->add('email', options: [
                'required' => true,
                'label' => false,
                'row_attr' => ['id' => 'email'],
                'attr' => [
                    'placeholder' => 'Email',
                    'class' => 'reg-input',
                    'autocomplete' => 'email',
                ],
            ])
            ->add('plainPassword', RepeatedType::class, [
                                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'type' => PasswordType::class,
                'mapped' => false,
                'attr' => ['autocomplete' => 'new-password'],
                'required' => true,
                'constraints' => [
                    new NotBlank([
                        'message' => "Merci d'entrer un mot de passe",
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Votre mot de passe doit faire {{ limit }} caractères',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
                'first_options' => [
                    'attr' => ['placeholder' => 'Mot de passe', 'class' => 'reg-input'],
                    'label' => false,
                    'row_attr' => ['id' => 'password'],
                ],
                'second_options' => [
                    'attr' => ['placeholder' => 'Confirmer le mot de passe', 'class' => 'reg-input'],
                    'label' => false,
                    'row_attr' => ['id' => 'confirm-password'],
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Person::class,
        ]);
    }
}
