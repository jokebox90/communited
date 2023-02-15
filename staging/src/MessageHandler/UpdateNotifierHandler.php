<?php

// staging/src/MessageHandler/UpdateNotifierHandler.php

namespace App\MessageHandler;

use App\Message\UpdateNotifier;
use Psr\Log\LoggerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class UpdateNotifierHandler
{
    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function __invoke(UpdateNotifier $notifier)
    {
        for ($i = 0; $i < 10; $i++) {
            $this->logger->info(sprintf("Sleeping (%d)...", $i));
            sleep(1);
        }

        $this->logger->info($notifier->getMessage());
    }
}
