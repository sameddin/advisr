<?php
namespace App\Controller;

use App\Entity\Category;
use App\Entity\Service;
use App\Form\Type\FilterType;
use App\Form\Type\ServiceType;
use App\Manager\ServiceManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/services", service="app.service_controller")
 */
class ServiceController extends AbstractController
{
    /**
     * @var ServiceManager
     */
    private $serviceManager;

    /**
     * @param ServiceManager $serviceManager
     */
    public function __construct(ServiceManager $serviceManager)
    {
        $this->serviceManager = $serviceManager;
    }

    /**
     * @Route(name="service.list")
     * @Template
     *
     * @param Request $request
     * @return RedirectResponse|Response
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Doctrine\ORM\TransactionRequiredException
     * @internal param Category $category
     */
    public function listAction(Request $request)
    {
        $filter = $request->query->all();

        if ($request->get('category')) {
            $category = $this->em->find('App:Category', $filter['category']);
            $filter['category'] = $category;
        }

        $filterForm = $this->formFactory->createNamedBuilder(null, FilterType::class, $filter, [
            'csrf_protection' => false,
        ])
            ->setMethod('GET')
            ->getForm();

        $services = $this->serviceManager->findAll($filter);

        $pagination = $this->paginator->paginate(
            $services,
            $request->query->getInt('page', 1),
            10
        );

        return [
            'services' => $services,
            'pagination' => $pagination,
            'filterForm' => $filterForm->createView(),
        ];
    }

    /**
     * @Route("/add", name="service.add")
     * @Template
     * @Security("is_authenticated()")
     *
     * @param Request $request
     * @return RedirectResponse|Response
     */
    public function addAction(Request $request)
    {
        $user = $this->getUser();
        $service = new Service();
        $service->setUser($user);
        $form = $this->formFactory->create(ServiceType::class, $service);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $this->serviceManager->save($service);

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
     * @Security("service.getUser() == user")
     *
     * @param Request $request
     * @param Service $service
     * @return RedirectResponse|Response
     */
    public function editAction(Request $request, Service $service)
    {
        $form = $this->formFactory->create(ServiceType::class, $service);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $this->serviceManager->save($service);

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
     * @Security("service.getUser() == user")
     *
     * @param Service $service
     * @return RedirectResponse|Response
     */
    public function deleteAction(Service $service)
    {
        $this->serviceManager->remove($service);

        return new RedirectResponse($this->router->generate('user.view', [
            'id' => $service->getUser()->getId(),
        ]));
    }
}
