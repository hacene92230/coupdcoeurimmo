<?php

namespace App\Test\Controller;

use App\Entity\Rental;
use App\Repository\RentalRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class RentalControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private RentalRepository $repository;
    private string $path = '/rental/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->repository = (static::getContainer()->get('doctrine'))->getRepository(Rental::class);

        foreach ($this->repository->findAll() as $object) {
            $this->repository->remove($object, true);
        }
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Rental index');

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
            'rental[dateStart]' => 'Testing',
            'rental[dateEnd]' => 'Testing',
            'rental[tenant]' => 'Testing',
            'rental[property]' => 'Testing',
        ]);

        self::assertResponseRedirects('/rental/');

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Rental();
        $fixture->setDateStart('My Title');
        $fixture->setDateEnd('My Title');
        $fixture->setTenant('My Title');
        $fixture->setProperty('My Title');

        $this->repository->add($fixture, true);

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Rental');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Rental();
        $fixture->setDateStart('My Title');
        $fixture->setDateEnd('My Title');
        $fixture->setTenant('My Title');
        $fixture->setProperty('My Title');

        $this->repository->add($fixture, true);

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'rental[dateStart]' => 'Something New',
            'rental[dateEnd]' => 'Something New',
            'rental[tenant]' => 'Something New',
            'rental[property]' => 'Something New',
        ]);

        self::assertResponseRedirects('/rental/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getDateStart());
        self::assertSame('Something New', $fixture[0]->getDateEnd());
        self::assertSame('Something New', $fixture[0]->getTenant());
        self::assertSame('Something New', $fixture[0]->getProperty());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();

        $originalNumObjectsInRepository = count($this->repository->findAll());

        $fixture = new Rental();
        $fixture->setDateStart('My Title');
        $fixture->setDateEnd('My Title');
        $fixture->setTenant('My Title');
        $fixture->setProperty('My Title');

        $this->repository->add($fixture, true);

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertSame($originalNumObjectsInRepository, count($this->repository->findAll()));
        self::assertResponseRedirects('/rental/');
    }
}
