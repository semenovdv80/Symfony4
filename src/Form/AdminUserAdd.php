<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class AdminUserAdd extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $user = $builder->getData();

        $builder
            ->add('email', EmailType::class, array(
                'data' => $user->getEmail(),
                'empty_data' => 'Введите E-mail',
                'label'  => 'E-mail',
                'attr' => [
                    'class'   => 'form-control',
                    'maxlength' => 50
                ]
            ))
            ->add('username', TextType::class, array(
                'empty_data' => 'Введите имя',
                'label'  => 'Username',
                'required' => false,
                'attr' => [
                    'class'   => 'form-control',
                    'maxlength' => 50
                ]
            ))
            ->add('phone', TelType::class, array(
                'label'  => 'Phone',
                'required' => false,
                'attr' => [
                    'class'   => 'form-control',
                    'maxlength' => 50
                ]
            ))
            ->add('plainPassword', RepeatedType::class, array(
                'type' => PasswordType::class,
                'first_options'  => array('label' => 'Password', 'attr' => array('class'   => 'form-control')),
                'second_options' => array('label' => 'Repeat Password', 'attr' => array('class'   => 'form-control'))
            ))
            ->add('status', ChoiceType::class, array(
                'choices'  => array(
                    'Выберите' => null,
                    'Активен' => true,
                    'Не активен' => false,
                ),
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => User::class,
        ));
    }
}