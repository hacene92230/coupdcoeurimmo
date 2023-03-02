<?php

namespace App\Controller;

use App\Entity\Properties;
use App\Form\PropertiesType;
use App\Repository\PropertiesRepository;
use DateTimeImmutable;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/properties")
 */
class PropertiesController extends AbstractController
{
    /**
     * @Route("/", name="app_properties_index", methods={"GET"})
     */
    public function index(PropertiesRepository $propertiesRepository): Response
    {
        return $this->render('properties/index.html.twig', [
            'properties' => $propertiesRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_properties_new", methods={"GET", "POST"})
     */
    public function new(Request $request, PropertiesRepository $propertiesRepository): Response
    {
        $property = new Properties();
        $form = $this->createForm(PropertiesType::class, $property);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $property->setCreatedAt(new DateTimeImmutable());
            $propertiesRepository->add($property, true);

            return $this->redirectToRoute('app_properties_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('properties/new.html.twig', [
            'property' => $property,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_properties_show", methods={"GET"})
     */
    public function show(Properties $property): Response
    {
        return $this->render('properties/show.html.twig', [
            'property' => $property,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_properties_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Properties $property, PropertiesRepository $propertiesRepository): Response
    {
        $form = $this->createForm(PropertiesType::class, $property);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $propertiesRepository->add($property, true);

            return $this->redirectToRoute('app_properties_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('properties/edit.html.twig', [
            'property' => $property,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_properties_delete", methods={"POST"})
     */
    public function delete(Request $request, Properties $property, PropertiesRepository $propertiesRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $property->getId(), $request->request->get('_token'))) {
            $propertiesRepository->remove($property, true);
        }

        return $this->redirectToRoute('app_properties_index', [], Response::HTTP_SEE_OTHER);
    }
}
