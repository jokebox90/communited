<?php

declare(strict_types=1);

// staging/src/Command/ArticleCommand.php

namespace App\Command;

use App\Message\UpdateNotifier;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Messenger\MessageBusInterface;

#[AsCommand(
    name: "app:update",
    description: "Mise à jour de l'application.",
)]
final class UpdateCommand extends Command
{
    /**
     * @var MessageBusInterface $bus Symfony Messenger bus
     */
    private $bus;

    public function __construct(MessageBusInterface $bus)
    {
        $this->bus = $bus;

        parent::__construct();
    }

    protected function configure()
    {
        $this->setHelp("Vous permet de mettre à jour l'application.");
        $this->addArgument("message", InputArgument::OPTIONAL, "Description de la mise à jour.", null);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $io->section("Notification de mise à jour");

        $messageValue = $input->getArgument("message");
        $message = ($messageValue !== null) ? $messageValue : "Mise à jour effectuée.";

        $this->bus->dispatch(new UpdateNotifier(sprintf("UPDATE: %s", $message)));

        $output->writeln("done.");
        return Command::SUCCESS;
    }
}
