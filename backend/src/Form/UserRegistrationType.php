<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class UserRegistrationType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(
                'firstName',
                TextType::class,
                [
                    'required' => true,
                ]
            )
            ->add(
                'lastName',
                TextType::class,
                [
                    'required' => true,
                ]
            )
            ->add(
                'email',
                TextType::class,
                [
                    'required' => true,
                ]
            )
            ->add(
                'password',
                PasswordType::class,
                [
                    'required' => true,
                ]
            )
            ->add('avatar', FileType::class, [
                'label' => 'Avatar (Image file)',
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '2M',
                    ]),
                ],
            ])
            ->add('photos', FileType::class, [
                'label' => 'Photos (Image files)',
                'mapped' => false,
                'required' => false,
                'multiple' => true,
                'constraints' => [
                    new File([
                        'maxSize' => '2M',
                    ]),
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
