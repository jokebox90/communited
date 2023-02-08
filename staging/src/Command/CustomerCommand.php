<?php

declare(strict_types=1);

// staging/src/Command/CustomerCommand.php

namespace App\Command;

use App\Collection\CustomerCollection;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: "app:customer",
    description: "Clients de la boutique en ligne.",
)]
final class CustomerCommand extends Command
{
    const DEFAULT_CUSTOMER_LIMIT = 5;

    protected function configure()
    {
        $this->setHelp("Vous permet de gérer les clients de votre boutique.");
        $this->addOption("limit", "l", InputOption::VALUE_OPTIONAL, "Nombre de client.", 0);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $io->section("Gestion des clients");

        $limitValue = $input->getOption("limit");
        $limit = ($limitValue > 0) ? $limitValue : CustomerCommand::DEFAULT_CUSTOMER_LIMIT;
        $customers = new CustomerCollection();
        $results = $customers->getAll($limit);

        $io = new SymfonyStyle($input, $output);
        for ($i = 0; $i < count($results); $i++) {
            $io->section(sprintf("Client #%d", $i + 1));
            $io->listing(
                [
                    sprintf("unique_id:   %s", $results[$i]["unique_id"]),
                    sprintf("_sumùp_id:   %s", $results[$i]["_sumùp_id"]),
                    sprintf("grade:       %s", $results[$i]["grade"]),
                    sprintf("firstname:   %s", $results[$i]["firstname"]),
                    sprintf("lastname:    %s", $results[$i]["lastname"]),
                    sprintf("address:\r\n\t%s", implode("\r\n\t", array_values($results[$i]["address"]))),
                    sprintf("phone:       %s", $results[$i]["phone"]),
                    sprintf("email:       %s", $results[$i]["email"]),
                    sprintf("birthdate:   %s", $results[$i]["birthdate"]),
                ],
            );
        }

        $output->writeln("done.");
        return Command::SUCCESS;
    }
}
