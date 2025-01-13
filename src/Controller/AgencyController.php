<?php

namespace App\Controller;

use App\Entity\Agency;
use App\Repository\AgencyRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class AgencyController extends AbstractController
{
    #[Route('/api/agencies', name: 'api_get_agencies', methods: ['GET'])]
    public function getAgencies(
        AgencyRepository $agencyRepository,
        SerializerInterface $serializer
    ): JsonResponse
    {
        $agencies = $agencyRepository->findAll();
        
        $jsonAgencies = $serializer->serialize($agencies, 'json', [
            'groups' => ['agency:read']
        ]);
        
        return new JsonResponse($jsonAgencies, 200, [], true);
    }
}
