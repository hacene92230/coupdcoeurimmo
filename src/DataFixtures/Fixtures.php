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
        
        for($k=0; $k<20; $k++){
            $contact = New Contact();
            $contact-> setName("nom".$k)
                    ->setEmail("email".$k."@gmail.com")
                    ->setSubject("subject".$k)
                    ->setContent("content".$k)
                    ->setPhone("0612131415")
                    ->setCreatedAt(new DateTimeImmutable());
            $manager->persist($contact);
        }
        for($k=0; $k<20; $k++){
            $properties = New Properties();
            $properties->setTitle("titre".$k)
                        ->setContent("contenu".$k)
                        ->setCreatedAt(new DateTimeImmutable())
                        -> setRoomNumber("numChambre".$k)
                        ->setSale("vente".$k)
                        ->setRent("location".$k)
                        ->setRental("loyer".$k)
                        ->setPrice("prix".$k)
                        ->setGarden("jardin".$k)
                        ->setHouse("maison".$k)
                        ->setApartment("appartemment".$k);
                $manager->persist($properties);

        }
        $manager->flush();
    }
}
