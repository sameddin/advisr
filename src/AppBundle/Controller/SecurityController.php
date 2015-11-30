<?php
namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class SecurityController extends Controller
{
    /**
     * @Route("/login", name="security.login")
     * @Template
     */
    public function loginAction()
    {
        $form = $this->get('form.factory')->createNamedBuilder(null, 'login')
            ->setAction($this->generateUrl('security.login'))
            ->getForm();

        $authenticationUtils = $this->get('security.authentication_utils');
        $error = $authenticationUtils->getLastAuthenticationError();

        return [
            'form'  => $form->createView(),
            'error' => $error,
        ];
    }
}
