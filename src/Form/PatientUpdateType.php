<?php

namespace App\Form;

use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class PatientUpdateType extends UserUpdateType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);
        $builder
            ->add('polis', TextType::class, [
                'label' => 'Номер полиса ОМС',
                'required' => true,
                'attr' => [
                    'class' => 'my-2',
                    'data-inputmask-regex' =>"/^\d{16}$/"
                ]
            ])
            ->add('phone', TextType::class, [
                'label' => 'Электронная почта',
                'required' => true,
                'attr' => [
                    'class' => 'my-2',
                    'data-inputmask-regex' =>"/^\d{10}$/",
                ]
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Изменить',
                'attr' => ['class' => 'btn btn-primary float-start my-2 me-2']
            ])
            ->add('cancel', SubmitType::class, [
                'label' => 'Отменить',
                'attr' => ['class' => 'btn btn-danger float-start my-2 me-2']
            ]);
    }
}
