<?php

namespace OC\PlatformBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
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
            ->add('content',   'ckeditor')
            ->add('image',     new ImageType())
            ->add('categories', 'entity', array(
                'class'    => 'OCPlatformBundle:Category',
                'property' => 'name',
                'multiple' => true,
                'expanded' => false
            ))
            ->add('save',      'submit')
        ;
        
        // Add function to listen PRE_SET_DATA event
        $builder->addEventListener(
            FormEvents::PRE_SET_DATA, function(FormEvent $event) {
            
            // Retrieve underlying Advert Object
            $advert = $event->getData();

            if (null === $advert)
            {
                return;
            }

            if (!$advert->getPublished() || null === $advert->getId())
            {
                $event->getForm()->add('published', 'checkbox', array('required' => false));
            }
            else
            {
                $event->getForm()->remove('published');
            }
        }
        );
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
