<?php

namespace OC\PlatformBundle\Controller;

use OC\PlatformBundle\Entity\Advert;
use OC\PlatformBundle\Form\AdvertType;
use OC\PlatformBundle\Form\AdvertEditType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
//use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

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
            throw $this->createNotFoundException('The page ' . $page . ' not found.'); 
        }
        
        // Set the number of job offer per page to 1 (For testing)
        // But it would use a parameter, and access them via $this->container->getParameter('nb_per_page')
        $nbPerPage = 10;
        
        // Retreive list of all job offers
        $listAdverts = $this
                ->getDoctrine()
                ->getManager()
                ->getRepository('OCPlatformBundle:Advert')
                ->getAdverts($page, $nbPerPage); // and not findAll to decrease number of queries
        
        $nbPages = ceil(count($listAdverts)/$nbPerPage);
        
        // if page does not exist -> return a 404 error
        if ($page > $nbPages)
        {
            throw $this->createNotFoundException('The page ' . $page . ' does not exist.');
        }
        
        // Send to view
        return $this->render('OCPlatformBundle:Advert:index.html.twig', array(
            'listAdverts'   => $listAdverts,
            'nbPages'       => $nbPages,
            'page'          => $page
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
        // Retrieve Manager, repository and Avert matching the id $id
        $em = $this->getDoctrine()->getManager();
        $advert = $em->getRepository('OCPlatformBundle:Advert')->find($id);
        
        // $advert is an instance of OC\PlatformBundle\Entity\Advert
        // if id $id does not exist then:
        if ($advert === null)
        {
            throw $this->createNotFoundException('The job offer id ' . $id . ' does not exist.');
        }
        
        // Retrieve the list of advertSkills for the job offer matching the id $id
        $listAdvertSkills = $em
                ->getRepository('OCPlatformBundle:AdvertSkill')
                ->findByAdvert($advert);

        // Return the view of a job offer
        return $this->render('OCPlatformBundle:Advert:view.html.twig', array(
            'advert'            => $advert,
            'listAdvertSkills'  => $listAdvertSkills
        ));
    }
    
    /**
     * Add job offer
     * 
     * @param Request $request incomming request
     * @return View add
     * @Security("has_role('ROLE_AUTEUR')")
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
        
        // Check if user has access
//        if (!$this->get('security.context')->isGranted('ROLE_AUTEUR'))
//        {
//            // If user does not access
//            throw new AccessDeniedException('Limited access to authors');
//        }
        
        // If user has access
        // Create Advert object
        $advert = new Advert();
        
        // Create the FormBuilder (Form Constructor) through the factory service form
        //$form = $this->get('form.factory')->create(new AdvertType(), $advert);
        // Shorter
        $form = $this->createForm(new AdvertType(), $advert); 
        
        // Check if values are valid
        if ($form->handleRequest($request)->isValid())
        {
            // Save datas - here in DB
            $em = $this->getDoctrine()->getManager();
            $em->persist($advert);
            $em->flush();
            
            $request->getSession()->getFlashBag()->add('info', 'The offer job is saved.');
            
            // Redirect to see the job offer
            return $this->redirect($this->generateUrl('oc_platform_view', array('id' => $advert->getId())));
        }
        
        // If the form is not valid
        // - GET (user want see the form
        // - or POST (Invalid values inside the form)
        // Then display the form again
        return $this->render('OCPlatformBundle:Advert:add.html.twig', array(
            'form' => $form->createView(),
        ));
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
        // Retrieve the EntityManager
        $em = $this->getDoctrine()->getManager();
        
        // Retrieve job offer (Entity- matching the id
        $advert = $em->getRepository('OCPlatformBundle:Advert')->find($id);
        
        // If job offer does not exist
        if (null === $advert)
        {
            throw new NotFoundHttpException('The job offer with id ' . $id . ' does not exist.');
        }
        
        $form = $this->createForm(new AdvertEditType(), $advert);
        
        if ($form->handleRequest($request)->isValid())
        {
            // No need to persist, Doctrine know the advert (job offer)
            $em->flush();
            
            $request->getSession()->getFlashBag()->add('info', 'The job offer is modified.');

            return $this->redirect($this->generateUrl('oc_platform_view', array('id' => $advert->getId())));
        }
        
        // Code to manage form (create and edit)

        return $this->render('OCPlatformBundle:Advert:edit.html.twig', array(
            'form'   => $form->createView(),
            'advert' => $advert // Send the job offer to view if wiew wants to display it
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
        // Retrieve the EntityManager
        $em = $this->getDoctrine()->getManager();
        
        // Retrieve the job offer (Entity) matching the id
        $advert = $em->getRepository('OCPlatformBundle:Advert')->find($id);
        
        // If job offer does not exist -> display a 404 error
        if (null === $advert)
        {
            throw new NotFoundHttpException('The job offer with id ' . $id . ' does not exist.');
        }
        
        // Create empty form with just the CSRF field
        // This protects deleting job offer against the CSRF flaw
        $form = $this->createFormBuilder()->getForm();
        
        if ($form->handleRequest($request)->isValid())
        {
            $em->remove($advert);
            $em->flush();
            
            $request->getSession()->getFlashBag()->add('info', 'Job offer has been deleted');
            
            // Redirect to home page
            return $this->redirectToRoute('oc_core_home');
        }
        
        // If GET request, display confirm page before deleting
        return $this->render('OCPlatformBundle:Advert:delete.html.twig', array(
            'advert' => $advert,
            'form'   => $form->createView()
        ));
    }
    
    /**
     * Returns a list with the latest job offers in a bloc menu
     * 
     * @param int $limit The number limit of job offers
     * @return View menu
     */
    public function menuAction($limit = 3)
    {
        $listAdverts = $this
                ->getDoctrine()
                ->getManager()
                ->getRepository('OCPlatformBundle:Advert')
                ->findBy(
                        array(),                    // No criteria
                        array('date' => 'desc'),    // Sort by date descending
                        $limit,                     // Limit for number of job offers displaying
                        0                           // Start at first
                        );
        
        return $this->render('OCPlatformBundle:Advert:menu.html.twig', array(
            // The controller sends the variable to the view
            'listAdverts' => $listAdverts
        ));
    }
}
