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
    /**
     * Checks if text is spam or not
     * 
     * @param string $text
     * @return bool
     */
    public function isSpam($text)
    {
        return strlen($text) < 50;
    }
}
