<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Advice;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * @Route("/users")
 */
class UserController extends Controller
{
    /**
     * @Route(name="user.list")
     * @Template
     */
    public function listAction()
    {
        $users = $this->getDoctrine()
            ->getRepository('AppBundle:Advice')
            ->findAll();

        return [
            'users' => $users
        ];
    }
}
