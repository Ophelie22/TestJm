<?php

namespace App\MessageHandler;

use App\Message\InsertFreelanceJeanPaulMessage;
use App\Service\InsertFreelanceJeanPaul;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Lock\LockFactory;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final readonly class InsertFreelanceJeanPaulMessageHandler
{
    public function __construct(
        private InsertFreelanceJeanPaul $insertFreelanceJeanPaul,
        private LockFactory             $lockFactory,
        private EntityManagerInterface  $entityManager)
    {
    }

    public function __invoke(InsertFreelanceJeanPaulMessage $message): void
    {
        //die('debug');
        //dump('handler appelé avec :');
        //dump($message->dto);
        $lock = $this->lockFactory->createLock('insert_freelance');

        $lock->acquire(true);
        try {
        $this->insertFreelanceJeanPaul->insertFreelanceJeanPaul($message->dto);
        $this->entityManager->flush();
    }   finally {
        $lock->release();
    }
}
}