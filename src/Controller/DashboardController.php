<?php

namespace App\Controller;
use app\Repository\ContactRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractController
{
    /**
     * @Route("/dashboard", name="app_dashboard")
     */
    public function index(): Response
    {
        return $this->render('dashboard/index.html.twig', [
            'controller_name' => 'DashboardController',
        ]);
    }
     /**
     * @Route("/dashboard/contact", name="dashobard_contact_index", methods={"GET"})
     */
    public function showContact(ContactRepository $contactRepository): Response
    {
        return $this->render('contact/index.html.twig', [
            'contact' => $contactRepository->findAll(),
        ]);
    }
}
