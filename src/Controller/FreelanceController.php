<?php

namespace App\Controller;

use App\Dto\SearchFreelanceConsoDto;
use App\Service\FreelanceSearchService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Doctrine\ORM\EntityManagerInterface;


#[Route("/freelances", name: "freelances_")]
class FreelanceController extends AbstractController
{
    public function __construct(
        private readonly FreelanceSearchService $freelanceSearchService,
        private readonly EntityManagerInterface $entityManager,
        private readonly SerializerInterface $serializer

    ) {}
    #[Route('', name: 'index', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('freelance/index.html.twig');
    } 
    
    //freelances/search?query=Symfony
    #[Route('/search', name: 'search', methods: ['GET'])]
    public function search(Request $request): JsonResponse
    {
        $query = $request->query->get('query', null);

        if (!$query || strlen($query) < 3) {
            return $this->json([
                'error' => 'Le paramètre "query" est requis et doit contenir au moins 3 caractères.'
            ], 400);
        }

        $dto = new SearchFreelanceConsoDto($query);
        $freelanceConsos = $this->freelanceSearchService->searchFreelance($dto->query);

        return $this->json($freelanceConsos, 200, [], ['groups' => 'freelance_conso']);
    }
}