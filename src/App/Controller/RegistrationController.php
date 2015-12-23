<?php
namespace App\Controller;

use App\Entity\User;
use App\Form\Type\UserType;
use App\Manager\UserManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

/**
 * @Route("/register", service="app.registration_controller")
 */
class RegistrationController extends AbstractController
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
     * @Route(name="registration")
     * @Template
     *
     * @param Request $request
     * @return RedirectResponse|Response
     */
    public function registerAction(Request $request)
    {
        $user = new User();
        $form = $this->formFactory->create(UserType::class, $user);

        $form->handleRequest($request);
        if ($form->isValid()) {
            $this->userManager->save($user);

            $this->login($user);

            $this->session->getFlashBag()->add('success', 'registration.success');

            return new RedirectResponse($this->router->generate('homepage'));
        }

        return [
            'form' => $form->createView(),
        ];
    }

    private function login(User $user)
    {
        $token = new UsernamePasswordToken($user, null, 'main', $user->getRoles());
        $this->tokenStorage->setToken($token);
    }
}
