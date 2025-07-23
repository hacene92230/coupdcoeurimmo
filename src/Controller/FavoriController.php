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
        $session = $request->getSession();

        if ($user) {
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
        } else {
            $favoris = $session->get('favoris', []);
            if (!in_array($property->getId(), $favoris)) {
                $favoris[] = $property->getId();
                $session->set('favoris', $favoris);
            }
        }

        if ($request->isXmlHttpRequest()) {
            return $this->json([
                'isFavori' => true,
                'url' => $this->generateUrl('app_favori_remove', ['id' => $property->getId()])
            ]);
        }

        return $this->redirect($request->headers->get('referer'));
    }

    /**
     * @Route("/favori/remove/{id}", name="app_favori_remove")
     */
    public function remove(Request $request, Properties $property, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();
        $session = $request->getSession();

        if ($user) {
            $favori = $entityManager->getRepository(Favori::class)->findOneBy([
                'user' => $user,
                'property' => $property,
            ]);

            if ($favori) {
                $entityManager->remove($favori);
                $entityManager->flush();
            }
        } else {
            $favoris = $session->get('favoris', []);
            if (($key = array_search($property->getId(), $favoris)) !== false) {
                unset($favoris[$key]);
                $session->set('favoris', $favoris);
            }
        }

        if ($request->isXmlHttpRequest()) {
            return $this->json([
                'isFavori' => false,
                'url' => $this->generateUrl('app_favori_add', ['id' => $property->getId()])
            ]);
        }

        return $this->redirect($request->headers->get('referer'));
    }

    /**
     * @Route("/favoris", name="app_favori_list")
     */
    public function list(Request $request, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();
        $session = $request->getSession();
        $properties = [];

        if ($user) {
            $favoris = $user->getFavoris();
            foreach ($favoris as $favori) {
                $properties[] = $favori->getProperty();
            }
        } else {
            $favoriIds = $session->get('favoris', []);
            if (!empty($favoriIds)) {
                $properties = $entityManager->getRepository(Properties::class)->findById($favoriIds);
            }
        }

        return $this->render('favori/list.html.twig', [
            'properties' => $properties,
        ]);
    }
}
