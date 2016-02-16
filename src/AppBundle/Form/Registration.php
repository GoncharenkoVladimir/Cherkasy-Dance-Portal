<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class Registration extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', TextType::class, array('label' => 'Login'))
            ->add('plainPassword', TextType::class, array('label' => 'Password', 'attr' => ['name' => 'password']))
            ->add('email', TextType::class, array('label' => 'Email'))
            ->add('url', TextType::class, array('label' => 'Url'))
            ->add('submit', SubmitType::class, array('label' => 'Login'))
            ->setMethod('POST')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'AppBundle\Entity\User',
            'em' => null
        ]);
    }
}