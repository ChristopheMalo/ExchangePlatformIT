<?php

namespace OC\PlatformBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use OC\PlatformBundle\Entity\Category;

/**
 * Loads categories datas in DB - Fixtures
 * 
 * @author      Christophe Malo
 * @version     1.0.0
 * @copyright   OpenClassrooms - Alexandre Bacco
 */

class LoadCategory implements FixtureInterface
{
    /**
     * Loads categories datas into DB
     * 
     * @param ObjectManager $manager Object $manager of EntityManager
     */
    public function load(ObjectManager $manager)
    {
        // The list of all categories
        $names = array(
            'Web development',
            'Mobile development',
            'Web design',
            'Frontend development',
            'Network'
        );
        
        foreach ($names as $name)
        {
            // Create the category
            $category = new Category();
            $category->setName($name);
            
            // Persist the category
            $manager->persist($category);
        }
        
        // Start the recording (insert into DB) of all categories
        $manager->flush();
    }
}
