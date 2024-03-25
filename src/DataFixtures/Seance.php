<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
;

class Seance extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = \Faker\Factory::create();
        $faker->addProvider(new \Xylis\FakerCinema\Provider\Movie($faker));

        for($i=0; $i<10;$i++){
            $seance = new \App\Entity\Seance();
            $seance->setDateProj($faker->dateTime);
            $seance->setTarifNormal(random_int(10,15));
            $seance->setTarifReduit(random_int(2.5,7));
            $manager->persist($seance);
        }
        $manager->flush();
    }
}
