<?php

namespace OC\PlatformBundle\Antispam;

/**
 * Class for antispam service
 *
 * @author      Christophe Malo
 * @version     1.0.0
 * @copyright   OpenClassrooms - Alexandre Bacco
 */

class OCAntispam
{
    private $mailer;
    private $locale;
    private $minLength;
    
    public function __construct(\Swift_Mailer $mailer, $locale, $minLength)
    {
        $this->mailer    = $mailer;
        $this->locale    = $locale;
        $this->minLength = (int) $minLength;
    }
    
    /**
     * Checks if text is spam or not
     * 
     * @param string $text
     * @return bool
     */
    public function isSpam($text)
    {
        return strlen($text) < $this->minLength;
    }
}
