<?php

namespace App\Controller;

<<<<<<< HEAD
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
=======
use App\Form\SearchType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
>>>>>>> c3cdb47ee315779f23fbb4c59a90b5fbeba3aa01

class SearchController extends AbstractController
{
    /**
     * @Route("/search", name="app_search")
     */
<<<<<<< HEAD
    public function index(): Response
    {
        return $this->render('home/index.html.twig', [
            'searchForm' => 'SearchController',
=======
    public function index( ): Response
    {
       
        return $this->render('search/index.html.twig', [
            'search' => $search,
        ]);
    }
    public function new(Request $request): Response
    {
        
        $form=$this->createForm(SearchType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
           
            $this->addFlash('success', 'search successfull!');

            return $this->redirectToRoute('app_home', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('search/new.html.twig', [
            'form' => $form
>>>>>>> c3cdb47ee315779f23fbb4c59a90b5fbeba3aa01
        ]);
    }
}
