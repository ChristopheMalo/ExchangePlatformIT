<?php

// src/OC/UserBundle/DataFixtures/ORM/LoadUser.php

namespace OC\UserBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use OC\UserBundle\Entity\User;

/**
 * Loads user datas in DB - Fixtures
 * 
 * @author      Christophe Malo
 * @version     1.0.0
 * @copyright   OpenClassrooms - Alexandre Bacco
 */

class LoadUser implements FixtureInterface
{
    /**
     * Load user datas into DB
     * 
     * @param ObjectManager $manager Object $manager of EntityManager
     */
    public function load(ObjectManager $manager)
    {
        // Usernames to create
        $listNames = array('Alexandre', 'Marine', 'Anna');

        foreach ($listNames as $name)
        {
            // Create user
            $user = new User;

            // The username and password are the same
            $user->setUsername($name);
            $user->setPassword($name);

            // Not use Salt for the moment
            $user->setSalt('');
            // Define the role ROLE_USER which is the basic role
            $user->setRoles(array('ROLE_USER'));

            // Persist the user
            $manager->persist($user);
        }

        // Start the recording (insert into DB)
        $manager->flush();
    }
}
