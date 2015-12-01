<?php
namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class ServiceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', 'text', [
                'attr' => [
                    'placeholder' => 'service.title.placeholder'
                ],
                'label' => 'service.title',
            ])
            ->add('description', 'text', [
                'attr' => [
                    'placeholder' => 'service.description.placeholder'
                ],
                'label' => 'service.description',
            ])
            ->add('save', 'submit', ['label' => 'common.add']);
    }

    public function getName()
    {
        return 'service';
    }
}
