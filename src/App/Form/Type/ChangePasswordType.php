<?php
namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;

class ChangePasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('raw_password', RepeatedType::class, [
                'type' => PasswordType::class,
                'first_options' => ['label' => 'new.password'],
                'second_options' => ['label' => 'new.password.confirm'],
            ])
            ->add('save', SubmitType::class, [
                'label' => 'common.save'
            ]);
    }

    public function getName()
    {
        return 'user';
    }
}
