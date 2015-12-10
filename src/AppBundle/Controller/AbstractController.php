<?php
namespace AppBundle\Controller;

use Doctrine\ORM\EntityManager;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

abstract class AbstractController
{
    /**
     * @var FormFactoryInterface
     */
    protected $formFactory;

    /**
     * @var EntityManager
     */
    protected $em;

    /**
     * @var RouterInterface
     */
    protected $router;

    /**
     * @var PaginatorInterface
     */
    protected $paginator;

    /**
     * @var TokenStorageInterface
     */
    protected $tokenStorage;

    /**
     * @param FormFactoryInterface $formFactory
     */
    public function setFormFactory(FormFactoryInterface $formFactory)
    {
        $this->formFactory = $formFactory;
    }

    /**
     * @param EntityManager $em
     */
    public function setEm(EntityManager $em)
    {
        $this->em = $em;
    }

    /**
     * @param RouterInterface $router
     */
    public function setRouter(RouterInterface $router)
    {
        $this->router = $router;
    }

    /**
     * @param PaginatorInterface $paginator
     */
    public function setPaginator(PaginatorInterface $paginator)
    {
        $this->paginator = $paginator;
    }

    /**
     * @param TokenStorageInterface $tokenStorage
     */
    public function setTokenStorage(TokenStorageInterface $tokenStorage)
    {
        $this->tokenStorage = $tokenStorage;
    }
}
