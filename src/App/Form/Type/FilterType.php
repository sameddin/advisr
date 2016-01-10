<?php
namespace App\Form\Type;

use App\Repository\LocationRepository;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;

class FilterType extends AbstractType
{
    /**
     * @var LocationRepository
     */
    private $locationRepository;

    /**
     * @param LocationRepository $locationRepository
     */
    public function setLocationRepository(LocationRepository $locationRepository)
    {
        $this->locationRepository = $locationRepository;
    }

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
            ->add('location', ChoiceType::class, [
                'label' => 'service.location',
                'required' => false,
                'placeholder' => 'service.locations',
                'choices' => $this->getLocations(),
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'common.select',
            ]);
    }

    public function getName()
    {
        return 'filter';
    }

    private function getLocations()
    {
        $result = [];
        foreach ($this->locationRepository->findUsed() as $location) {
            $result[$location->getName()] = $location->getId();
        }
        return $result;
    }
}
