<?php
namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', 'email', [
                'label' => 'user.email',
            ])
            ->add('firstName', 'text', [
                'label' => 'user.first_name',
            ])
            ->add('lastName', 'text', [
                'label' => 'user.last_name',
            ])
            ->add('password', 'repeated', [
                'type' => 'password',
                'first_options' => ['label' => 'user.password'],
                'second_options' => ['label' => 'user.password.repeat'],
            ])
            ->add('submit', 'submit', [
                'label' => 'registration',
                'attr' => [
                    'class' => 'btn-default',
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'AppBundle\Entity\User'
        ]);
    }

    public function getName()
    {
        return 'user';
    }
}
