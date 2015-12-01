<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Service;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * @Route("/services")
 */
class ServiceController extends Controller
{
    /**
     * @Route(name="service.list")
     * @Template
     */
    public function listAction()
    {
        $services = $this->getDoctrine()
            ->getRepository('AppBundle:Service')
            ->findAll();

        return [
            'services' => $services
        ];
    }
}
