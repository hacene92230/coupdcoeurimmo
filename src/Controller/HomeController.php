<?php

namespace App\Controller;
use Knp\Component\Pager\PaginatorInterface;
use App\Repository\PropertiesRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    /**
     * @Route("/home", name="app_home")
     */
    public function index(Request $request, PropertiesRepository $propertiesRepository, PaginatorInterface $paginator): Response
    {
        $properties = $propertiesRepository->findAll();
        $properties = $paginator->paginate(
            $properties,
            $request->query->getInt( 'page', 1),
            2
        );
        return $this->render('home/index.html.twig',[
            'properties'=> $properties
        ] );
    }

    /**
     * @Route("/about", name="app_about")
     */
    public function about(): Response
    {
        return $this->render(
            'home/about.html.twig',
            []
        );
    }
}
