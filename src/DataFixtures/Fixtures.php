<?php

namespace App\DataFixtures;

use App\Entity\Contact;
use App\Entity\User;
use App\Entity\Properties;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;


class Fixtures extends Fixture
{
    private $hash;
    public function __construct(UserPasswordHasherInterface $userPasswordHasher)
    {
        $this->hash = $userPasswordHasher;
    }

    public function load(ObjectManager $manager): void


    {

        // creation des biens 
        for ($k = 0; $k <= 20; $k++) {
            $user = new User();
            $user->setName("nom" . $k)
                ->setEmail("email" . $k . "@gmail.com");
            if ($k == 0) {
                $user->setRoles(["ROLE_ADMIN"]);
            } else {
                $user->setRoles(["ROLE_USER"]);
            }
            $user->setPassword($this->hash->HashPassword($user, 'password'))
                ->setCreatedAt(new DateTimeImmutable())
                ->setPhone("0612131415");
            $manager->persist($user);
        }

        //Création des contacts
        for ($k = 0; $k < 20; $k++) {
            $contact = new Contact();
            $contact->setName("nom" . $k)
                ->setEmail("email" . $k . "@gmail.com")
                ->setSubject("subject" . $k)
                ->setContent("content" . $k)
                ->setPhone("0612131415")
                ->setCreatedAt(new DateTimeImmutable())
                ->setResolved(rand(0, 1));
            $manager->persist($contact);
        }

        //Création des biens
        for ($k = 0; $k < 20; $k++) {
            $properties = new Properties();
            $properties->setTitle("titre" . $k)
                ->setContent("contenu" . $k)
                ->setCreatedAt(new DateTimeImmutable())
                ->setRoomNumber(rand(3, 10))
                ->setSale(rand(0, 1))
                ->setRent(rand(0, 1))
                ->setRental(rand(550, 900))
                ->setPrice(rand(100000, 900000))
                ->setGarden(rand(0, 1))
                ->setHouse(rand(0, 1))
                ->setApartment(rand(0, 1));
            $manager->persist($properties);
        }
        $manager->flush();
    }
}
