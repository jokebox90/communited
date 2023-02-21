<?php

declare(strict_types=1);

// src/Command/CustomerCommand.php

namespace App\Command;

use App\Entity\Customer;
use App\Repository\CustomerRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\TableSeparator;
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
    const CUSTOMER_LIMIT = 5;

    private CustomerRepository|null $customerRepository = null;

    public function __construct(ManagerRegistry $doctrine)
    {
        $this->customerRepository = $doctrine->getRepository(Customer::class);

        parent::__construct();
    }

    protected function configure()
    {
        $this->setHelp("Vous permet de gérer les clients de votre boutique.");
        $this->addOption("limit", "l", InputOption::VALUE_OPTIONAL, "Nombre de client.", self::CUSTOMER_LIMIT);
    }

    protected function getOptions(InputInterface $input): array
    {
        $options = [];

        $limitValue = $input->getOption("limit");
        $options["limit"] = ($limitValue > 0) ? (int) $limitValue : self::CUSTOMER_LIMIT;

        return $options;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $formatter = $this->getHelper("formatter");

        $io->section("Gestion des clients");

        $options = $this->getOptions($input);
        $customers = $this->customerRepository->findAll();

        $io = new SymfonyStyle($input, $output);
        foreach ($customers as $key => $customerObject) {
            if ($key > 1 && $key % $options["limit"] <= 0) {
                $io->ask("Appuyez sur 'Entrée' pour continuer...");
            }

            $customer = $customerObject->populateArray();

            $io->title(sprintf("> Client #%d", $key));

            $io->definitionList(
                ["Element         " => "Valeur                             "],
                new TableSeparator(),
                ["uniqueId"     => $customer["uniqueId"]],
                ["firstName"    => $customer["firstName"]],
                ["lastName"     => $customer["lastName"]],
                ["grade"        => $customer["grade"]],
                ["phoneNumber"  => $customer["phoneNumber"]],
                ["emailAddress" => $customer["emailAddress"]],
                ["birthDate"    => $customer["birthDate"]],
            );

            foreach ($customer["Address"] as $subkey => $address) {
                $io->section(sprintf("Adresse #%d", $subkey));

                $io->definitionList(
                    ["Element         " => "Valeur                              "],
                    new TableSeparator(),
                    ["street"          => $address["street"]],
                    ["postalCode"      => $address["postalCode"]],
                    ["locality"        => $address["locality"]],
                    ["country"         => $address["country"]],
                    ["residence"       => $formatter->truncate($address["residence"], 27)],
                    ["floor"           => $address["floor"]],
                    ["entryCode"       => $address["entryCode"]],
                    ["intercom"        => $address["intercom"]],
                    ["additionalNotes" => $formatter->truncate($address["additionalNotes"], 27)],
                    ["status"          => $address["status"]],
                );
            }

            $io->newLine();
        }

        $io->text("done.");
        return Command::SUCCESS;
    }
}
