<?php

namespace App\Form;

use App\Entity\Post;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PostUpdateType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Заголовок',
                'required' => true,
                'attr' => ['class' => 'my-2']
            ])
            ->add('text', TextareaType::class, [
                'label' => 'Текст новости',
                'required' => false,
                'attr' => ['class' => 'my-2']
            ])
            ->add('image', FileType::class, [
                'label' => 'Изображение',
                'required' => false,
                'attr' => [
                    'class' => 'form-control my-2'
                ],
                'mapped' => false
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

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Post::class,
        ]);
    }
}
