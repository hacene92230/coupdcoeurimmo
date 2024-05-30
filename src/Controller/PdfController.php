<?php

namespace App\Controller;

use Dompdf\Dompdf;
use App\Entity\Properties;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class PdfController extends AbstractController
{
    /**
     * @Route("/pdf/{id}", name="app_pdf_generate")
     */
    public function generatePdf($id, Request $request): Response
    {
        // Récupérez vos données à partir de votre base de données ou d'autres sources
        $property = $this->getDoctrine()->getRepository(Properties::class)->find($id);
        $imagePath = $request->getSchemeAndHttpHost() . '/coupdcoeurimmo/public/images/logo.png';
	$imagePath2 = $request->getSchemeAndHttpHost() . '/coupdcoeurimmo/public/images/properties/appartement.jpg';
        $imageContent = file_get_contents($imagePath);
	$imageContent2 = file_get_contents($imagePath2);


        // Encodez l'image en base64
        $imageBase64 = base64_encode($imageContent);
	$imageBase65 = base64_encode($imageContent2);

        // Créez le contenu HTML que vous souhaitez afficher dans votre PDF
        $html = $this->renderView('pdf/property.html.twig', [
            'imageBase64' => $imageBase64,
	'imageBase65' => $imageBase65,
            'property' => $property,
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
