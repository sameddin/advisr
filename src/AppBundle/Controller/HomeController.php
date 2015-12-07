<?php
namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * @Route("/", service="app.home_controller")
 */
class HomeController
{
    /**
     * @Route(name="homepage")
     * @Template
     */
    public function homeAction()
    {
        return [];
    }
}
