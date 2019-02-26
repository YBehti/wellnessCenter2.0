<?php

namespace App\DataFixtures;

use App\Entity\Image;
use App\Entity\Locality;
use App\Entity\PostCode;
use App\Entity\Surfer;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class SurferFixtures extends Fixture
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        for($i=0;$i<40;$i++) { //crée 10 surfers dans un tableau
            $profile = new Image();
            $profile->setOrdre(1)
                ->setImage("https://res.cloudinary.com/behticloud/image/upload/v1551186275/samples/liza_2_1229.jpg")
                ->setType("profile");
            $manager->persist($profile);


            $postcode = new PostCode();
            $postcode->setPostCode("4000" + "$i");
            $manager->persist($postcode);
            $locality = new Locality();
            $locality->setLocality("Locality $i");
            $manager->persist($locality);


            $surfer = new Surfer();
            $surfer->addImage($profile);

            $surfer->setLocality($locality);
            $surfer->setPostCode($postcode);


            $surfer->setPassword($this->passwordEncoder->encodePassword($surfer,'toto'));
            $surfer->setEmail("email$i@hotmail.com");
            $surfer->setNewsletter(false);


            $surfer->setAdressStreet("street$i");
            $surfer->setName("surfer $i");
            $surfer->setFirstname("user $i");
            $surfer->setAdressNum("$i");
            $surfer->setRoles(['ROLE_USER']);
            $surfer->setRegistrationDate(new \DateTime());


            $manager->persist($surfer);
        }

        $manager->flush();
    }
}
