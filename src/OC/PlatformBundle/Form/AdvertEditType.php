<?php

namespace OC\PlatformBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * Form builder for edit Advert,
 * this class defines the form (the fields of the form)
 * 
 * Class representing a job offer
 * This class contains lyfe cycle callbacks
 * 
 * @author      Christophe Malo
 * @version     1.0.0
 * @copyright   OpenClassrooms - Alexandre Bacco
 */

class AdvertEditType extends AbstractType
{
    /**
     * Build the form
     * 
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->remove('date');
    }

    /**
     * Get name of form
     * 
     * @return string
     */
    public function getName()
    {
        return 'oc_platformbundle_advert_edit';
    }
    
    /**
     * Get parent of form
     * 
     * @return \OC\PlatformBundle\Form\AdvertType
     */
    public function getParent()
    {
        return new AdvertType();
    }
}
