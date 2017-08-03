<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class WorkingHoursType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('weekDays', ChoiceType::class, [
                'attr' => [
                    'class'=> 'selectpicker',
                    'data-style'=> 'btn-primary',
                ],
                'multiple' => true,
                'choices' => [
                    'Monday' => 1,
                    'Tuesday' => 2,
                    'Wednesday' => 3,
                    'Thursday' => 4,
                    'Friday' => 5,
                    'Saturday' => 6,
                    'Sunday' => 7,
                ]
            ])
            ->add('startTime', TimeType::class, [
                'widget' => 'single_text',
                'attr' => [
                    'class' => 'input-group date',
                ]
            ])
            ->add('endTime', TimeType::class, [
                'widget' => 'single_text',
                'attr' => [
                    'class' => 'input-group date',
                ]
            ])
        ;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\WorkingHours'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_workinghours';
    }


}
