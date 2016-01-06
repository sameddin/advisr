<?php
namespace App\Form\Type;

use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;

class FilterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('category', EntityType::class, [
                'class' => 'App:Category',
                'choice_label' => 'name',
                'label' => 'service.category',
                'placeholder' => 'service.category.placeholder',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('c')
                        ->innerJoin('c.services', 's')
                        ->orderBy('c.name');
                },
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'common.select',
            ]);
    }

    public function getName()
    {
        return 'filter';
    }
}
