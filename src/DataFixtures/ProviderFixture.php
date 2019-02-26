<?php

namespace App\DataFixtures;


use App\Entity\Service;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Provider;
use App\Entity\Locality;
use App\Entity\PostCode;
use App\Entity\Image;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class ProviderFixture extends Fixture
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }
    public function load(ObjectManager $manager)
    {
        for($i=0;$i<10;$i++){ //crée 10 services dans un tableau

            $service = new Service();
            $service->setName("Service$i");
            $service->setDescription("This is the description for the service $i");
            $vitrine = new Image();
            $vitrine->setImage("http://res.cloudinary.com/behticloud/image/upload/c_scale,w_149/v1543342155/samples/massage-therapy.jpg");
            $vitrine->setType("vitrine");
            $vitrine->setOrdre(1);

            $manager->persist($vitrine);
            $service->setVitrine($vitrine);
            $array[$i]=$service;
            $manager->persist($service);

        }

        for($i=0;$i<40;$i++){ //crée 10 providers dans un tableau
            $profile = new Image();
            $profile->setOrdre(1)
                    ->setImage("https://res.cloudinary.com/behticloud/image/upload/v1543342253/samples/original.jpg")
                    ->setType("profile");
            $manager->persist($profile);
            $logo = new Image();
            $logo->setOrdre(1)
                 ->setImage("https://res.cloudinary.com/behticloud/image/upload/v1543344616/logo-ex-7.png")
                 ->setType("logo");
            $manager->persist($logo);

            $postcode = new PostCode();
            $postcode->setPostCode("4000"+"$i");
            $manager->persist($postcode);
            $locality = new Locality();
            $locality->setLocality("Locality $i");
            $manager->persist($locality);


            $provider= new Provider();
            $rand=rand(1,3);
            for($j=0;$j<$rand;$j++){ //fourni un nombre aléatoir de service choisi aléatoirement dans le tableau de servcies

                $provider->addService($array[rand(0,9)]);
            }

            $provider->addImage($profile);
            $provider->addImage($logo);
            $provider->setLocality($locality);
            $provider->setPostCode($postcode);

            $provider->setWebsite("https://website$i.com");
            $provider->setPhoneNumber("0$i/999999");
            $provider->setPassword($this->passwordEncoder->encodePassword($provider,'toto'));
            $provider->setEmail("email$i@gmail.com");

            $provider->setAdressStreet("street$i");
            $provider->setName("provider $i");
            $provider->setAdressNum("$i");
            $provider->setRoles(['ROLE_VENDOR']);

            $provider->setEmailPro("emailPro$i@gmail.com");



            $provider->setVATNumber("0000000000$i");
            $manager->persist($provider);
        }


        $manager->flush();
    }
}
