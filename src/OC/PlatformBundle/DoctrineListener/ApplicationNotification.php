<?php

namespace OC\PlatformBundle\DoctrineListener;

use Doctrine\ORM\Event\LifecycleEventArgs;
use OC\PlatformBundle\Entity\Application;

/**
 * Class for doctrine listener service
 * This service (object) send email to job offer manager
 * when candidate send an application for job offer
 * 
 * @author      Christophe Malo
 * @version     1.0.0
 * @copyright   OpenClassrooms - Alexandre Bacco
 */

class ApplicationNotification
{
    private $mailer;

    public function __construct(\Swift_Mailer $mailer)
    {
        $this->mailer = $mailer;
    }

    public function postPersist(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        // send an email just for entities Application
        if (!$entity instanceof Application) {
            return;
        }

        $message = new \Swift_Message(
            'New application', 'You have received a new application.'
        );

        $message
            // Deactivated to add job offer
            //->addTo($entity->getAdvert()->getAuthor()) // should be an attribute "email", use "author" instead
            //->addFrom('admin@votresite.com')
        ;

        $this->mailer->send($message);
    }
}
