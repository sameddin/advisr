<?php
namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class LoginType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', 'email', [
                'label' => 'user.email',
            ])
            ->add('password', 'password', [
                'label' => 'user.password',
            ])
            ->add('submit', 'submit', [
                'label' => 'security.login',
            ]);
    }

    public function getName()
    {
        return 'login';
    }
}
