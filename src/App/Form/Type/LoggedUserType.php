<?php
namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class LoggedUserType extends AbstractType
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
            ->add('about', TextType::class, [
                'label' => 'user.about',
                'required' => false,
            ])
            ->add('save', SubmitType::class, [
                'label' => 'common.save',
            ]);
    }

    public function getName()
    {
        return 'user';
    }
}
