<?php
namespace AppBundle\Controller;

use AppBundle\Entity\Service;
use AppBundle\Form\Type\ServiceType;
use Doctrine\ORM\EntityManager;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface;

/**
 * @Route("/services", service="app.service_controller")
 */
class ServiceController
{
    /**
     * @var EntityManager
     */
    private $em;

    /**
     * @var FormFactoryInterface
     */
    private $formFactory;

    /**
     * @var RouterInterface
     */
    private $router;

    /**
     * @var PaginatorInterface
     */
    private $paginator;

    /**
     * @param EntityManager $em
     * @param FormFactoryInterface $formFactory
     * @param RouterInterface $router
     * @param PaginatorInterface $paginator
     */
    public function __construct(EntityManager $em, FormFactoryInterface $formFactory, RouterInterface $router, PaginatorInterface $paginator)
    {
        $this->em = $em;
        $this->formFactory = $formFactory;
        $this->router = $router;
        $this->paginator = $paginator;
    }

    /**
     * @Route(name="service.list")
     * @Template
     *
     * @param Request $request
     * @return RedirectResponse|Response
     */
    public function listAction(Request $request)
    {
        $services = $this->em
            ->getRepository('AppBundle:Service')
            ->findAll();

        $pagination = $this->paginator->paginate(
            $services,
            $request->query->getInt('page', 1),
            10
        );

        return [
            'services' => $services,
            'pagination' => $pagination,
        ];
    }

    /**
     * @Route("/add", name="service.add")
     * @Template
     *
     * @param Request $request
     * @return RedirectResponse|Response
     */
    public function addAction(Request $request)
    {
        $service = new Service();
        $form = $this->formFactory->create(new ServiceType(), $service);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $this->em->persist($service);
            $this->em->flush();

            return new RedirectResponse($this->router->generate('service.list'));
        }

        return [
            'form' => $form->createView(),
        ];
    }

    /**
     * @Route("/edit/{id}", name="service.edit")
     * @Template
     *
     * @param Request $request
     * @param Service $service
     * @return RedirectResponse|Response
     */
    public function editAction(Request $request, Service $service)
    {
        $form = $this->formFactory->create(new ServiceType(), $service);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $this->em->persist($service);
            $this->em->flush();

            return new RedirectResponse($this->router->generate('service.list'));
        }

        return [
            'form' => $form->createView(),
        ];
    }

    /**
     * @Route("/delete/{id}", name="service.delete")
     *
     * @param Service $service
     * @return RedirectResponse|Response
     */
    public function deleteAction(Service $service)
    {
        $this->em->remove($service);
        $this->em->flush();

        return new RedirectResponse($this->router->generate('service.list'));
    }
}
