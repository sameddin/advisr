<?php
namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * @Route("/login", service="app.security_controller")
 */
class SecurityController extends AbstractController
{
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
