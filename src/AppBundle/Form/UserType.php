<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;


class UserType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'attr' => [
                    'class'     =>  'form-control',
                ]
            ])
            ->add('username', TextType::class, [
                'attr' => [
                    'class'     =>  'form-control',
                ]
            ])
            ->add('email', TextType::class, [
                'attr' => [
                    'class'     =>  'form-control',
                    'type'      =>  'email'
                ]
            ])
            ->add('avatar', FileType::class,
                array(
                    'data_class' => null,
                    'required' => false,
                    'attr' => [
                        'accept' => 'image/*',
                        'multiple' => 'multiple',
                    ])
                )
        ;
    }
}
