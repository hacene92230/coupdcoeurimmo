<?php

namespace App\Controller;
<<<<<<< HEAD
use App\Repository\ContactRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
=======

use App\Repository\ContactRepository;
>>>>>>> main
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/dashboard", name="dashboard", methods={"GET"})
 */
class DashboardController extends AbstractController
{
    /**
     * @Route("/", name="dashboard_index")
     */
    public function index(): Response
    {
        return $this->render('dashboard/index.html.twig', [
            'controller_name' => 'DashboardController',
        ]);
    }
<<<<<<< HEAD
     /**
     * @Route("/dashboard/contact", name="dashboard_contact_index", methods={"GET"})
     */
    public function showContact(ContactRepository $contactRepository): Response
    {
        return $this->render('contact/index.html.twig', [
            'contact' => $contactRepository->findAll(),
        ]);
    }
=======
>>>>>>> main
}
