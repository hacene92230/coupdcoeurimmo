<?php

namespace App\Test\Controller;

use App\Entity\RentalApplication;
use App\Repository\RentalApplicationRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class RentalApplicationControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private RentalApplicationRepository $repository;
    private string $path = '/rental/application/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->repository = (static::getContainer()->get('doctrine'))->getRepository(RentalApplication::class);

        foreach ($this->repository->findAll() as $object) {
            $this->repository->remove($object, true);
        }
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('RentalApplication index');

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
            'rental_application[idCard]' => 'Testing',
            'rental_application[taxForm]' => 'Testing',
            'rental_application[payStub]' => 'Testing',
            'rental_application[proofResidence]' => 'Testing',
            'rental_application[guarantorPayStub]' => 'Testing',
            'rental_application[guarantor]' => 'Testing',
        ]);

        self::assertResponseRedirects('/rental/application/');

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new RentalApplication();
        $fixture->setIdCard('My Title');
        $fixture->setTaxForm('My Title');
        $fixture->setPayStub('My Title');
        $fixture->setProofResidence('My Title');
        $fixture->setGuarantorPayStub('My Title');
        $fixture->setGuarantor('My Title');

        $this->repository->add($fixture, true);

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('RentalApplication');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new RentalApplication();
        $fixture->setIdCard('My Title');
        $fixture->setTaxForm('My Title');
        $fixture->setPayStub('My Title');
        $fixture->setProofResidence('My Title');
        $fixture->setGuarantorPayStub('My Title');
        $fixture->setGuarantor('My Title');

        $this->repository->add($fixture, true);

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'rental_application[idCard]' => 'Something New',
            'rental_application[taxForm]' => 'Something New',
            'rental_application[payStub]' => 'Something New',
            'rental_application[proofResidence]' => 'Something New',
            'rental_application[guarantorPayStub]' => 'Something New',
            'rental_application[guarantor]' => 'Something New',
        ]);

        self::assertResponseRedirects('/rental/application/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getIdCard());
        self::assertSame('Something New', $fixture[0]->getTaxForm());
        self::assertSame('Something New', $fixture[0]->getPayStub());
        self::assertSame('Something New', $fixture[0]->getProofResidence());
        self::assertSame('Something New', $fixture[0]->getGuarantorPayStub());
        self::assertSame('Something New', $fixture[0]->getGuarantor());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();

        $originalNumObjectsInRepository = count($this->repository->findAll());

        $fixture = new RentalApplication();
        $fixture->setIdCard('My Title');
        $fixture->setTaxForm('My Title');
        $fixture->setPayStub('My Title');
        $fixture->setProofResidence('My Title');
        $fixture->setGuarantorPayStub('My Title');
        $fixture->setGuarantor('My Title');

        $this->repository->add($fixture, true);

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertSame($originalNumObjectsInRepository, count($this->repository->findAll()));
        self::assertResponseRedirects('/rental/application/');
    }
}
