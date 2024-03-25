<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class Salle extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = \Faker\Factory::create();

        for($i=0; $i<5;$i++){
            $salle = new \App\Entity\Salle();
            $salle->setNom($faker->name());
            $salle->setNbPlaces(random_int(40,100));
            $manager->persist($salle);
        }

        $manager->flush();
    }
}
