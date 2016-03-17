<?php

namespace OC\PlatformBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Class manager controllers for admin area
 *
 * @author      Christophe Malo
 * @version     1.0.0
 * @copyright   OpenClassrooms - Alexandre Bacco
 */

class AdminController extends Controller
{
    /**
     * Home action for admin
     * 
     */
    public function indexAction()
    {
        return $this->render('OCPlatformBundle:Admin:admin.html.twig');
    }
}
