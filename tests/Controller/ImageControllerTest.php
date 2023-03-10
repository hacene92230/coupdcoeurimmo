<?php

namespace App\Test\Controller;

use App\Entity\Image;
use App\Repository\ImageRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ImageControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private ImageRepository $repository;
    private string $path = '/image/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->repository = (static::getContainer()->get('doctrine'))->getRepository(Image::class);

        foreach ($this->repository->findAll() as $object) {
            $this->repository->remove($object, true);
        }
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Image index');

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
            'image[image_name]' => 'Testing',
            'image[image_size]' => 'Testing',
            'image[updatedAt]' => 'Testing',
            'image[properties]' => 'Testing',
        ]);

        self::assertResponseRedirects('/image/');

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Image();
        $fixture->setImage_name('My Title');
        $fixture->setImage_size('My Title');
        $fixture->setUpdatedAt('My Title');
        $fixture->setProperties('My Title');

        $this->repository->add($fixture, true);

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Image');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Image();
        $fixture->setImage_name('My Title');
        $fixture->setImage_size('My Title');
        $fixture->setUpdatedAt('My Title');
        $fixture->setProperties('My Title');

        $this->repository->add($fixture, true);

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'image[image_name]' => 'Something New',
            'image[image_size]' => 'Something New',
            'image[updatedAt]' => 'Something New',
            'image[properties]' => 'Something New',
        ]);

        self::assertResponseRedirects('/image/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getImage_name());
        self::assertSame('Something New', $fixture[0]->getImage_size());
        self::assertSame('Something New', $fixture[0]->getUpdatedAt());
        self::assertSame('Something New', $fixture[0]->getProperties());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();

        $originalNumObjectsInRepository = count($this->repository->findAll());

        $fixture = new Image();
        $fixture->setImage_name('My Title');
        $fixture->setImage_size('My Title');
        $fixture->setUpdatedAt('My Title');
        $fixture->setProperties('My Title');

        $this->repository->add($fixture, true);

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertSame($originalNumObjectsInRepository, count($this->repository->findAll()));
        self::assertResponseRedirects('/image/');
    }
}
