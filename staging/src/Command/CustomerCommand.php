<?php

declare(strict_types=1);

// staging/src/Command/CustomerCommand.php

namespace App\Command;

use App\Collection\CustomerCollection;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;


final class CustomerCommand extends Command
{
    protected function configure()
    {
        $this->setName('customer');
        $this->setDescription('Clients de la boutique en ligne.');
        $this->setHelp("Vous permet de gérer les clients de votre boutique.");
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        $collection = CustomerCollection::getCustomerCollection(5);

        $io->table(
            [
                "firstname",
                "lastname",
                "address",
                "phone",
                "email",
                "customer_id",
                "birthdate",
            ],
            $collection
        );

        return Command::SUCCESS;
    }
}
