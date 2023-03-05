<?php

namespace App\DataFixtures;

use App\Entity\User;
use DateTimeImmutable;
use App\Entity\Address;
use App\Entity\Contact;
use App\Entity\Properties;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
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
        //création des adresses
        $adresses = [];
        for ($a = 0; $a <= 20; $a++) {
            $address = new Address();
            $address->setCity("ville" . $a)
                ->setPlaceType("lieu" . $a)
                ->setZipCode(rand(1, 93000));
            $manager->persist($address);
            $adresses[] = $address;
        }

        // création des utilisateurs 
        $users = [];
        $owners = [];
        for ($u = 0; $u <= 30; $u++) {
            $user = new User();
            $user->setName("nom" . $u)
                ->setEmail("email" . $u . "@gmail.com");
            if ($u == 0) {
                $user->setRoles(["ROLE_ADMIN"]);
            } else if ($u <= 10) {
                $user->setRoles(["ROLE_OWNER"]);
                $owners[] = $user;
            } else if ($u <= 20) {
                $user->setRoles(["ROLE_USER"]);
            } else {
                $user->setRoles(["ROLE_TENANT"]);
            }
            $user->setPassword($this->hash->hashPassword($user, 'password')) // "hashPassword" avec minuscule "h"
                ->setCreatedAt(new DateTimeImmutable())
                ->setPhone("0612131415")
                ->setAddress($adresses[rand(0, 20)]);
            $manager->persist($user);
            $users[] = $user;
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

        //Création des biens avec des propriétaires ayant le rôle "ROLE_HOWNER"
        $properties = [];
        foreach ($owners as $key => $owner) {
            for ($k = 0; $k < 2; $k++) { // Création de 2 biens pour chaque propriétaire
                $property = new Properties();
                $property->setTitle("bien" . $key)
                    ->setContent("contenu" . $key)
                    ->setCreatedAt(new DateTimeImmutable())
                    ->setRoomNumber(rand(3, 10))
                    ->setHousingType(rand(0, 1))
                    ->setTransactionType(rand(0, 1))
                    ->setRent(rand(550, 900))
                    ->setPrice(rand(100000, 900000))
                    ->setGarden(rand(0, 1))
                    ->setHarea(rand(10, 350))
                    ->setAddress($adresses[rand(0, 20)])
                    ->setUser($owner);
                $manager->persist($property);
                $properties[] = $property;
            }
        }
        $manager->flush();
    }
}
