<?php

namespace App\Command;


use App\Message\InsertFreelanceLinkedInMessage;
use App\Service\FreelanceManager;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Messenger\MessageBusInterface;

#[AsCommand(
    name: 'app:stats:freelances',
    description: 'Get information about jean-michel.io',
)]
class GetNumberOfFreelanceInJeanMichelCommand extends Command
{
    public function __construct(
        private readonly FreelanceManager $freelanceManager,
        private readonly MessageBusInterface $bus
    ){
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $count = $this->freelanceManager->getNumberOfFreelancesInJeanMichelWebsiteHomePage();
        $io->success("$count freelances trouvés sur la home page de Jean-Michel.io");
        return Command::SUCCESS;
    }
}
