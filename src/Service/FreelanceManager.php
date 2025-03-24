<?php
namespace App\Service;

use App\Entity\Freelance;
use Doctrine\ORM\EntityManagerInterface;

readonly class FreelanceManager
{
    public function __construct(private EntityManagerInterface $entityManager)
    {
    }

    public function findTheMostUseFirstname(): string
    {
        return $this->entityManager->getRepository(Freelance::class)->findTheMostUseFirstname()['firstname'];
    }

    // More or less 176k freelances. It would be cool if jean-michel.io had a public API.
    public function getNumberOfFreelancesInJeanMichelWebsiteHomePage(): int
    {
        return 100;
    }
    // Exemple fictif
    public function findTheMostUsedFirstName(): array
    {
        // Exemple fictif
        return [
            'firstname' => 'Charly',
            'count' => 5
        ];
    }
}