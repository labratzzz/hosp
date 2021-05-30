<?php

namespace App\Form;

use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class DoctorUpdateType extends UserUpdateType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);
        $builder
            ->add('post', TextType::class, [
                'label' => 'Должность',
                'required' => false,
                'attr' => ['class' => 'my-2']
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Изменить',
                'attr' => ['class' => 'btn btn-primary float-start mt-2 mb-2 me-2']
            ])
            ->add('cancel', SubmitType::class, [
                'label' => 'Отменить',
                'attr' => ['class' => 'btn btn-danger float-start mt-2 mb-2 me-2']
            ]);
    }
}