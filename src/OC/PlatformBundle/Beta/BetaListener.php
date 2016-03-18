<?php

namespace OC\PlatformBundle\Beta;

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
     * 
     *
     */
    public function processBeta()
    {
        $remainingDays = $this->endDate->diff(new \Datetime())->format('%d');

        if ($remainingDays <= 0) {
            // Si la date est dépassée, on ne fait rien
            return;
        }

        // Call the method - later
        // $this->betaHTML->displayBeta()
    }
}
