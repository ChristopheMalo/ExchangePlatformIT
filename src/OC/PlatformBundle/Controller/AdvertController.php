<?php

namespace OC\PlatformBundle\Controller;

use OC\PlatformBundle\Entity\Advert;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

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
        $nbPerPage = 1;
        
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
        
        // Create Advert object
        $advert = new Advert();
        
        // Create the FormBuilder (Form Constructor) through the factory service form
        $form = $this->get('form.factory')->create('form', $advert);
        
        // Add fields of the entity to form
        $formBuilder
            ->add('date', 'date')
            ->add('title', 'text')
            ->add('content', 'textarea')
            ->add('author', 'text')
            ->add('published', 'checkbox')
            ->add('save', 'submit')
        ;
        
        // For the moment, no applications, no categories - later
        
        // from ForBuilder, generate the form
        $form = $formBuilder->getForm();
        
        // OR Shorter version
//        $form = $this->get('form.factory')->createBuilder('form', $advert)
//            ->add('date', 'date')
//            ->add('title', 'text')
//            ->add('content', 'textarea')
//            ->add('author', 'text')
//            ->add('published', 'checkbox')
//            ->add('save', 'submit')
//            ->getForm()
//        ;
        
        // Link beetween request and form
        // At this time, var $advert contains the values entered by user in the form
        $form->handleRequest($request);
        
        // Check if values are valid
        if ($form->isValid())
        {
            // Save datas - here in DB
            $em = $this->getDoctrine()->getManager();
            $em->persist($advert);
            $em->flush();
            
            $request->getSession()->getFlashBag()->add('notice', 'The offer job is saved.');
            
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
        if ($advert === null)
        {
            throw $this->createNotFoundException('The job offer with id ' . $id . ' does not exist.');
        }
        
        // Code to manage form (create and edit)

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
        // Retrieve the EntityManager
        $em = $this->getDoctrine()->getManager();
        
        // Retrieve the job offer (Entity) matching the id
        $advert = $em->getRepository('OCPlatformBundle:Advert')->find($id);
        
        // If job offer does not exist -> display a 404 error
        if ($advert === null)
        {
            throw $this->createNotFoundException('The job offer with id ' . $id . ' does not exist.');
        }
        
        if ($request->isMethod('POST'))
        {
            // Code comme later: if request POST -> Delete article
            
            $request->getSession()->getFlashBag()->add('info', 'Job offer has been deleted');
            
            // Redirect to home page
            return $this->redirectToRoute('oc_core_home');
        }
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
