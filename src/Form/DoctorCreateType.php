<?php


namespace App\Form;


use App\Entity\DoctorPost;
use App\Entity\User;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DoctorCreateType extends AbstractType
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
            ->add('post', EntityType::class, [
                'class' => DoctorPost::class,
                'label' => 'Специализация',
//                'query_builder' => function (EntityRepository $er) {
//                    return $er->createQueryBuilder('dp');
//                },
                'choice_label' => 'name',
                'placeholder' => 'Укажите специализацию',
                'required' => false,
                'attr' => ['class' => 'my-2']
            ])
            ->add('Зарегистрировать', SubmitType::class, [
                'attr' => ['class' => 'btn btn-primary my-2']
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