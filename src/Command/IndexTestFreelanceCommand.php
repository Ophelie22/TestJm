<?php

namespace App\Command;

use App\Entity\Freelance;
use App\Entity\FreelanceConso;
use App\Service\FreelanceSearchService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'app:index-test-freelance',
    description: 'Indexe un freelance de test dans Elasticsearch',
)]
class IndexTestFreelanceCommand extends Command
{
    public function __construct(
        private readonly EntityManagerInterface $em,
        private readonly FreelanceSearchService $freelanceSearchService,
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        // Créer un FreelanceConso
        $freelanceConso = new FreelanceConso();
        $freelanceConso->setFirstName('Charlie');
        $freelanceConso->setLastName('Dev');
        $freelanceConso->setJobTitle('Développeur Full Stack');
        $freelanceConso->setFullName('Charlie Dev');
        $freelanceConso->setLinkedInUrl('https://linkedin.com/in/charlie-dev');

        // Créer un Freelance
        $freelance = new Freelance();
        $freelance->setCreatedAt(new \DateTime());
        $freelance->setUpdatedAt(new \DateTime());
        $freelance->setFreelanceConso($freelanceConso);

        // Persister dans la base
        $this->em->persist($freelanceConso);
        $this->em->persist($freelance);
        $this->em->flush();

        // Indexer dans Elasticsearch
        $this->freelanceSearchService->indexFreelance($freelance);

        $output->writeln('<info>Freelance de test indexé avec succès 🎉</info>');

        return Command::SUCCESS;
    }
}
