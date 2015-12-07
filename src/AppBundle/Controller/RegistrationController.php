<?php
namespace AppBundle\Controller;

use AppBundle\Entity\User;
use AppBundle\Form\Type\UserType;
use Doctrine\ORM\EntityManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\RouterInterface;

/**
 * @Route("/register", service="app.registration_controller")
 */
class RegistrationController
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
     * @var Session
     */
    private $session;

    /**
     * @var RouterInterface
     */
    private $router;

    /**
     * @param EntityManager $em
     * @param FormFactoryInterface $formFactory
     * @param Session $session
     * @param RouterInterface $router
     */
    public function __construct(EntityManager $em, FormFactoryInterface $formFactory, Session $session, RouterInterface $router)
    {
        $this->em = $em;
        $this->formFactory = $formFactory;
        $this->session = $session;
        $this->router = $router;
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

            $this->session->getFlashBag()->add('success', 'registration.success');

            return new RedirectResponse($this->router->generate('homepage'));
        }

        return [
            'form' => $form->createView(),
        ];
    }
}
