<?php
namespace App\Form\Type;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class ServiceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [
                'attr' => [
                    'placeholder' => 'service.title.placeholder'
                ],
                'label' => 'service.title',
            ])
            ->add('description', TextType::class, [
                'attr' => [
                    'placeholder' => 'service.description.placeholder'
                ],
                'label' => 'service.description',
            ])
            ->add('category', EntityType::class, [
                    'class' => 'App:Category',
                    'choice_label' => 'name',
                    'placeholder' => 'service.category.placeholder',
                    'label' => 'service.category',
            ])
            ->add('save', SubmitType::class, [
                    'label' => 'common.save'
            ]);
    }

    public function getName()
    {
        return 'service';
    }
}
