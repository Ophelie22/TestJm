<?php

namespace App\Command;

use Elasticsearch\Client;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'app:setup-elastic-test-data',
    description: 'Index a test freelance into Elasticsearch for testing'
)]
class ElasticSetupCommand extends Command
{
    public function __construct(private Client $client)
    {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->client->index([
            'index' => 'freelance',
            'body' => [
                'firstName' => 'Jean',
                'lastName' => 'Paul',
                'jobTitle' => 'Développeur Symfony'
            ]
        ]);

        $this->client->indices()->refresh(['index' => 'freelances']);

        $output->writeln('<info>Freelance de test indexé avec succès ✅</info>');

        return Command::SUCCESS;
    }
}
