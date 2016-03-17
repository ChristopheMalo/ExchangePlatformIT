<?php

namespace OC\PlatformBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class to use CK Editor with textarea
 * 
 * @author      Christophe Malo
 * @version     1.0.0
 * @copyright   OpenClassrooms - Alexandre Bacco
 */

class CKeditorType extends AbstractType
{
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'attr' => array('class' => 'ckeditor') // Add the css class
        ));
    }

    public function getParent() // Use inherit form
    { 
        return 'textarea';
    }

    public function getName()
    {
        return 'ckeditor';
    }

}
