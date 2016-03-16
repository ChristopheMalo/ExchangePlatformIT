<?php

namespace OC\PlatformBundle\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * The constraint to fight against flood
 * 
 * @author      Christophe Malo
 * @version     1.0.0
 * @copyright   OpenClassrooms - Alexandre Bacco
 */

/**
 * @Annotation
 */
class Antiflood extends Constraint
{
    public $message = 'You have already posted a message there less than 15 seconds, thank you to wait a bit.';
}
