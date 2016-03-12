<?php

namespace OC\PlatformBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class manager controllers for job offers
 *
 * @author      Christophe Malo
 * @version     1.0.0
 * @copyright   OpenClassrooms - Alexandre Bacco
 */

class AdvertController extends Controller
{
    /**
     * Home page controller to display a list of job offers
     * 
     * @param Page $page
     * @return View homepage index
     * @throws NotFoundHttpException
     */
    public function indexAction($page)
    {
        // A page must be greater or equal to 1
        if ($page < 1)
        {
            throw new NotFoundHttpException('Page "' . $page . '" not found.');
        }
        
        // Code to retreive a list of all job offers and send to view
        
        // Static Job offers array to testing the controller
        // Later the jobs offers'll retrieve from DB
            $listAdverts = array(
            array(
                'title' => 'Recherche développpeur Symfony2',
                'id' => 1,
                'author' => 'Alexandre',
                'content' => 'Nous recherchons un développeur Symfony2 débutant sur Lyon. Blabla…',
                'date' => new \Datetime()),
            array(
                'title' => 'Mission de webmaster',
                'id' => 2,
                'author' => 'Hugo',
                'content' => 'Nous recherchons un webmaster capable de maintenir notre site internet. Blabla…',
                'date' => new \Datetime()),
            array(
                'title' => 'Offre de stage webdesigner',
                'id' => 3,
                'author' => 'Mathieu',
                'content' => 'Nous proposons un poste pour webdesigner. Blabla…',
                'date' => new \Datetime())
        );


        return $this->render('OCPlatformBundle:Advert:index.html.twig', array(
            'listAdverts' => $listAdverts
        ));
    }
    
    /**
     * View job offer controller to display the job offer
     * 
     * @param int $id the job offer id
     * @return View view
     */
    public function viewAction($id)
    {
        // Retrieve the job offer matching the param id
        
        // Static job offer to testing - Retrieve later from DB
        $advert = array(
            'title' => 'Recherche développpeur Symfony2',
            'id' => $id,
            'author' => 'Alexandre',
            'content' => 'Nous recherchons un développeur Symfony2 débutant sur Lyon. Blabla…',
            'date' => new \Datetime()
        );

        // Return the view of a job offer
        return $this->render('OCPlatformBundle:Advert:view.html.twig', array(
            'advert' => $advert
        ));
    }
    
    /**
     * Add job offer controller
     * 
     * @param Request $request incomming request
     * @return View add
     */
    public function addAction(Request $request)
    {
        // Retrieve the antispam service
        $antispam = $this->container->get('oc_platform.antispam');
        
        // test antispam
        $text = '...'; // Less than 50 characters
        if ($antispam->isSpam($text))
        {
            throw new \Exception('Your message is detected as spam !');
        }
           
        
        // If POST method then user send form
        if ($request->isMethod('POST'))
        {
            // Create and manage Form
            
            $request->getSession()->getFlashBag()->add('notice', 'The offer job is saved.');
            
            // Redirect to see the job offer - id is change by $id later - 5 is for testing
            return $this->redirectToRoute('oc_platform_view', array('id' => 5));
        }
        
        // If not POST, display the form
        return $this->render('OCPlatformBundle:Advert:add.html.twig');
    }
    
    /**
     * Edit job offer controller
     * 
     * @param int $id the job offer id
     * @param Request $request the incomming request
     * @return View edit
     */
    public function editAction($id, Request $request)
    {
        // Retrieve the job offer matching the param id
        
        if ($request->isMethod('POST'))
        {
            $request->getSession()->getFlashBag()->add('notice', 'The offer job is modified');
            
            return $this->redirectToRoute('oc_platform_view', array('id' => 5));
        }
        
        // Static job offer to testing - Retrieve later from DB
        $advert = array(
            'title' => 'Recherche développpeur Symfony2',
            'id' => $id,
            'author' => 'Alexandre',
            'content' => 'Nous recherchons un développeur Symfony2 débutant sur Lyon. Blabla…',
            'date' => new \Datetime()
        );

        return $this->render('OCPlatformBundle:Advert:edit.html.twig', array(
            'advert' => $advert
        ));
    }
    
    /**
     * Delete job offer controller
     * 
     * @param ind $id the job offer id
     * @return View delete
     */
    public function deleteAction($id)
    {
        // Retrieve the job offer to delete matching id
        
        // Manage deleting the job offer
        
        return $this->render('OCPlatformBundle:Advert:delete.html.twig');
    }
    
    /**
     * Returns a list with the latest job offers in a bloc menu
     * 
     * @param int $limit The number limit of job offers
     * @return View menu
     */
    public function menuAction($limit)
    {
        // Static list for testing - later this list'll come from DB
        $listAdverts = array(
            array('id' => 2, 'title' => 'Search Symfony2 developer'),
            array('id' => 5, 'title' => 'Webmaster mission'),
            array('id' => 9, 'title' => 'Webdesigner internship offer')
        );
        
        return $this->render('OCPlatformBundle:Advert:menu.html.twig', array(
            // The controller sends the variable to the view
            'listAdverts' => $listAdverts
        ));
    }
}
