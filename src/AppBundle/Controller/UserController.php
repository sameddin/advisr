<?php
namespace AppBundle\Controller;

use App\Entity\User;
use App\Form\Type\ChangePasswordType;
use App\Form\Type\LoggedUserType;
use App\Repository\UserRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/users", service="app.user_controller")
 */
class UserController extends AbstractController
{
    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
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
        $users = $this->userRepository->findAll();

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
            $this->userRepository->save($user);

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
     * @Route("/{id}/edit/password", name="edit.password")
     * @Template
     *
     * @param Request $request
     * @param User $user
     * @return RedirectResponse|Response
     */
    public function changePasswordAction(Request $request, User $user)
    {
        $form = $this->formFactory->create(ChangePasswordType::class, $user);
        $form->handleRequest($request);

        if ($form->isValid()) {

            $password = $this->passwordEncoder
                ->encodePassword($user, $user->getRawPassword());
            $user->setPassword($password);

            $this->userRepository->save($user);

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
