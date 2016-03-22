<?php

namespace OC\PlatformBundle\Bigbrother;

use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * The event class
 * The event manager sends this class to the listeners
 *
 * @author      Christophe Malo
 * @version     1.0.0
 * @copyright   OpenClassrooms - Alexandre Bacco
 */

class MessagePostEvent extends Event
{
    /**
     * The message of user
     * 
     * @var string
     */
    protected $message;
    
    /**
     * The author of message
     * 
     * @var string
     */
    protected $user;
    
    /**
     * The constructor
     * 
     * @param string $message
     * @param \OC\PlatformBundle\Bigbrother\UserInterface $user
     */
    public function __construct($message, UserInterface $user)
    {
        $this->message = $message;
        $this->user = $user;
    }

    /**
     * Get the message
     * The listener must have access to the message
     * 
     * @return string $message
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Set the message
     * The listener must be able to edit the message
     * 
     * @param string $message
     * @return string $message
     */
    public function setMessage($message)
    {
        return $this->message = $message;
    }

    /**
     * Get User
     * The listener must have access to the user
     * 
     * @return $user
     */
    public function getUser()
    {
        return $this->user;
    }

    // No setUser, the listener can not change the author of the message!
}
