<?php

namespace App\Controller;

use App\Form\PropertySearchType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class PropertySearchController extends AbstractController
{
    /**
     * @Route("/property/search", name="app_property_search")
     */
    public function index( Request $request): Response
    {
        $form = $this->createForm(PropertySearchType::class);
        $search = $form ->handleRequest($request);
        return $this->render('home/index.html.twig', [
            'search' => $search,
            'form'=> $form->createView()
        ]);
    }
}
