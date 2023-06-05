<?php

namespace App\Controller;

use App\Repository\PropertiesRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/home")
 */
class HomeController extends AbstractController
{
    const ITEMS_PER_PAGE = 6;

    /**
     * @Route("/page/{page}", name="app_home")
     */
    public function index(Request $request, PropertiesRepository $pr, int $page = 1): Response
    {
        $totalItems = $pr->count([]);
        $totalPages = ceil($totalItems / self::ITEMS_PER_PAGE);
        $offset = ($page - 1) * self::ITEMS_PER_PAGE;
        $properties = $pr->findBy([], [], self::ITEMS_PER_PAGE, $offset);

        return $this->render('home/index.html.twig', [
            'properties' => $properties,
            'current_page' => $page,
            'total_pages' => $totalPages,
        ]);
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
     /*
     *@route("/favoris", name="app_favoris)
     */
    public function favoris():Response
    {
        return $this->render(
            'home/favoris.html.twig',[]
        );
    }
}
