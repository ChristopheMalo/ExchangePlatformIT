<?php

namespace OC\PlatformBundle\Bigbrother;

use Symfony\Component\Security\Core\User\UserInterface;

/**
 * A listener
 *
 * @author      Christophe Malo
 * @version     1.0.0
 * @copyright   OpenClassrooms - Alexandre Bacco
 */

class CensorshipProcessor
{
    protected $mailer;
    
    /**
     * Constructor
     */
    public function __construct(\Swift_Mailer $mailer)
    {
        $this->mailer = $mailer;
    }

    /**
     * Method to notify the administrator via email
     * 
     * @param string $message
     * @param \OC\PlatformBundle\Bigbrother\UserInterface $user
     */
    public function notifyEmail($message, UserInterface $user)
    {
        $message = \Swift_Message::newInstance()
                ->setSubject("Nouveau message d'un utilisateur surveillé")
                ->setFrom('admin@votresite.com')
                ->setTo('admin@votresite.com')
                ->setBody("L'utilisateur surveillé '" . $user->getUsername() . "' a posté le message suivant : '" . $message . "'");

        $this->mailer->send($message);
    }
    
    /**
     * Method to censor a message (remove the banned words)
     * 
     * @param string $message
     * @return string $message
     */
    public function censorMessage($message)
    {
        $message = str_replace(array('top secret', 'mot interdit'), '', $message);

        return $message;
    }
}
