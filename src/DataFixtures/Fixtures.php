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
        for ($k = 0; $k <= 20; $k++) {
            $user = new User();
            $user->setName("nom" . $k)
                ->setEmail("email" . $k . "@gmail.com");
            if ($k == 0) {
                $user->setRoles(["ROLE_ADMIN"]);
            } else if ($k <= 10) {
                $user->setRoles(["ROLE_OWNER"]);
                $owners[] = $user;
            } else {
                $user->setRoles(["ROLE_USER"]);
            }
            $user->setPassword($this->hash->hashPassword($user, 'password')) // "hashPassword" avec minuscule "h"
                ->setCreatedAt(new DateTimeImmutable())
                ->setPhone("0612131415");
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
                $property->setTitle("titre" . $k)
                    ->setContent("contenu" . $k)
                    ->setCreatedAt(new DateTimeImmutable())
                    ->setRoomNumber(rand(3, 10))
                    ->setHousingType(rand(0, 1))
                    ->setTransactionType(rand(0, 1))
                    ->setRent(rand(550, 900))
                    ->setPrice(rand(100000, 900000))
                    ->setGarden(rand(0, 1))
                    ->setUser($owner); // Assignation du propriétaire pour chaque bien créé
                $manager->persist($property);
                $properties[] = $property;
            }
        }
        $manager->flush();
    }
}
