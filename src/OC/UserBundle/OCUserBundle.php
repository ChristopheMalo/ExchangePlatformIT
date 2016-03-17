<?php

namespace OC\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * OCUserBundle
 * 
 * @author      Christophe Malo
 * @version     1.0.0
 * @copyright   OpenClassrooms - Alexandre Bacco
 */

class OCUserBundle extends Bundle
{
    /**
     * Retiurn FOSUserBundle
     * 
     * @return string
     */
    public function getParent()
    {
        return 'FOSUserBundle';
    }
}
