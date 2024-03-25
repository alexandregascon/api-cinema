<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
;

class Film extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = \Faker\Factory::create();
        $faker->addProvider(new \Xylis\FakerCinema\Provider\Movie($faker));

        for($i=0; $i<10;$i++){
            $film = new \App\Entity\Film();
            $film->setTitre($faker->movie);
            $film->setDuree(random_int(80,150));
            $manager->persist($film);
        }

        $manager->flush();
    }
}
