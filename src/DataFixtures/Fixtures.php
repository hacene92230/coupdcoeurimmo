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
                ->setAddress($u . " rue " . " du fobourg");
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
        foreach ($owners as $owner) {
            for ($k = 0; $k < 2; $k++) { // Création de 2 biens pour chaque propriétaire
                $property = new Properties();
                $property->setTitle("bien" . $k)
                    ->setContent("contenu" . $k)
                    ->setCreatedAt(new DateTimeImmutable())
                    ->setRoomNumber(rand(3, 10))
                    ->setHousingType(rand(0, 1))
                    ->setTransactionType(rand(0, 1))
                    ->setRent(rand(550, 900))
                    ->setPrice(rand(100000, 900000))
                    ->setGarden(rand(0, 1))
                    ->setAddress($k . " rue du logement " . $k)
                    ->setUser($owner); // Assignation du propriétaire pour chaque bien créé
                $manager->persist($property);
                $properties[] = $property;
            }
        }
        $manager->flush();
    }
}
