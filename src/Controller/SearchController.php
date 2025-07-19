<?php

namespace App\Controller;

use App\Form\SearchType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Properties;
use App\Entity\Category;

class SearchController extends AbstractController
{
/**
 * @Route("/search", name="app_search", methods={"POST"})
 */
public function index(Request $request): Response
{
    $form = $this->createForm(SearchType::class);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $formData = $form->getData();

        $keyword = $formData['keyword'];
        $type = $formData['type'];
        $localisation = $formData['localisation'];
        $priceMin = $formData['priceMin'];
        $priceMax = $formData['priceMax'];
        $category = $formData['category'];
        $rent = $formData['rent'];
        $roomNumber = $formData['roomNumber'];
        $harea = $formData['harea'];
        $errors = [];

        if ($priceMin && $priceMax && $priceMin > $priceMax) {
            $errors[] = 'Le prix maximum doit être supérieur au prix minimum.';
        }

        if ($type !== null && !in_array($type, [0, 1])) {
            $errors[] = 'Le type de bien sélectionné est invalide.';
        }

        if ($localisation && !ctype_digit($localisation)) {
            $errors[] = 'La localisation doit contenir uniquement des chiffres.';
        }

        // Ajoutez des vérifications supplémentaires et des messages d'erreur si nécessaire
        if (count($errors) > 0) {
            return $this->render('search/result.html.twig', [
                'form' => $form->createView(),
                'errors' => $errors,
            ]);
        }

        $entityManager = $this->getDoctrine()->getManager();
        $queryBuilder = $entityManager->getRepository(Properties::class)
            ->createQueryBuilder('p')
            ->where('LOWER(p.title) LIKE :keyword')
            ->orWhere('LOWER(p.content) LIKE :keyword')
            ->setParameter('keyword', '%' . strtolower($keyword) . '%');

        if ($type !== null) {
            $queryBuilder->andWhere('p.housingType = :type')
                ->setParameter('type', $type);
        }

        if ($localisation) {
            $queryBuilder
                ->join('p.address', 'a')
                ->andWhere('LOWER(a.city) = :city')
                ->setParameter('city', strtolower($localisation));
        }

        if ($priceMin) {
            $queryBuilder->andWhere('p.price >= :priceMin')
                ->setParameter('priceMin', $priceMin);
        }

        if ($priceMax) {
            $queryBuilder->andWhere('p.price <= :priceMax')
                ->setParameter('priceMax', $priceMax);
        }

        if ($category) {
            $queryBuilder
                ->join('p.category', 'c')
                ->andWhere('c = :category')
                ->setParameter('category', $category);
        }

        if ($rent) {
            $rentMin = $rent - ($rent * 0.1);
            $rentMax = $rent + ($rent * 0.1);
            $queryBuilder
                ->andWhere('p.rent >= :rentMin')
                ->andWhere('p.rent <= :rentMax')
                ->setParameter('rentMin', $rentMin)
                ->setParameter('rentMax', $rentMax);
        }

        if ($roomNumber) {
            $queryBuilder->andWhere('p.roomNumber >= :roomNumber')
                ->setParameter('roomNumber', $roomNumber);
        }

        if ($harea) {
            $queryBuilder->andWhere('p.harea >= :harea')
                ->setParameter('harea', $harea);
        }

        $properties = $queryBuilder->getQuery()->getResult();

        return $this->render('search/result.html.twig', [
            'form' => $form->createView(),
            'results' => $properties,
            'errors' => $errors,
        ]);
    }

    return $this->render('search/index.html.twig', [
        'form' => $form->createView(),
    ]);
}}
