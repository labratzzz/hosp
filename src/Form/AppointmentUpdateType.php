<?php


namespace App\Form;


use App\Entity\Appointment;
use App\Entity\DoctorPost;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AppointmentUpdateType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('date', DateType::class, [
                'label' => 'Дата записи',
                'required' => true,
                'html5' => true,
                'input' => 'datetime',
                'widget' => 'single_text',
                'attr' => [
                    'class' => 'my-2',
                    'value' => (new \DateTime())->format('Y-m-d'),
                    'min' => (new \DateTime())->format('Y-m-d'),
                    'max' => (new \DateTime())->add(new \DateInterval('P60D'))->format('Y-m-d')]
            ])
            ->add('timeSlot', ChoiceType::class, [
                'label' => 'Время записи',
                'choices' => Appointment::TIME_CHOICES,
                'required' => true,
                'attr' => ['class' => 'my-2']
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
            'data_class' => Appointment::class,
        ]);
    }
}