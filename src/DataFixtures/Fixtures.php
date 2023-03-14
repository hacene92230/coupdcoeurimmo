<?php

namespace App\DataFixtures;

use DateTime;
use App\Entity\User;
use App\Entity\Image;
use DateTimeImmutable;
use App\Entity\Address;
use App\Entity\Contact;
use App\Entity\Category;
use App\Entity\Properties;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
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
        //création des adresses
        $adresses = [];
        for ($a = 0; $a <= 20; $a++) {
            $address = new Address();
            $address->setCity("ville" . $a)
                ->setPlaceType("avenue")
                ->setZipCode(rand(1, 93000))
                ->setPlaceNumber(rand(1, 90));
            $manager->persist($address);
            $adresses[] = $address;
        }

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
                ->setAddress($adresses[rand(0, 20)]);
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

        //créations des catégories
        $categories = [];
        for ($k = 0; $k <= 1; $k++) {
            $categorie = new Category();
            if ($k == 0) {
                $categorie->setName("location");
            } else {
                $categorie->setName("vente");
            }
            $categories[] = $categorie;
            $manager->persist($categorie);
        }

        //Création des biens avec des propriétaires ayant le rôle "ROLE_HOWNER"
        $properties = [];
        foreach ($owners as $key => $owner) {
            for ($k = 0; $k < 2; $k++) { // Création de 2 biens pour chaque propriétaire
                $property = new Properties();
                $property->setTitle("bien" . $key)
                    ->setContent("contenu" . $key)
                    ->setCreatedAt(new DateTimeImmutable())
                    ->setRoomNumber(rand(3, 10))
                    ->setHousingType(rand(0, 1));
                $randomIndex = rand(0, count($categories) - 1);
                $property->setCategory($categories[$randomIndex]);
                $property->setRent(rand(550, 900))
                    ->setPrice(rand(100000, 900000))
                    ->setGarden(rand(0, 1))
                    ->setHarea(rand(10, 350))
                    ->setAddress($adresses[rand(0, 20)])
                    ->setHeating("électrique")
                    ->setYearBuilt(new DateTime())
                    ->setUser($owner);
                $manager->persist($property);
                $properties[] = $property;
            }
        }

        // création des images
        $images = [];
        for ($i = 0; $i <= 80; $i++) {
            // Définir les dimensions de l'image de maison
            $width = rand(550, 640);
            $height = rand(350, 480);
            // Créer une image vide avec les dimensions spécifiées
            $image = imagecreatetruecolor($width, $height);

            // Définir une couleur de fond pour l'image (blanc dans cet exemple)
            $white = imagecolorallocate($image, 255, 255, 255);
            imagefill($image, 0, 0, $white);

            // Dessiner les contours de la maison
            $black = imagecolorallocate($image, 0, 0, 0);
            imagerectangle($image, rand(80, 100), rand(90, 100), rand(400, 500), rand(300, 400), $black);

            // Dessiner une porte et une fenêtre
            imagefilledrectangle($image, 150, 200, 250, 400, $black);
            imagefilledrectangle($image, 350, 200, 450, 300, $black);

            // Dessiner un toit
            $gray = imagecolorallocate($image, 128, 128, 128);
            $points = array(
                100, 100,
                300, 50,
                500, 100
            );
            imagefilledpolygon($image, $points, 3, $gray);

            // Enregistrer l'image dans un fichier
            $imagePath = "../public/images/properties/house$i.jpg";
            imagejpeg($image, $imagePath);

            // Libérer la mémoire utilisée par l'image
            imagedestroy($image);

            $image = new Image();
            $image->setImageName($imagePath);
            $image->setUpdatedAt(new DateTimeImmutable());
            $image->setImageSize(rand(200, 400));

            for ($init = 0; $init <= 4; $init++) {
                $randomIndex = rand(0, count($properties) - 1);
                $image->setProperties($properties[$randomIndex]);
            }
            $manager->persist($image);
            $images[] = $image;
        }
        $manager->flush();
    }
}
