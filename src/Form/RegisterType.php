<?php


namespace App\Form;


use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RegisterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'ФИО',
                'required' => true,
                'attr' => ['class' => 'my-2']
            ])
            ->add('email', EmailType::class, [
                'label' => 'Электронная почта',
                'required' => true,
                'attr' => ['class' => 'my-2']
            ])
            ->add('sex', ChoiceType::class, [
                'label' => 'Пол',
                'placeholder' => 'Укажите пол',
                'choices' => User::SEX_CHOICES,
                'required' => true,
                'attr' => ['class' => 'my-2']
            ])
            ->add('polis', TextType::class, [
                'label' => 'Номер полиса ОМС',
                'required' => true,
                'attr' => [
                    'class' => 'my-2',
                    'data-inputmask-regex' =>"/^\d{16}$/"
                ]
            ])
            ->add('phone', TextType::class, [
                'label' => 'Телефон',
                'required' => true,
                'attr' => [
                    'class' => 'my-2',
                    'data-inputmask-regex' =>"/^\d{10}$/",
                ]
            ])
            ->add('plainPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'Пароли должны совпадать.',
                'options' => ['attr' => ['class' => 'password-field my-2']],
                'required' => true,
                'first_options' => ['label' => 'Пароль'],
                'second_options' => ['label' => 'Повторите пароль']
            ])
            ->add('Зарегистрироваться', SubmitType::class, [
                'attr' => ['class' => 'btn btn-primary my-2']
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'validation_groups' => ["Patient"]
        ]);
    }
}