<?php

namespace App\Controller;

use App\Entity\Agency;
use App\Repository\AgencyRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
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
    #[Route('/api/agencies/{id}', name: 'api_get_agency', methods: ['GET'])]
    public function getAgency(
        Agency $agency,
        SerializerInterface $serializer
    ): JsonResponse
    {
        $jsonAgency = $serializer->serialize($agency, 'json', [
            'groups' => ['agency:read']
        ]);

        return new JsonResponse($jsonAgency, 200, [], true);
    }
    /* api_delete_agency  using entity manager interface return jsonresponse */
    #[Route('/api/agencies/{id}', name: 'api_delete_agency', methods: ['DELETE'])]
    public function deleteAgency(
        Agency $agency,
        EntityManagerInterface $entityManager
    ): JsonResponse
    {
        $entityManager->remove($agency);
        $entityManager->flush();
        return new JsonResponse(null, 204);
    }
    #[Route('/api/agencies', name: 'api_create_agency', methods: ['POST'])]
    public function createAgency(
        Request $request,
        SerializerInterface $serializer,
        EntityManagerInterface $entityManager,
        UrlGeneratorInterface $urlGenerator
        ): JsonResponse
        {   
            $agency = $serializer->deserialize($request->getContent(), Agency::class, 'json');
            $entityManager->persist($agency);
            $entityManager->flush();
            $jsonAgency = $serializer->serialize($agency, 'json', ['groups' => 'agency:read']);
            $location = $urlGenerator->generate('api_get_agency', ['id' => $agency->getId()], UrlGeneratorInterface::ABSOLUTE_URL);
            return new JsonResponse($jsonAgency, JsonResponse::HTTP_CREATED, ["Location" => $location], true);
        }
        
    #[Route('/api/agencies/{id}', name: 'api_update_agency', methods: ['PUT'])]
    public function updateAgency(
        Request $request,
        SerializerInterface $serializer,
        Agency $currentAgency,
        EntityManagerInterface $entityManager
    ): JsonResponse
    {
        $updatedAgency = $serializer->deserialize($request->getContent(), Agency::class, 'json', [AbstractNormalizer::OBJECT_TO_POPULATE => $currentAgency]);
        $entityManager->persist($updatedAgency);
        $entityManager->flush();
        return new JsonResponse(null, JsonResponse::HTTP_NO_CONTENT);
    }
}
