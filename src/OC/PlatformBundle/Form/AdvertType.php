<?php

namespace OC\PlatformBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Form builder for add Advert,
 * this class defines the form (the fields of the form)
 * 
 * Class representing a job offer
 * This class contains lyfe cycle callbacks
 * 
 * @author      Christophe Malo
 * @version     1.0.0
 * @copyright   OpenClassrooms - Alexandre Bacco
 */

class AdvertType extends AbstractType
{
    /**
     * Build the form
     * 
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('date',      'date')
            ->add('title',     'text')
            ->add('author',    'text')
            ->add('content',   'textarea')
            ->add('published', 'checkbox', array('required' => false))
            ->add('image',     new ImageType())
            ->add('categories', 'collection', array(
                'type'          => new CategoryType(),
                'allow_add'     => true,
                'allow_delete'  => true
            ))
            ->add('save',      'submit')
        ;
    }
    
    /**
     * Set the options
     * 
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'OC\PlatformBundle\Entity\Advert'
        ));
    }

    /**
     * Get the name of form
     * 
     * @return string
     */
    public function getName()
    {
        return 'oc_platformbundle_advert';
    }
}
