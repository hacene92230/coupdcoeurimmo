<?php

namespace App\Controller;

use Knp\Snappy\Pdf;
use App\Entity\Properties;
use App\Repository\PropertiesRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/pdf")
 */
class PdfController extends AbstractController
{
    /**
     * @Route("/{id}", name="app_properties_pdf", methods={"GET"})
     */
    public function generatePropertyPdf(Pdf $pdf, Properties $property, UrlGeneratorInterface $urlGenerator): Response
    {
        $baseUrl = $urlGenerator->generate('app_home', [], UrlGeneratorInterface::ABSOLUTE_URL);
        $propertyUrl = $urlGenerator->generate('app_properties_show', ['id' => $property->getId()], UrlGeneratorInterface::ABSOLUTE_URL);

        $html = $this->renderView(
            'properties/show.html.twig',
            [
                'property' => $property,
                'base_url' => $baseUrl,
                'property_url' => $propertyUrl
            ]
        );

        $pdf->setOption('page-size', 'A5');
        $pdf->setOption('orientation', 'Landscape');

        return new Response(
            $pdf->getOutput($propertyUrl),
            200,
            array(
                'Content-Type'          => 'application/pdf',
                'Content-Disposition'   => 'inline; filename="' . $property->getId() . '.pdf"'
            )
        );
    }
}
