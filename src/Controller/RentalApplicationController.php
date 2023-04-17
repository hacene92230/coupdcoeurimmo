<?php

namespace App\Controller;

use App\Entity\RentalApplication;
use App\Form\RentalApplicationType;
use App\Repository\RentalApplicationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/rental/application")
 */
class RentalApplicationController extends AbstractController
{
    /**
     * @Route("/", name="app_rental_application_index", methods={"GET"})
     */
    public function index(RentalApplicationRepository $rentalApplicationRepository): Response
    {
        return $this->render('rental_application/index.html.twig', [
            'rental_applications' => $rentalApplicationRepository->findAll(),
        ]);
    }

    /**
     * @Route("/{id}/new", name="app_rental_application_new", methods={"GET", "POST"})
     */
    public function new(Request $request, RentalApplicationRepository $rentalApplicationRepository): Response
    {
        $rentalApplication = new RentalApplication();
        $form = $this->createForm(RentalApplicationType::class, $rentalApplication);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $rentalApplicationRepository->add($rentalApplication, true);

            return $this->redirectToRoute('app_rental_application_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('rental_application/new.html.twig', [
            'rental_application' => $rentalApplication,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_rental_application_show", methods={"GET"})
     */
    public function show(RentalApplication $rentalApplication): Response
    {
        return $this->render('rental_application/show.html.twig', [
            'rental_application' => $rentalApplication,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_rental_application_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, RentalApplication $rentalApplication, RentalApplicationRepository $rentalApplicationRepository): Response
    {
        $form = $this->createForm(RentalApplicationType::class, $rentalApplication);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $rentalApplicationRepository->add($rentalApplication, true);

            return $this->redirectToRoute('app_rental_application_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('rental_application/edit.html.twig', [
            'rental_application' => $rentalApplication,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_rental_application_delete", methods={"POST"})
     */
    public function delete(Request $request, RentalApplication $rentalApplication, RentalApplicationRepository $rentalApplicationRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$rentalApplication->getId(), $request->request->get('_token'))) {
            $rentalApplicationRepository->remove($rentalApplication, true);
        }

        return $this->redirectToRoute('app_rental_application_index', [], Response::HTTP_SEE_OTHER);
    }
}
