<?php

declare(strict_types=1);

// src/Command/ItemCommand.php

namespace App\Command;

use App\Entity\Item;
use App\Repository\ItemRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\TableSeparator;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: "app:item",
    description: "Items de la boutique en ligne.",
)]
final class ItemCommand extends Command
{
    private ItemRepository|null $itemRepository = null;

    public function __construct(ManagerRegistry $doctrine)
    {
        $this->itemRepository = $doctrine->getRepository(Item::class);

        parent::__construct();
    }

    protected function configure()
    {
        $this->setHelp("Vous permet de gérer les items de votre boutique.");
        $this->addOption("limit", "l", InputOption::VALUE_OPTIONAL, "Nombre d'items par page.", 10);
    }

    protected function getOptions(InputInterface $input): array
    {
        $options = [];

        $limitValue = $input->getOption("limit");
        $options["limit"] = ($limitValue > 0) ? (int) $limitValue : 10;

        return $options;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $formatter = $this->getHelper("formatter");

        $options = $this->getOptions($input);
        $items = $this->itemRepository->findAll();

        $io->title("Gestion des items");
        foreach ($items as $key => $itemObject) {
            if ($key > 1 && $key % $options["limit"] <= 0) {
                $io->ask("Appuyez sur 'Entrée' pour continuer...");
            }

            $item = $itemObject->populateArray();

            $prices = $item["prices"];
            $priceArray = $prices->map(function ($value) use ($formatter) {
                return [
                    $value["amount"],
                    $value["duration"],
                    $value["frequency"],
                    $value["status"],
                    $formatter->truncate($value["description"], 27),
                ];
            });

            $io->title(sprintf("> Item #%d", $key));

            $io->definitionList(
                ["Element" => "Valeur"],
                new TableSeparator(),
                ["uniqueId"  => $item["uniqueId"]],
                ["available" => $item["available"]],
                ["tags"      => implode(", ", $item["tags"])],
                ["status"    => $item["status"]],
            );

            $io->note([
                sprintf("Titre : %s", $item["title"]),
                sprintf("Description : %s", $item["description"]),
            ]);

            $io->section("Tous les prix");
            $io->table(
                [
                    "amount         ",
                    "duration       ",
                    "frequency      ",
                    "status         ",
                    "description                   ",
                ],
                $priceArray->toArray(),
            );
        }

        $output->writeln("done.");
        return Command::SUCCESS;
    }
}
