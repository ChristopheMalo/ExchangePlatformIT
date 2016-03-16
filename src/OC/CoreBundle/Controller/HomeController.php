<?php

namespace OC\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

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
    
    /**
     * Display the contact form
     * For the moment, redirect to homepage and display a flash mesage on homepage
     * 
     * @param Request $request
     * @return View form contact
     */
    public function contactAction(Request $request)
    {
        $request->getSession()->getFlashBag()->add('info', 'Flash message : contact page is not yet available. Thank you to come back later');
            
        return $this->redirectToRoute('oc_core_home');
    }
}
