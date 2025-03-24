<?php

namespace App\Command;

use App\Entity\Freelance;
use App\Service\FreelanceSearchService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:freelance:index',
    description: 'Index all freelances in Elasticsearch',
)]
class FreelanceIndexCommand extends Command
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly FreelanceSearchService $freelanceSearchService,
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $freelances = $this->entityManager->getRepository(Freelance::class)->findAll();
        $results = $this->freelanceSearchService->indexAllFreelances($freelances);

        $io->success("Freelances indexés : {$results['success']} / {$results['total']} (échoués : {$results['failed']})");

        return Command::SUCCESS;
    }
}

//pour lancer la commande:
//php bin/console app:freelances:index
