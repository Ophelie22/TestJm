<?php

namespace App\Controller;

use App\Repository\FreelanceConsoRepository;
use App\Service\FreelanceManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;


///si jamais je veux ajouter des routes pour l'api, je peux le faire ici:http://localhost:8000/api/freelances/stats
#[Route('/api/freelances', name: 'freelances_api_')]
class FreelanceApiController extends AbstractController
{
    public function __construct(
        private readonly FreelanceManager $freelanceManager,
        private readonly FreelanceConsoRepository $freelanceConsoRepository
    ) {}

    #[Route('/stats', name: 'stats', methods: ['GET'])]
    public function getStats(): JsonResponse
    {
        $count = $this->freelanceManager->getNumberOfFreelancesInJeanMichelWebsiteHomePage();

        return $this->json([
            'freelances_count' => $count,
            'source' => 'jean-michel.io',
            'fetched_at' => (new \DateTime())->format('c')
        ]);
    }
    #[Route('', name: 'list', methods: ['GET'])]
    public function listAll(): JsonResponse
    {
        $freelances = $this->freelanceConsoRepository->findAll();

        return $this->json($freelances, 200, [], ['groups' => 'freelance:read']);


        //GET /api/freelances/most-used-firstname : pour retourner le prénom le plus utilisé avec son nombre d’occurrences.
    }
    #[Route('/most-used-firstname', name: 'firstname_stat', methods: ['GET'])]
    public function getMostUsedFirstName(): JsonResponse
    {
        $data = $this->freelanceManager->findTheMostUsedFirstName();

        return $this->json([
            'most_used_firstname' => $data['firstname'] ?? null,
            'count' => $data['count'] ?? 0
        ]);
    }
}