<?php

namespace App\Controller;

use App\Entity\Category;
use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends AbstractController
{
    /**
     * @Route("/category", name="app_category")
     */
    public function index(CategoryRepository $categoryRepository): Response
    {
        $category = $categoryRepository ->findAll();
        return $this->render('category/index.html.twig', [
            'category' => $category,
        ]);
    }
/**
     * @Route("/{id}", name="app_category_show", methods={"GET"})
     */
    public function show(Category $category): Response 
    {
        return $this->render('category/show.html.twig', [
            'category'=> $category,
         ]);
    }
}
