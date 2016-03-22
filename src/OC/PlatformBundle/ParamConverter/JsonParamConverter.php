<?php

namespace OC\PlatformBundle\ParamConverter;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * A JSON Converter with ParamConverter
 *
 * @author      Christophe Malo
 * @version     1.0.0
 * @copyright   OpenClassrooms - Alexandre Bacco
 */

class JsonParamConverter implements ParamConverterInterface
{
    /**
     * 
     * @param ParamConverter $configuration
     * @return boolean
     */
    function supports(ParamConverter $configuration)
    {
        // If the name of the controller's argument is " json ",
        // it does not apply the converter
        if ('json' !== $configuration->getName())
        {
            return false;
        }

        return true;
    }
    
    /**
     * create a query attribute,
     * which will be injected into the argument of controller method
     * 
     * @param Request $request
     * @param ParamConverter $configuration
     */
    function apply(Request $request, ParamConverter $configuration)
    {
        // Retireve the current value of attribute
        $json = $request->attributes->get('json');

        // Action : decode
        $json = json_decode($json, true);

        // Update the new value of attribute
        $request->attributes->set('json', $json);
    }

}
