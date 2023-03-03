<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;



class Fixtures extends Fixture
{
    public function load(ObjectManager $manager): void


    {
       
       // creation des biens 
        for($k=0; $k<20; $k++){
            $user= New user();
            $user->setName("nom".$k)
                -> setEmail("email".$k."@gmail.com")
                ->setPassword($this->encoder->encodePassword($user[$k], 'password'));

        $manager->persist($user);
        }

        $manager->flush();
    }
}
