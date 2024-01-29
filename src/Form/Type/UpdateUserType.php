<?php

declare(strict_types=1);

namespace App\Form\Type;

use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;

class UpdateUserType extends UserType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        parent::buildForm($builder, $options);

        $builder->setMethod('PATCH')
            ->add('urls', CollectionType::class, [
                'entry_type' => UrlUserType::class,
                'entry_options' => ['label' => false],
            ]);
    }
}