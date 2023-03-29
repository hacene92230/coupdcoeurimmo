<?php

namespace App\Controller;

use App\Form\SearchType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SearchController extends AbstractController
{
    /**
     * @Route("/search/{termes}", name="app_search", methods={"GET", "POST"
     * })
     */
    public function search(Request $request, $termes = null): Response
    {
        $form = $this->createForm(SearchType::class);
        $form->handleRequest($request);
<<<<<<< HEAD
        
=======
>>>>>>> main
        return $this->renderForm('search/new.html.twig', [

            'form' => $form,
            'termes' => $termes,
        ]);
    }
}
