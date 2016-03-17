<?php

namespace OC\PlatformBundle\Antispam;

/**
 * Class for antispam service
 * How to use the service? :
 * {{ checkIfSpam(var) }} in twig is like $this->isSpam($var) in service
 *
 * @author      Christophe Malo
 * @version     1.0.0
 * @copyright   OpenClassrooms - Alexandre Bacco
 */

class OCAntispam extends \Twig_Extension
{
    private $mailer;
    private $locale; // Optional
    private $minLength;
    
    public function __construct(\Swift_Mailer $mailer, /*$locale,*/ $minLength)
    {
        $this->mailer    = $mailer;
        //$this->locale    = $locale;
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
    
    /**
     * Add function(s) to the service (OCAntispam)
     * 
     * @return array
     */
    public function getFunctions()
    {
        return array(
            'checkIfSpam' => new \Twig_Function_Method($this, 'isSpam')
        );
    }
    
    /**
     * Identify the twig extension
     * 
     * @return string
     */
    public function getName()
    {
        return 'OCAntispam';
    }
    
    /**
     * Setter because $local is removed from the constructor
     * 
     * @param type $locale
     */
    public function setLocale($locale)
    {
        $this->local = $locale;
    }
}
