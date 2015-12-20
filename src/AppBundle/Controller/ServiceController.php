<?php
namespace AppBundle\Controller;

use App\Entity\Category;
use App\Entity\Service;
use App\Entity\User;
use AppBundle\Form\Type\ServiceType;
use AppBundle\Repository\ServiceRepository;
use Doctrine\ORM\EntityRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/services", service="app.service_controller")
 */
class ServiceController extends AbstractController
{
    /**
     * @var ServiceRepository
     */
    private $serviceRepository;

    /**
     * @param ServiceRepository $serviceRepository
     */
    public function __construct(ServiceRepository $serviceRepository)
    {
        $this->serviceRepository = $serviceRepository;
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

        $filterForm = $this->formFactory->createNamedBuilder(null, FormType::class, $filter, [
            'csrf_protection' => false,
        ])
            ->add('category', EntityType::class, [
                'class' => 'App:Category',
                'choice_label' => 'name',
                'label' => 'service.category',
                'placeholder' => 'service.category.placeholder',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('c')
                        ->innerJoin('c.services', 's');
                },
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'common.select',
            ])
            ->setMethod('GET')
            ->getForm();

        $services = $this->serviceRepository->findAll($filter);

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
            $this->serviceRepository->save($service);

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
            $this->serviceRepository->save($service);

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
        $this->serviceRepository->remove($service);

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
