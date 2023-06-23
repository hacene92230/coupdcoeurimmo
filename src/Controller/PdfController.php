<?php

namespace App\Controller;

use Dompdf\Dompdf;
use App\Entity\Properties;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PdfController extends AbstractController
{
    /**
     * @Route("/pdf/{id}", name="app_pdf_generate")
     */
    public function generatePdf($id): Response
    {
        // Récupérez vos données à partir de votre base de données ou d'autres sources
        $property = $this->getDoctrine()->getRepository(Properties::class)->find($id);

        // Créez le contenu HTML que vous souhaitez afficher dans votre PDF
        $html = $this->renderView('pdf/property.html.twig', [
            'property' => $property
        ]);

        // Instanciez Dompdf et générez le PDF
        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        // Retournez une réponse qui affiche votre PDF dans le navigateur
        return new Response(
            $dompdf->output(),
            200,
            [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => sprintf('inline; filename="property_%s.pdf"', $id)
            ]
        );
    }
}
