<?php

namespace App\Controller;

use App\Entity\HomeInterest;
use App\Form\HomeInterestType;
use App\Repository\HomeInterestRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/home")
 */
class HomeInterestController extends AbstractController
{
    /**
     * @Route("/", name="app_home_interest_index", methods={"GET"})
     */
    public function index(HomeInterestRepository $homeInterestRepository): Response
    {
        return $this->render('home_interest/index.html.twig', [
            'home_interests' => $homeInterestRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_home_interest_new", methods={"GET", "POST"})
     */
    public function new(Request $request, HomeInterestRepository $homeInterestRepository): Response
    {
        $homeInterest = new HomeInterest();
        $form = $this->createForm(HomeInterestType::class, $homeInterest);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $homeInterest->setUser($this->getUser());
            $homeInterestRepository->add($homeInterest, true);
            $this->addFlash('success', 'votre intéret à bien été pris en compte!');
            return $this->redirectToRoute('app_home_interest_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('home_interest/new.html.twig', [
            'home_interest' => $homeInterest,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_home_interest_show", methods={"GET"})
     */
    public function show(HomeInterest $homeInterest): Response
    {
        return $this->render('home_interest/show.html.twig', [
            'home_interest' => $homeInterest,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_home_interest_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, HomeInterest $homeInterest, HomeInterestRepository $homeInterestRepository): Response
    {
        $form = $this->createForm(HomeInterestType::class, $homeInterest);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $homeInterestRepository->add($homeInterest, true);
            $this->addFlash('suucess', 'votre intéret à bien été modifié!');
            return $this->redirectToRoute('app_home_interest_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('home_interest/edit.html.twig', [
            'home_interest' => $homeInterest,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_home_interest_delete", methods={"POST"})
     */
    public function delete(Request $request, HomeInterest $homeInterest, HomeInterestRepository $homeInterestRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $homeInterest->getId(), $request->request->get('_token'))) {
            $homeInterestRepository->remove($homeInterest, true);
        }
        $this->addFlash('warning', 'votre intéret a été supprimé!');

        return $this->redirectToRoute('app_home_interest_index', [], Response::HTTP_SEE_OTHER);

    }
}
