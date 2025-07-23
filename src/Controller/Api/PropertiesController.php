<?php

namespace App\Controller\Api;

use App\Repository\PropertiesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * @Route("/api/properties")
 */
class PropertiesController extends AbstractController
{
    /**
     * @Route("/", name="api_properties_index", methods={"GET"})
     */
    public function index(PropertiesRepository $propertiesRepository, SerializerInterface $serializer): JsonResponse
    {
        $properties = $propertiesRepository->findAll();
        $json = $serializer->serialize($properties, 'json', ['groups' => 'property_list']);
        return new JsonResponse($json, 200, [], true);
    }
}
