<?php
namespace App\Service;

use FOS\ElasticaBundle\Finder\PaginatedFinderInterface;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Elasticsearch\Client;
use App\Entity\Freelance;
use Elasticsearch\ClientBuilder;
use Psr\Log\LoggerInterface;


readonly class FreelanceSearchService{
    private Client $elasticsearchClient;
    public function __construct(
    #[Autowire(service: "fos_elastica.finder.freelance")]
        private PaginatedFinderInterface $freelanceFinder,
        private LoggerInterface $logger
    ) {
        $this->elasticsearchClient = ClientBuilder::create()
            ->setHosts(['elasticsearch:9200'])
            ->setRetries(2)
            ->setConnectionParams([
                'client' => [
                    'curl' => [
                        CURLOPT_TIMEOUT => 5,
                        CURLOPT_CONNECTTIMEOUT => 5
                    ]
                ]
            ])
            ->build();
    }
    
    public function indexFreelance(Freelance $freelance): void
    {
        // On récupère les données consolidées de FreelanceConso
        $freelanceConso = $freelance->getFreelanceConso();

        if ($freelanceConso) {
            // Prépare le document à indexer
            $document = [
                'id' => $freelanceConso->getId(),
                'firstName' => $freelanceConso->getFirstName(),
                'lastName' => $freelanceConso->getLastName(),
                'jobTitle' => $freelanceConso->getJobTitle(),
                'fullName' => $freelanceConso->getFullName(),
                'linkedInUrl' => $freelanceConso->getLinkedInUrl(),
                //'createdAt' => $freelance->getCreatedAt() ? $freelance->getCreatedAt()->format('Y-m-d H:i:s') : null,
               // 'updatedAt' => $freelance->getUpdatedAt() ? $freelance->getUpdatedAt()->format('Y-m-d H:i:s') : null

            ];
            // Log des données à indexer
            $this->logger->info("Indexing document", ['document' => $document]);

            try {
                $this->elasticsearchClient->index([
                    'index' => 'freelance',
                    'id' => $freelance->getId(),
                    'body' => $document
                ]);
                $this->logger->info("Freelance indexed successfully: " . $freelance->getId());
            } catch (\Exception $e) {
                $this->logger->error("Error indexing freelance: " . $e->getMessage());
            }
        }
    }


    public function searchFreelance(string $query): array
    {
        try {
            // Vérifier si Elasticsearch est accessible
            //dd($this->elasticsearchClient->cluster()->health());
            //$health = $this->elasticsearchClient->cluster()->health();
            //dd([
            //'health' => $health,
            //'host' => ('elasticsearch:9200')
            //]);
            $params = [
                'index' => 'freelance',
                'body' => [
                    'query' => [
                        'multi_match' => [
                            'query' => $query,
                            'fields' => ['firstName', 'lastName', 'jobTitle'],
                            'operator' => 'or',
                            'fuzziness' => 'AUTO'
                        ]
                    ]
                ]
            ];
            // Log de l'appel
            $this->logger->info("Searching for query: " . $query);

            $results = $this->elasticsearchClient->search($params);
            // Log des résultats de la recherche
            $this->logger->info("Search results:", $results);

            // Retourner les résultats avec les données "_source"
            return array_map(function ($hit) {
                return $hit['_source']; // Récupérer les données indexées
            }, $results['hits']['hits']);
        } catch (\Exception $e) {
            // Log de l'erreur
            $this->logger->error('Elasticsearch error: ' . $e->getMessage());
            return []; // Retourner un tableau vide en cas d'erreur
        }
    }
    

    public function indexAllFreelances(array $freelances): array
    {
        $results = [
            'success' => 0,
            'failed' => 0,
            'total' => count($freelances)
        ];

        foreach ($freelances as $freelance) {
            try {
                $this->indexFreelance($freelance);
                $results['success']++;
            } catch (\Exception $e) {
                $this->logger->error("Error indexing freelance {$freelance->getId()}: {$e->getMessage()}");
                $results['failed']++;
            }
        }

        return $results;
    }    
}