<?php

namespace App\Form;

use App\Entity\DoctorPost;
use App\Entity\User;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DoctorUpdateType extends UserUpdateType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);
        $builder
            ->add('post', EntityType::class, [
                'class' => DoctorPost::class,
                'label' => 'Специализация',
                'placeholder' => 'Укажите специализацию',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('dp');
                },
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

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'validation_groups' => ["Doctor"]
        ]);
    }
}