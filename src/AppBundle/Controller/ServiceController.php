<?php
namespace AppBundle\Controller;

use AppBundle\Entity\Service;
use AppBundle\Entity\User;
use AppBundle\Form\Type\ServiceType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

/**
 * @Route("/services", service="app.service_controller")
 */
class ServiceController extends AbstractController
{
    /**
     * @var TokenStorageInterface
     */
    private $tokenStorage;

    /**
     * @param TokenStorageInterface $tokenStorage
     */
    public function __construct(TokenStorageInterface $tokenStorage)
    {
        $this->tokenStorage = $tokenStorage;
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
        $user = $this->getUser();
        $service = new Service();
        $service->setUser($user);
        $form = $this->formFactory->create(new ServiceType(), $service);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $this->em->persist($service);
            $this->em->flush();

            return new RedirectResponse($this->router->generate('user.view', [
                'id' => $user->getId(),
            ]));
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
            $this->em->flush();

            return new RedirectResponse($this->router->generate('user.view', [
                'id' => $service->getUser()->getId(),
            ]));
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

        return new RedirectResponse($this->router->generate('user.view', [
            'id' => $service->getUser()->getId(),
        ]));
    }

    /**
     * @return User
     */
    private function getUser()
    {
        return $this->tokenStorage->getToken()->getUser();
    }
}
