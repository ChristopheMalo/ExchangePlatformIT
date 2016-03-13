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
     * Display a list of job offers on homepage
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
        
        // HERE: Code to retreive a list of all job offers and send to view
        
        // Static Job offers array to testing the controller
        // Later the jobs offers'll retrieve from DB
            $listAdverts = array(
            array(
                'title' => 'Recherche développeur Symfony2',
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
                'content' => 'Nous proposons un stage pour webdesigner…',
                'date' => new \Datetime()),
            array(
                'title' => 'Offre de stage marketing',
                'id' => 4,
                'author' => 'Christophe',
                'content' => 'Nous proposons un stage pour assistant web marketing…',
                'date' => new \Datetime()),
                array(
                'title' => 'Offre de poste développeur frontend',
                'id' => 5,
                'author' => 'Richard',
                'content' => 'Nous proposons un poste pour de développeur frontend…',
                'date' => new \Datetime()),
                array(
                'title' => 'Recherche développeur backend PHP',
                'id' => 6,
                'author' => 'Christophe',
                'content' => 'Nous proposons un poste de développeur backend PHP…',
                'date' => new \Datetime())
        );


        return $this->render('OCPlatformBundle:Advert:index.html.twig', array(
            'listAdverts' => $listAdverts
        ));
    }
    
    /**
     * Display the job offer
     * 
     * @param int $id the job offer id
     * @return View view
     */
    public function viewAction($id)
    {
        // HERE: code to retrieve the job offer matching the param id
        
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
     * Add job offer
     * 
     * @param Request $request incomming request
     * @return View add
     */
    public function addAction(Request $request)
    {
          /***** Antispam service is deactivated for testing add page ****/
//        // Retrieve the antispam service
//        $antispam = $this->container->get('oc_platform.antispam');
//        
//        // test antispam
//        $text = '...'; // Less than 50 characters
//        if ($antispam->isSpam($text))
//        {
//            throw new \Exception('Your message is detected as spam !');
//        }
           
        
        // If POST method then user send form
        if ($request->isMethod('POST'))
        {
            // HERE: code to create and manage Form
            
            $request->getSession()->getFlashBag()->add('notice', 'The offer job is saved.');
            
            // Redirect to see the job offer - id is change by $id later - 5 is for testing
            return $this->redirectToRoute('oc_platform_view', array('id' => 5));
        }
        
        // If not POST, display the form
        return $this->render('OCPlatformBundle:Advert:add.html.twig');
    }
    
    /**
     * Edit job offer
     * 
     * @param int $id the job offer id
     * @param Request $request the incomming request
     * @return View edit
     */
    public function editAction($id, Request $request)
    {
        // HERE: code to retrieve the job offer matching the param id
        
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
     * Delete job offer
     * For the moment, redirect to homepage and display a flash mesage on homepage
     * 
     * @param ind $id the job offer id
     * @return View delete
     */
    public function deleteAction($id, Request $request)
    {
        // HERE: code to retrieve the job offer to delete matching id
        
        // HERE: code to manage deleting the job offer
        
        // return $this->render('OCPlatformBundle:Advert:delete.html.twig');
        
        // Alert flash message and redirect for the moment
        $request->getSession()->getFlashBag()->add('notice', 'Flash message : The delete action is not yet developed. Thank you to come back later');
            
        return $this->redirectToRoute('oc_core_home');
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
    
    /**
     * Display the contact form
     * For the moment, redirect to homepage and display a flash mesage on homepage
     * 
     * @param Request $request
     * @return View form contact
     */
    public function contactAction(Request $request)
    {
        $request->getSession()->getFlashBag()->add('notice', 'Flash message : contact page is not yet available. Thank you to come back later');
            
        return $this->redirectToRoute('oc_core_home');
    }
}
