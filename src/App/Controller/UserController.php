<?php
namespace App\Controller;

use App\Entity\User;
use App\Form\Type\ChangePasswordType;
use App\Form\Type\LoggedUserType;
use App\Manager\UserManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route(service="app.user_controller")
 */
class UserController extends AbstractController
{
    /**
     * @var UserManager
     */
    private $userManager;

    /**
     * @param UserManager $userManager
     */
    public function __construct(UserManager $userManager)
    {
        $this->userManager = $userManager;
    }

    /**
     * @Route("/users", name="user.list")
     * @Template
     *
     * @param Request $request
     * @return RedirectResponse|Response
     */
    public function listAction(Request $request)
    {
        $users = $this->userManager->findAll();

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
     * @Route("/users/{id}", name="user.view", requirements={"id": "\d+"})
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
     * @Route("/user/edit", name="user.edit")
     * @Template
     * @Security("is_authenticated()")
     *
     * @param Request $request
     * @return RedirectResponse|Response
     */
    public function editAction(Request $request)
    {
        $user = $this->getUser();
        $form = $this->formFactory->create(LoggedUserType::class, $user);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $this->userManager->save($user);

            return new RedirectResponse($this->router->generate('user.view', [
                'id' => $user->getId(),
            ]));
        }

        return [
            'form' => $form->createView(),
            'user' => $user,
        ];
    }

    /**
     * @Route("/user/change-password", name="user.change_password")
     * @Template
     * @Security("is_authenticated()")
     *
     * @param Request $request
     * @return RedirectResponse|Response
     */
    public function changePasswordAction(Request $request)
    {
        $user = $this->getUser();
        $form = $this->formFactory->create(ChangePasswordType::class, $user);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $this->userManager->save($user);

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
