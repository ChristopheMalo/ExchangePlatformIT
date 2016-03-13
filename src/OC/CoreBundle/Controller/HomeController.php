<?php

namespace OC\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Class manager controllers for the core home page
 *
 * @author      Christophe Malo
 * @version     1.0.0
 * @copyright   OpenClassrooms - Alexandre Bacco
 */

class HomeController extends Controller
{
    public function homeAction()
    {
        return $this->render('OCCoreBundle:Home:home.html.twig');
    }
}
