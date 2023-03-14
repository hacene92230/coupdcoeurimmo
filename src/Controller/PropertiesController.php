<?php

namespace App\Controller;

use App\Entity\Properties;
use App\Form\PropertiesType;
use App\Repository\ImageRepository;
use App\Repository\PropertiesRepository;
use DateTimeImmutable;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

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
        if ($this->getUser()->getRoles()[0] == "ROLE_ADMIN") {
            $properties = $propertiesRepository->findAll();
        } else {
            $properties = $propertiesRepository->findBy(['user' => $this->getUser()]);
        }
        return $this->render('properties/index.html.twig', [
            'properties' => $properties,
        ]);
    }

    /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("/new", name="app_properties_new", methods={"GET", "POST"})
     */
    public function new(Request $request, PropertiesRepository $propertiesRepository): Response
    {
        $property = new Properties();
        $form = $this->createForm(PropertiesType::class, $property);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $images = $property->getImages();
            foreach ($images as $key => $image) {
                $image->setProperties($property);
                $images->set($key, $image);
            }
            $property->setCreatedAt(new DateTimeImmutable());
            $propertiesRepository->add($property, true);
            $this->addFlash('success', 'Ce bien a correctement été ajouté!');
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
     * @IsGranted("ROLE_ADMIN")
     * @Route("/{id}/edit", name="app_properties_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Properties $property, PropertiesRepository $propertiesRepository, ImageRepository $imageRepository): Response
    {
        $form = $this->createForm(PropertiesType::class, $property);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $images = $property->getImages();
            foreach ($images as $key => $image) {
                if ($image->getImageFile() == null) {
                    $property->removeImage($image);
                    $imageRepository->remove($image, true);
                } else {
                    $image->setProperties($property);
                    $images->set($key, $image);
                }
            }
            $propertiesRepository->add($property, true);
            $propertiesRepository->add($property, true);
            $this->addFlash('success', 'les informations de la proprieté ont bien été modifié!');
            return $this->redirectToRoute('app_properties_index', [], Response::HTTP_SEE_OTHER);
        }
        return $this->renderForm('properties/edit.html.twig', [
            'property' => $property,
            'form' => $form,
        ]);
    }

    /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("/{id}", name="app_properties_delete", methods={"POST"})
     */
    public function delete(Request $request, Properties $property, PropertiesRepository $propertiesRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $property->getId(), $request->request->get('_token'))) {
            $propertiesRepository->remove($property, true);
        }
        $this->addFlash('warning', 'suppression de la proprieté!');

        return $this->redirectToRoute('app_properties_index', [], Response::HTTP_SEE_OTHER);
    }
}
