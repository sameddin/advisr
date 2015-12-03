<?php
namespace AppBundle\Form\Type;

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
            ->add('save', SubmitType::class, ['label' => 'common.add']);
    }

    public function getName()
    {
        return 'service';
    }
}
