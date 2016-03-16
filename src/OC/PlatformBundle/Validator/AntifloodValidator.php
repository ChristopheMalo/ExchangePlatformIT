<?php

namespace OC\PlatformBundle\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

/**
 * The validator to fight against flood
 * Valid the constraint Antiflood
 * 
 * @author      Christophe Malo
 * @version     1.0.0
 * @copyright   OpenClassrooms - Alexandre Bacco
 */

/**
 * @Annotation
 */
class AntifloodValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint)
    {
        if (strlen($value) < 3)
        {
            $this->context->addViolation($constraint->message);
        }
    }
}
