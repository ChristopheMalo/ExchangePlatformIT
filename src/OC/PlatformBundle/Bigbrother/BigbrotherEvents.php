<?php

namespace OC\PlatformBundle\Bigbrother;

/**
 * This class makes the correspondence
 * between BigbrotherEvents::onMessagePost
 * (use to trigger the event) and the name
 * of the event itself item2 oc_platform.bigbrother.post_message
 * This class defines the events list
 *
 * @author      Christophe Malo
 * @version     1.0.0
 * @copyright   OpenClassrooms - Alexandre Bacco
 */

final class BigbrotherEvents
{
    const onMessagePost = 'oc_platform.bigbrother.post_message';
}
