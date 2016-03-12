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
        // 
        
        return $this->render('OCPlatformBundle:Advert:index.html.twig');
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

        // Return the view of a job offer
        return $this->render('OCPlatformBundle:Advert:view.html.twig', array('id' => $id));
    }
    
    /**
     * Add job offer controller
     * 
     * @param Request $request incomming request
     * @return View add
     */
    public function addAction(Request $request)
    {
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
        
        return $this->render('OCPlatformBundle:Advert:edit.html.twig');
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
}
