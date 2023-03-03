<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class Fixtures extends Fixture
{
    private $encoder;
    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
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
            $user->setPassword($this->encoder->encodePassword($user, 'password'));
            $manager->persist($user);
        }
        $manager->flush();
    }
}
