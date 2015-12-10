<?php
namespace AppBundle\Controller;

use Symfony\Component\Form\FormFactoryInterface;

abstract class AbstractController
{
    /**
     * @var FormFactoryInterface
     */
    protected $formFactory;

    /**
     * @param FormFactoryInterface $formFactory
     */
    public function setFormFactory($formFactory)
    {
        $this->formFactory = $formFactory;
    }
}
