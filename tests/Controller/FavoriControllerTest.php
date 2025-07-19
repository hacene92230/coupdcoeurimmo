<?php

namespace App\Tests\Controller;

use App\Entity\User;
use App\Entity\Properties;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class FavoriControllerTest extends WebTestCase
{
    public function testAddFavori()
    {
        $client = static::createClient();
        $userRepository = static::$container->get('doctrine')->getRepository(User::class);
        $propertyRepository = static::$container->get('doctrine')->getRepository(Properties::class);

        // retrieve the test user
        $testUser = $userRepository->findOneByEmail('test@test.com');
        $property = $propertyRepository->findOneBy([]);

        // simulate being logged in as the test user
        $client->loginUser($testUser);

        // request the add favori page
        $client->request('GET', '/favori/add/' . $property->getId());

        // assertions
        $this->assertResponseRedirects();
        $crawler = $client->followRedirect();
        $this->assertCount(1, $crawler->filter('a.btn-danger'));
    }

    public function testRemoveFavori()
    {
        $client = static::createClient();
        $userRepository = static::$container->get('doctrine')->getRepository(User::class);
        $favoriRepository = static::$container->get('doctrine')->getRepository(Favori::class);

        // retrieve the test user
        $testUser = $userRepository->findOneByEmail('test@test.com');
        $favori = $favoriRepository->findOneBy(['user' => $testUser]);


        // simulate being logged in as the test user
        $client->loginUser($testUser);

        // request the remove favori page
        $client->request('GET', '/favori/remove/' . $favori->getId());

        // assertions
        $this->assertResponseRedirects();
        $crawler = $client->followRedirect();
        $this->assertCount(1, $crawler->filter('a.btn-outline-primary'));
    }
}
