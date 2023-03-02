<?php

namespace App\Test\Controller;

use App\Entity\Properties;
use App\Repository\PropertiesRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PropertiesControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private PropertiesRepository $repository;
    private string $path = '/properties/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->repository = (static::getContainer()->get('doctrine'))->getRepository(Properties::class);

        foreach ($this->repository->findAll() as $object) {
            $this->repository->remove($object, true);
        }
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Property index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    }

    public function testNew(): void
    {
        $originalNumObjectsInRepository = count($this->repository->findAll());

        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'property[roomNumber]' => 'Testing',
            'property[sale]' => 'Testing',
            'property[rental]' => 'Testing',
            'property[rent]' => 'Testing',
            'property[price]' => 'Testing',
            'property[garden]' => 'Testing',
            'property[house]' => 'Testing',
            'property[apartment]' => 'Testing',
            'property[title]' => 'Testing',
            'property[content]' => 'Testing',
        ]);

        self::assertResponseRedirects('/properties/');

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Properties();
        $fixture->setRoomNumber('My Title');
        $fixture->setSale('My Title');
        $fixture->setRental('My Title');
        $fixture->setRent('My Title');
        $fixture->setPrice('My Title');
        $fixture->setGarden('My Title');
        $fixture->setHouse('My Title');
        $fixture->setApartment('My Title');
        $fixture->setTitle('My Title');
        $fixture->setContent('My Title');

        $this->repository->add($fixture, true);

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Property');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Properties();
        $fixture->setRoomNumber('My Title');
        $fixture->setSale('My Title');
        $fixture->setRental('My Title');
        $fixture->setRent('My Title');
        $fixture->setPrice('My Title');
        $fixture->setGarden('My Title');
        $fixture->setHouse('My Title');
        $fixture->setApartment('My Title');
        $fixture->setTitle('My Title');
        $fixture->setContent('My Title');

        $this->repository->add($fixture, true);

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'property[roomNumber]' => 'Something New',
            'property[sale]' => 'Something New',
            'property[rental]' => 'Something New',
            'property[rent]' => 'Something New',
            'property[price]' => 'Something New',
            'property[garden]' => 'Something New',
            'property[house]' => 'Something New',
            'property[apartment]' => 'Something New',
            'property[title]' => 'Something New',
            'property[content]' => 'Something New',
        ]);

        self::assertResponseRedirects('/properties/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getRoomNumber());
        self::assertSame('Something New', $fixture[0]->getSale());
        self::assertSame('Something New', $fixture[0]->getRental());
        self::assertSame('Something New', $fixture[0]->getRent());
        self::assertSame('Something New', $fixture[0]->getPrice());
        self::assertSame('Something New', $fixture[0]->getGarden());
        self::assertSame('Something New', $fixture[0]->getHouse());
        self::assertSame('Something New', $fixture[0]->getApartment());
        self::assertSame('Something New', $fixture[0]->getTitle());
        self::assertSame('Something New', $fixture[0]->getContent());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();

        $originalNumObjectsInRepository = count($this->repository->findAll());

        $fixture = new Properties();
        $fixture->setRoomNumber('My Title');
        $fixture->setSale('My Title');
        $fixture->setRental('My Title');
        $fixture->setRent('My Title');
        $fixture->setPrice('My Title');
        $fixture->setGarden('My Title');
        $fixture->setHouse('My Title');
        $fixture->setApartment('My Title');
        $fixture->setTitle('My Title');
        $fixture->setContent('My Title');

        $this->repository->add($fixture, true);

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertSame($originalNumObjectsInRepository, count($this->repository->findAll()));
        self::assertResponseRedirects('/properties/');
    }
}
