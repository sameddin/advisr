<?php
namespace AppBundle\Controller;

use AppBundle\Entity\User;
use AppBundle\Form\Type\UserType;
use Doctrine\ORM\EntityManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

/**
 * @Route("/register", service="app.registration_controller")
 */
class RegistrationController extends AbstractController
{
    /**
     * @var EntityManager
     */
    private $em;

    /**
     * @var Session
     */
    private $session;

    /**
     * @var RouterInterface
     */
    private $router;

    /**
     * @var TokenStorageInterface
     */
    private $tokenStorage;

    /**
     * @param EntityManager $em
     * @param Session $session
     * @param RouterInterface $router
     * @param TokenStorageInterface $tokenStorage
     */
    public function __construct(EntityManager $em, Session $session, RouterInterface $router, TokenStorageInterface $tokenStorage)
    {
        $this->em = $em;
        $this->session = $session;
        $this->router = $router;
        $this->tokenStorage = $tokenStorage;
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
