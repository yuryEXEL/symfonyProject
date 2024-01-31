<?php

declare(strict_types=1);

namespace App\Form\Type;

use App\DTO\ManageUserDTO;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('login', TextType::class, [
                'label' => 'Логин пользователя',
                'attr' => [
                    'data-time' => time(),
                    'placeholder' => 'Логин пользователя',
                    'class' => 'user-login',
                ],
            ]);

        $builder
            ->add('email', EmailType::class, [
                'label' => 'Email',
            ])
            ->add('submit', SubmitType::class)
            ->setMethod($options['isNew'] ? 'POST' : 'PATCH');
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ManageUserDTO::class,
            'empty_data' => new ManageUserDTO(),
            'isNew' => false,
        ]);
    }

    public function getBlockPrefix(): string
    {
        return 'save_user';
    }
}
