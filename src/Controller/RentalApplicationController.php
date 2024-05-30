<?php

namespace App\Controller;

use DateTimeImmutable;
use App\Entity\RentalApplication;
use App\Form\RentalApplicationType;
use App\Repository\PropertiesRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Repository\RentalApplicationRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/location")
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
     * @Route("/asked/{id}", name="app_rental_application_new", methods={"GET", "POST"})
     */
    public function new(Request $request, RentalApplicationRepository $rentalApplicationRepository, PropertiesRepository $propertiesRepository, $id): Response
    {
        $rentalApplication = new RentalApplication();
        $form = $this->createForm(RentalApplicationType::class, $rentalApplication);
        $form->handleRequest($request);
        $property = $propertiesRepository->findOneBy(["id" => $id]);

        if ($rentalApplicationRepository->findOneBy(["user" => $this->getUser(), "property" => $property]) == true) {

            $this->addFlash('warning', 'Votre dossier est en attente de traitement, nous vous tiendrons informé de son avancé.');
            return $this->redirectToRoute('app_home', [], Response::HTTP_SEE_OTHER);
        }
        if ($form->isSubmitted() && $form->isValid()) {
                        $rentalApplication->setUser($this->getUser());
            $rentalApplication->setProperty($property);
            $rentalApplicationRepository->add($rentalApplication, true);
            $this->addFlash('success', 'Votre dossier à bien été prise en compte, nous reviendrons vers vous au plus vite!');
            return $this->redirectToRoute('app_home', [], Response::HTTP_SEE_OTHER);
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
        if ($this->isCsrfTokenValid('delete' . $rentalApplication->getId(), $request->request->get('_token'))) {
            $rentalApplicationRepository->remove($rentalApplication, true);
        }

        return $this->redirectToRoute('app_rental_application_index', [], Response::HTTP_SEE_OTHER);
    }
}
