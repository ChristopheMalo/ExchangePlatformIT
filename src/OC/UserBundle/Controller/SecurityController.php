<?php

namespace OC\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\SecurityContext;

/**
 * Class to display vie login form
 *
 * @author      Christophe Malo
 * @version     1.0.0
 * @copyright   OpenClassrooms - Alexandre Bacco
 */

class SecurityController extends Controller
{

    public function loginAction(Request $request)
    {
        // If the visitor is already logged in , he's redirected to the Home
        if ($this->get('security.context')->isGranted('IS_AUTHENTICATED_REMEMBERED'))
        {
            return $this->redirectToRoute('oc_core_home');
        }

        // The authentication_utils Service retrieves the user name
        // and error if the form has been submitted but was invalid
        // (wrong password for example)
        $authenticationUtils = $this->get('security.authentication_utils');

        return $this->render('OCUserBundle:Security:login.html.twig', array(
            'last_username' => $authenticationUtils->getLastUsername(),
            'error' => $authenticationUtils->getLastAuthenticationError(),
        ));
    }

}
