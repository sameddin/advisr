<?php
namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

/**
 * @Route("/login", service="app.security_controller")
 */
class SecurityController extends AbstractController
{
    /**
     * @var RouterInterface
     */
    private $router;

    /**
     * @var AuthenticationUtils
     */
    private $authenticationUtils;

    /**
     * @param RouterInterface $router
     * @param AuthenticationUtils $authenticationUtils
     */
    public function __construct(RouterInterface $router, AuthenticationUtils $authenticationUtils)
    {
        $this->router = $router;
        $this->authenticationUtils = $authenticationUtils;
    }

    /**
     * @Route(name="security.login")
     * @Template
     */
    public function loginAction()
    {
        $form = $this->formFactory->createNamedBuilder(null, 'login')
            ->setAction($this->router->generate('security.login'))
            ->getForm();

        $error = $this->authenticationUtils->getLastAuthenticationError();

        return [
            'form'  => $form->createView(),
            'error' => $error,
        ];
    }
}
