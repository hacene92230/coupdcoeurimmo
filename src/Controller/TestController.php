<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TestController extends AbstractController
{
    /**
     * @Route("/test-api", name="test_api")
     */
    public function testApi(): Response
    {
        $response = shell_exec('curl -v http://localhost:8080/api/properties');
        return new Response($response);
    }
}
