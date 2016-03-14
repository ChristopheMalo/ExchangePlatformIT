<?php

namespace OC\PlatformBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use OC\PlatformBundle\Entity\Skill;

/**
 * Loads categories datas in DB - Fixtures
 * 
 * @author      Christophe Malo
 * @version     1.0.0
 * @copyright   OpenClassrooms - Alexandre Bacco
 */

class LoadSkill implements FixtureInterface
{
    /**
     * Loads skill datas into DB
     * 
     * @param ObjectManager $manager Object $manager of EntityManager
     */
    public function load(ObjectManager $manager)
    {
        // The list of all skills
        $names = array('PHP', 'Symfony2', 'C++', 'Java', 'Photoshop', 'Blender', 'Bloc-note');

        foreach ($names as $name) {
            // Create the skill
            $skill = new Skill();
            $skill->setName($name);

            // Persist the skill
            $manager->persist($skill);
        }

        // Start the recording (insert into DB) of all skills
        $manager->flush();
    }
}
