<?php
namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class, [
                'label' => 'user.email',
            ])
            ->add('firstName', TextType::class, [
                'label' => 'user.first_name',
            ])
            ->add('lastName', TextType::class, [
                'label' => 'user.last_name',
            ])
            ->add('raw_password', RepeatedType::class, [
                'type' => PasswordType::class,
                'first_options' => ['label' => 'user.password'],
                'second_options' => ['label' => 'user.password.repeat'],
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'registration',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'App\Entity\User',
            'validation_groups' => [
                'Default',
                'Registration',
            ],
        ]);
    }

    public function getName()
    {
        return 'user';
    }
}
