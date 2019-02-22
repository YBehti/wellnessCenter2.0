<?php

namespace App\DataFixtures;

use App\Entity\Locality;
use App\Entity\PostCode;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AdminFixture extends Fixture
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }
    public function load(ObjectManager $manager)


    {

        $postcode = new PostCode();
        $postcode->setPostCode("4002");
        $manager->persist($postcode);
        $locality = new Locality();
        $locality->setLocality("Locality1");
        $manager->persist($locality);

        $admin = new User();
        $admin->setRoles(['ROLE_ADMIN']);
        $admin->setPassword($this->passwordEncoder->encodePassword($admin,'admin'));
        $admin->setEmail('admin@admin.com');
        $admin->setAdressNum('2');
        $admin->setAdressStreet('admin');
        $admin->setLocality($locality);
        $admin->setPostCode($postcode);



        $manager->persist($admin);
        $manager->flush();
    }
}
