<?php

namespace OC\PlatformBundle\Bigbrother;

/**
 * This listener executs the censorship only when author is in pre-defined list
 *
 * @author      Christophe Malo
 * @version     1.0.0
 * @copyright   OpenClassrooms - Alexandre Bacco
 */

class CensorshipListener
{
    protected $processor;
    protected $listUsers = array();
    
    /**
     * 
     * @param \OC\PlatformBundle\Bigbrother\CensorshipProcessor $processor
     * @param array $listUsers
     */
    public function __construct(CensorshipProcessor $processor, $listUsers)
    {
        $this->processor = $processor;
        $this->listUsers = $listUsers;
    }
    
    /**
     * 
     * @param \OC\PlatformBundle\Bigbrother\MessagePostEvent $event
     */
    public function processMessage(MessagePostEvent $event)
    {
        // monitoring is activated if the author of the message is in the list
        if (in_array($event->getUser()->getId(), $this->listUsers))
        {
            // Send email to administrator
            $this->processor->notifyEmail($event->getMessage(), $event->getUser());

            // Censor the message
            $message = $this->processor->censorMessage($event->getMessage());
            // Save the censored message in the event
            $event->setMessage($message);
        }
    }
}
