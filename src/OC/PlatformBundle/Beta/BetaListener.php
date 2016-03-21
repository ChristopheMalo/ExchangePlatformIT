<?php

namespace OC\PlatformBundle\Beta;

use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Component\HttpKernel\HttpKernelInterface;

/**
 * The listener of the class BetaHTML
 *
 * @author      Christophe Malo
 * @version     1.0.0
 * @copyright   OpenClassrooms - Alexandre Bacco
 */

class BetaListener
{
    // The processor
    protected $betaHTML;
    
    /*
     * The end date of the beta:
     * - Before that date, show a countdown (J-3 , for example)
     * - After that date, remove 'beta'
     */
    protected $endDate;

    /**
     * The constructor
     * 
     * @param \OC\PlatformBundle\Beta\BetaHTML $betaHTML
     * @param Datetime $endDate
     */
    public function __construct(BetaHTML $betaHTML, $endDate)
    {
        $this->betaHTML = $betaHTML;
        $this->endDate = new \Datetime($endDate);
    }
    
    /**
     * Porcess changes
     * 
     * @param FilterResponseEvent $event
     * @return type
     */
    public function processBeta(FilterResponseEvent $event)
    {
        // test if the request is the main request (and not a sub-request)
        if (!$event->isMasterRequest())
        {
            return;
        }
        
        $remainingDays = $this->endDate->diff(new \Datetime())->format('%d');
        
        // If the date is exceeded, we do nothing
        if ($remainingDays <= 0)
        {
            return;
        }
        
        // use BetaHtml
        $response = $this->betaHTML->displayBeta($event->getResponse(), $remainingDays);
        
        // Modify the response
        
        // Then inserts the modified response in the event
        $event->setResponse($response);
    }
}
