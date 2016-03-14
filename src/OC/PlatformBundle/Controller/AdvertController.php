<?php

namespace OC\PlatformBundle\Controller;

use OC\PlatformBundle\Entity\Advert;
use OC\PlatformBundle\Entity\Image;
use OC\PlatformBundle\Entity\Application;
use OC\PlatformBundle\Entity\AdvertSkill;
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
        // Retrieve the repository
//        $repository = $this->getDoctrine()
//                ->getManager()
//                ->getRepository('OCPlatformBundle:Advert');
        
        // Retrieve the entity matching the id $id
//        $advert = $repository->find($id);
        
        // OU
        
        // Retrieve Manager, repository and Avert matching the id $id
        $em = $this->getDoctrine()->getManager();
        $advert = $em->getRepository('OCPlatformBundle:Advert')->find($id);
        
        // $advert is an instance of OC\PlatformBundle\Entity\Advert
        // if id $id does not exist then:
        if (null === $advert)
        {
            throw new NotFoundHttpException('The job offer id ' . $id . ' does not exist.');
        }
        
        // Static job offer to testing - Retrieve later from DB
//        $advert = array(
//            'title' => 'Recherche développpeur Symfony2',
//            'id' => $id,
//            'author' => 'Alexandre',
//            'content' => 'Nous recherchons un développeur Symfony2 débutant sur Lyon. Blabla…',
//            'date' => new \Datetime()
//        );
        
        // Retrieve the list of application for the job offer matching the id $id
        $listApplications = $em
                ->getRepository('OCPlatformBundle:Application')
                ->findBy(array('advert' => $advert));
        
        $listAdvertSkills = $em
                ->getRepository('OCPlatformBundle:AdvertSkill')
                ->findBy(array('advert' => $advert));

        // Return the view of a job offer
        return $this->render('OCPlatformBundle:Advert:view.html.twig', array(
            'advert'            => $advert,
            'listApplications'  => $listApplications,
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
        
        // Retrieve the entity manager
        $em = $this->getDoctrine()->getManager();
        
        
        
        // Create a static entity Advert to test
        $advert = new Advert();
        $advert->setTitle('Recherche developpeur Symfony 2');
        $advert->setAuthor('Christophe');
        $advert->setContent('Nous recherchons un développeur symfony2 sur Lyon');
        // Date and publication is define automatically
        
        // Create a static entity Image to test
        $image = new Image();
        $image->setUrl('http://sdz-upload.s3.amazonaws.com/prod/upload/job-de-reve.jpg');
        $image->setAlt('Job de rêve');
        
        // Create a static Application to test
        $application1 = new Application();
        $application1->setAuthor('Marine');
        $application1->setContent("J'ai toutes les qualités requises");
        
        // Create a second Application
        $application2 = new Application();
        $application2->setAuthor('Pierre');
        $application2->setContent('Je suis très motivé');
        
        // Link applications to job offer
        $application1->setAdvert($advert);
        $application2->setAdvert($advert);
        
        // Link image to job offer
        $advert->setImage($image);
        
        // This is a bad method - Just for test
        // Retrieve all skills
        $listSkills = $em->getRepository('OCPlatformBundle:Skill')->findAll();
        
        // For each skill
        foreach ($listSkills as $skill)
        {
            // Create new relation between 1 job offer and one skill
            $advertSkill = new AdvertSkill();
            
            // Link to job offer - here the same static one for the test
            $advertSkill->setAdvert($advert);
            
            // Link to skill - differente due to loop
            $advertSkill->setSkill($skill);
            
            // Arbitrarily , we say that each skill is required in 'Expert'
            $advertSkill->setLevel('Expert');
            
            // there persists the entity relationship, owner of two other relationships
            $em->persist($advertSkill);
        }
        
        
        
        // First stage - Persists the entity - Doctrine manage the entity
        $em->persist($advert);
        
        // First stage bis
        // No need to manually persist Entity $image because used cascade={'persist'}
        // on Advert Entity fot private $image
        
        // First stage ter
        // Persist application - because relation i defined in Application and not advert
        $em->persist($application1);
        $em->persist($application2);
        
        
        
        // Second stage - Flush the persist - Doctrine save the entity (query)
        $em->flush();
        
        
        
        
        // If POST method then user send form
        if ($request->isMethod('POST'))
        {
            // HERE: code to create and manage Form
            
            $request->getSession()->getFlashBag()->add('notice', 'The offer job is saved.');
            
            // Redirect to see the job offer
            return $this->redirect($this->generateUrl('oc_platform_view', array('id' => $advert->getId())));
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
        
        // Add job offer to all categories
        $em = $this->getDoctrine()->getManager();
        
        // Retrieve job offer id
        $advert = $em->getRepository('OCPlatformBundle:Advert')->find($id);
        
        if (null === $advert)
        {
            throw new NotFoundHttpException('The job offer with id ' . $id . ' does not exist.');
        }
        
        // findAll retrieves all the categories
        $listCategories = $em->getRepository('OCPlatformBundle:Category')->findAll();
        
        // Loops on the categories to link to job offer
        foreach ($listCategories as $category)
        {
            $advert->addCategory($category);
        }
        
        // Persist is done in Advert
        
        // Start the saving
        $em->flush();
        
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
        
        // Remove all categories
        $em = $this->getDoctrine()->getManager();
        
        // Retrieve the job offer id
        $advert = $em->getRepository('OCPlatformBundle:Advert')->find($id);
        
        if (null === $advert)
        {
            throw new NotFoundHttpException('The job offer with id ' . $id . ' does not exist.');
        }
        
        // Loops on the categories to link to job offer
        foreach ($advert->getCategories() as $category)
        {
            $advert->removeCategory($category);
        }
        
        // Persist is done in Advert
        
        // Start the saving
        $em->flush();
        
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
    
    /**
     * Exemple on how to modify an url image
     * It's a static exemple
     * 
     * @param integer $advertId
     * @return \OC\PlatformBundle\Controller\Response
     */
    public function editImageAction($advertId)
    {
        $em = $this->getDoctrine()->getManager();
        
        // Retrieve job offer
        $advert = $em->getRepository('OCPlatformBundle:Advert')->find($advertId);
        
        // Modify image URL
        $advert->getImage()->setUrl('test.png');
        
        // No need to persist image or advert (job offer) here
        // Those entities are automatically persist because Doctrine retrieve the entities
        
        // Statr the modification
        $em->flush();
        
        return new Response('OK');
    }
}
