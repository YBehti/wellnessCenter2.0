<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\PostCode;


class PostCodeFixture extends Fixture
{
    public function load(ObjectManager $manager)
    {
        for($i=0;$i<10;$i++){

            $postCode = new PostCode();
            $postCode->setPostCode("4000"+"$i");
            $manager->persist($postCode);
        }


        $manager->flush();
    }
}
