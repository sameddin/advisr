<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
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
            ->getRepository('AppBundle:User')
            ->findAll();

        return [
            'users' => $users
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
}
