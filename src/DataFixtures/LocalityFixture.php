<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Locality;

class LocalityFixture extends Fixture
{
    public function load(ObjectManager $manager)
    {
        for($i=0;$i<10;$i++){

            $locality = new Locality();
            $locality->setLocality("locality $i");
            $manager->persist($locality);
        }


        $manager->flush();
    }
}
