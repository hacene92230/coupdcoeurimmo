<?php

namespace App\Controller;

use App\Entity\RentalInterest;
use App\Form\RentalInterestType;
use App\Repository\RentalInterestRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/interest")
 */
class RentalInterestController extends AbstractController
{
    /**
     * @Route("/", name="app_rental_interest_index", methods={"GET"})
     */
    public function index(RentalInterestRepository $rentalInterestRepository): Response
    {
        return $this->render('rental_interest/index.html.twig', [
            'rental_interests' => $rentalInterestRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_rental_interest_new", methods={"GET", "POST"})
     */
    public function new(Request $request, RentalInterestRepository $rentalInterestRepository): Response
    {
        $rentalInterest = new RentalInterest();
        $form = $this->createForm(RentalInterestType::class, $rentalInterest);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $rentalInterest->setUser($this->getUser());
            $rentalInterestRepository->add($rentalInterest, true);
            $this->addFlash('success', 'votre intéret à bien été pris en compte!');
            return $this->redirectToRoute('app_rental_interest_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('rental_interest/new.html.twig', [
            'rental_interest' => $rentalInterest,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_rental_interest_show", methods={"GET"})
     */
    public function show(RentalInterest $rentalInterest): Response
    {
        return $this->render('rental_interest/show.html.twig', [
            'rental_interest' => $rentalInterest,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_rental_interest_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, RentalInterest $rentalInterest, RentalInterestRepository $rentalInterestRepository): Response
    {
        $form = $this->createForm(RentalInterestType::class, $rentalInterest);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $rentalInterestRepository->add($rentalInterest, true);
            $this->addFlash('suucess', 'votre intéret à bien été modifié!');
            return $this->redirectToRoute('app_rental_interest_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('rental_interest/edit.html.twig', [
            'rental_interest' => $rentalInterest,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_rental_interest_delete", methods={"POST"})
     */
    public function delete(Request $request, RentalInterest $rentalInterest, RentalInterestRepository $rentalInterestRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $rentalInterest->getId(), $request->request->get('_token'))) {
            $rentalInterestRepository->remove($rentalInterest, true);
        }
        $this->addFlash('warning', 'votre intéret a été supprimé!');

        return $this->redirectToRoute('app_rental_interest_index', [], Response::HTTP_SEE_OTHER);

    }
}
