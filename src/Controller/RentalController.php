<?php

namespace App\Controller;

use App\Entity\Rental;
use App\Form\RentalType;
use App\Repository\UserRepository;
use App\Repository\RentalRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/rental")
 */
class RentalController extends AbstractController
{
    /**
     * @Route("/", name="app_rental_index", methods={"GET", "POST"})
     */
    public function index(RentalRepository $rentalRepository): Response
    {
        if ($this->getUser()->getRoles()[0] == "ROLE_ADMIN") {
            $rental = $rentalRepository->findAll();
        } else {
            $rental = $rentalRepository->findBy(["tenant" => $this->getUser()]);
        }
        return $this->render('rental/index.html.twig', [
            'rentals' => $rental,
        ]);
    }

    /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("/new", name="app_rental_new", methods={"GET", "POST"})
     */
    public function new(Request $request, RentalRepository $rentalRepository): Response
    {
        $rental = new Rental();
        $form = $this->createForm(RentalType::class, $rental);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $rental->getTenant();
            $user->setRoles(["ROLE_TENANT"]);
            $rentalRepository->add($rental, true);
            $this->addFlash('success', 'Cette location est désormais active');

            return $this->redirectToRoute('app_rental_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('rental/new.html.twig', [
            'rental' => $rental,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_rental_show", methods={"GET"})
     */
    public function show(Rental $rental): Response
    {
        return $this->render('rental/show.html.twig', [
            'rental' => $rental,
        ]);
    }

    /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("/{id}/edit", name="app_rental_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Rental $rental, RentalRepository $rentalRepository): Response
    {
        $form = $this->createForm(RentalType::class, $rental);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $rentalRepository->add($rental, true);
            $this->addFlash('success', ' modification bien prise en compte!');

            return $this->redirectToRoute('app_rental_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('rental/edit.html.twig', [
            'rental' => $rental,
            'form' => $form,
        ]);
    }

    /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("/{id}", name="app_rental_delete", methods={"POST"})
     */

    public function delete(UserRepository $userRepository, Request $request, Rental $rental, RentalRepository $rentalRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $rental->getId(), $request->request->get('_token'))) {
            $rentalUser = $userRepository->findOneBy(["id" => $rental->getTenant()->getId()]);
            $rentalUser->setRoles(["ROLE_USER"]);

            $rentalRepository->remove($rental, true);
        }
        $this->addFlash('warning', ' suppression bien prise en compte!');

        return $this->redirectToRoute('app_rental_index', [], Response::HTTP_SEE_OTHER);
    }
}
