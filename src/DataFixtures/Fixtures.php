<?php

namespace App\DataFixtures;

use DateTime;
use App\Entity\User;
use App\Entity\Image;
use App\Entity\Rental;
use DateTimeImmutable;
use App\Entity\Address;
use App\Entity\Contact;
use App\Entity\Category;
use App\Entity\Properties;
use App\Repository\UserRepository;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Vich\UploaderBundle\Naming\UniqidNamer;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\MappingFactory;
use Vich\UploaderBundle\Templating\Helper\UploaderHelper;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class Fixtures extends Fixture
{
    private $hash;
    private $container;
    private $uploaderHelper;
    private $userRepository;
    public function __construct(ContainerInterface $container, UploaderHelper $uploaderHelper, UserPasswordHasherInterface $userPasswordHasher, UserRepository $userRepository)
    {
        $this->container = $container;
        $this->uploaderHelper = $uploaderHelper;
        $this->hash = $userPasswordHasher;
        $this->userRepository = $userRepository;
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
                $index = $k + ($key * 2) + 1; // Calcul de l'index unique pour chaque bien
                $property = new Properties();
                $property->setTitle("bien" . $index) // Utilisation de l'index unique pour le titre
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

        // Chemin absolu vers le dossier
        $dir = "../public/images/properties";

        // Vérifie que le dossier existe
        if (!is_dir($dir)) {
            // Crée le dossier s'il n'existe pas
            if (!mkdir($dir, 7777, true)) {
                die('Impossible de créer le dossier');
            }
        }       // Supprime tous les fichiers dans le dossier
        $files = glob("$dir/*");
        foreach ($files as $file) {
            if (is_file($file)) {
                if (!unlink($file)) {
                    echo "Erreur lors de la suppression du fichier $file";
                }
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
            $fileName = md5(uniqid()) . ".jpg";
            $imagePath = "../public/images/properties/" . $fileName;
            imagejpeg($image, $imagePath);

            // Créer une entité Image pour enregistrer l'image avec VichUploader
            $imageEntity = new Image();
            $imageEntity->setImageFile(new File($imagePath));
            $imageEntity->setImageName(basename($fileName));

            for ($init = 0; $init <= 4; $init++) {
                $randomIndex = rand(0, count($properties) - 1);
                $imageEntity->setProperties($properties[$randomIndex]);
            }

            // Enregistrer l'image avec VichUploader
            $uploaderHelper = $this->container->get('vich_uploader.templating.helper.uploader_helper');
            $uploaderHelper->asset($imageEntity, 'imageFile');

            // Ajouter l'image à la liste
            $manager->persist($imageEntity);
            $images[] = $imageEntity;

            // Libérer la mémoire utilisée par l'image
            imagedestroy($image);
        }

        foreach ($users as $roleUser) {
            if ($roleUser->getRoles()[0] == "ROLE_USER") {
                $location = new Rental();
                $location->setDateStart(new DateTime())
                    ->setDateEnd(new DateTime())
                    ->setTenant($roleUser);
                $indexUtilises = array();
                foreach ($properties as $propertyLouer) {
                    // Générer un index aléatoire
                    $index = mt_rand(0, count($properties) - 1);

                    // Vérifier si l'index est déjà utilisé, si oui, générer un nouvel index jusqu'à en trouver un non utilisé
                    while (in_array($index, $indexUtilises)) {
                        $index = mt_rand(0, count($properties) - 1);
                    }

                    // Attribuer la propriété correspondant à l'index non utilisé à la location
                    $location->setProperty($properties[$index]);

                    // Ajouter l'index utilisé au tableau des index utilisés
                    $indexUtilises[] = $index;
                }
                $manager->persist($location);
            }
        }
        $manager->flush();
    }
}
