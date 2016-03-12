<?php

namespace OC\PlatformBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class manager controllers for Advertisement
 *
 * @author      Christophe Malo
 * @version     1.0.0
 * @copyright   OpenClassrooms - Alexandre Bacco
 */

class AdvertController extends Controller
{
    public function indexAction()
    {
        $content = $this
                ->get('templating')
                ->render('OCPlatformBundle:Advert:index.html.twig');
        
        return new Response($content);
    }
    
    public function viewAction($id, Request $request)
    {
        // Return the view of an advertisement
        return $this->render(
                'OCPlatformBundle:Advert:view.html.twig',
                array('id' => $id)
        );
    }
}
