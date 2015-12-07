<?php
namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * @Route("/")
 */
class HomeController extends Controller
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
