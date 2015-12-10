<?php
namespace AppBundle\Controller;

use AppBundle\Entity\User;
use AppBundle\Form\Type\UserType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

/**
 * @Route("/register", service="app.registration_controller")
 */
class RegistrationController extends AbstractController
{
    /**
     * @var Session
     */
    private $session;

    /**
     * @param Session $session
     * @param TokenStorageInterface $tokenStorage
     */
    public function __construct(Session $session)
    {
        $this->session = $session;
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
        $form = $this->formFactory->create(new UserType(), $user);

        $form->handleRequest($request);
        if ($form->isValid()) {
            $this->em->persist($user);
            $this->em->flush();

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
