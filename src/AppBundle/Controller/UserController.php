<?php
namespace AppBundle\Controller;

use AppBundle\Entity\User;
use AppBundle\Form\Type\LoggedUserType;
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
 * @Route("/users", service="app.user_controller")
 */
class UserController
{
    /**
     * @var EntityManager
     */
    private $em;

    /**
     * @var PaginatorInterface
     */
    private $paginator;

    /**
     * @var FormFactoryInterface
     */
    private $formFactory;

    /**
     * @var RouterInterface
     */
    private $router;

    /**
     * @param EntityManager $em
     * @param PaginatorInterface $paginator
     * @param FormFactoryInterface $formFactory
     * @param RouterInterface $router
     */
    public function __construct(EntityManager $em, PaginatorInterface $paginator, FormFactoryInterface $formFactory, RouterInterface $router)
    {
        $this->em = $em;
        $this->paginator = $paginator;
        $this->formFactory = $formFactory;
        $this->router = $router;
    }

    /**
     * @Route(name="user.list")
     * @Template
     *
     * @param Request $request
     * @return RedirectResponse|Response
     */
    public function listAction(Request $request)
    {
        $users = $this->em
            ->getRepository('AppBundle:User')
            ->findAll();

        $pagination = $this->paginator->paginate(
            $users,
            $request->query->getInt('page', 1),
            10
        );

        return [
            'users' => $users,
            'pagination' => $pagination,
        ];
    }

    /**
     * @Route("/{id}", name="user.view", requirements={"id": "\d+"})
     * @Template
     *
     * @param User $user
     * @return array
     */
    public function viewAction(User $user)
    {
        return [
            'user' => $user,
        ];
    }

    /**
     * @Route("/edit/{id}", name="user.edit")
     * @Template
     *
     * @param Request $request
     * @param User $user
     * @return RedirectResponse|Response
     */
    public function editAction(Request $request, User $user)
    {
        $form = $this->formFactory->create(LoggedUserType::class, $user);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $this->em->flush();

            return new RedirectResponse($this->router->generate('user.view', [
                'id' => $user->getId(),
            ]));
        }

        return [
            'form' => $form->createView(),
            'user' => $user,
        ];
    }
}
