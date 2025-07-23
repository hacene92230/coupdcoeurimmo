<?php

namespace App\Controller;

use App\Entity\Favori;
use App\Entity\Properties;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FavoriController extends AbstractController
{
    /**
     * @Route("/favori/add/{id}", name="app_favori_add")
     */
    public function add(Request $request, Properties $property, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();

        if (!$user) {
            // Handle non-logged in users (e.g., redirect to login)
            return $this->redirectToRoute('app_login');
        }

        $favori = new Favori();
        $favori->setUser($user);
        $favori->setProperty($property);

        $existingFavori = $entityManager->getRepository(Favori::class)->findOneBy([
            'user' => $user,
            'property' => $property,
        ]);

        if (!$existingFavori) {
            $favori = new Favori();
            $favori->setUser($user);
            $favori->setProperty($property);

            $entityManager->persist($favori);
            $entityManager->flush();
        }

        return $this->redirect($request->headers->get('referer'));
    }

    /**
     * @Route("/favori/remove/{id}", name="app_favori_remove")
     */
    public function remove(Request $request, Favori $favori, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();

        if (!$user || $favori->getUser() !== $user) {
            // Handle unauthorized access
            return $this->redirectToRoute('app_home');
        }

        $entityManager->remove($favori);
        $entityManager->flush();

        return $this->redirect($request->headers->get('referer'));
    }
}
