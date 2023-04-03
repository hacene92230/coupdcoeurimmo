<?php

namespace App\Controller;

use Knp\Snappy\Pdf;
use App\Entity\Properties;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PdfController extends AbstractController
{
    /**
     * @Route("/pdf/{id}", name="app_pdf_generate")
     */
    public function generatePdf(Pdf $pdf, $id): Response
    {
        // Récupérez vos données à partir de votre base de données ou d'autres sources
        $property = $this->getDoctrine()->getRepository(Properties::class)->find($id);

        // Créez le contenu HTML que vous souhaitez afficher dans votre PDF
        $html = $this->renderView('pdf/property.html.twig', [
            'property' => $property
        ]);

        // Configurez les options de votre PDF, tels que la taille de la page et l'orientation
        $pdf->setOption('page-size', 'A4');
        $pdf->setOption('orientation', 'Portrait');
        $pdf->setOption('encoding', 'UTF-8');
        // Générez votre PDF en utilisant le contenu HTML et les options configurées précédemment
        $pdfContent = $pdf->getOutputFromHtml($html);

        // Retournez une réponse qui affiche votre PDF dans le navigateur
        return new Response(
            $pdfContent,
            200,
            [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => sprintf('inline; filename="property_%s.pdf"', $id)
            ]
        );
    }
}
