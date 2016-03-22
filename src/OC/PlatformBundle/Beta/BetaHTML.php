<?php

namespace OC\PlatformBundle\Beta;

use Symfony\Component\HttpFoundation\Response;

/**
 * Class for add Beta word on pages
 * This service is used with listener
 *
 * @author      Christophe Malo
 * @version     1.0.0
 * @copyright   OpenClassrooms - Alexandre Bacco
 */

class BetaHTML {
    /**
     * Method to add 'beta' to a response
     * 
     * @param Response $response
     * @param integer $remainingDays
     * @return Response
     */
    public function displayBeta(Response $response, $remainingDays)
    {
        $content = $response->getContent();

        // A html code to add with the word beta
        $html = '<span style="color: red; font-size: 0.4em;"> - Beta J-' . (int) $remainingDays . '!</span>';

        // Insert the code in the page, in the first <h1>
        $content = preg_replace(
                '#<h1>(.*?)</h1>#iU', '<h1>$1' . $html . '</h1>', $content, 1
        );

        // Modify content in response
        $response->setContent($content);

        return $response;
    }
}
