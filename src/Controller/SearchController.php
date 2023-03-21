<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SearchController extends AbstractController
{
    /**
     * @Route("/search", name="app_search")
     */
    public function index(): Response
    {
        return $this->render('home/index.html.twig', [
            'searchForm' => 'SearchController',
        ]);
    }
}
