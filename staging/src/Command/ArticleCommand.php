<?php

declare(strict_types=1);

// staging/src/Command/ArticleCommand.php

namespace App\Command;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\TableSeparator;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: "app:article",
    description: "Articles de la boutique en ligne.",
)]
final class ArticleCommand extends Command
{
    private ArticleRepository|null $articleRepository = null;

    public function __construct(ManagerRegistry $doctrine)
    {
        $this->articleRepository = $doctrine->getRepository(Article::class);

        parent::__construct();
    }

    protected function configure()
    {
        $this->setHelp("Vous permet de gérer les articles de votre boutique.");
        $this->addOption("limit", "l", InputOption::VALUE_OPTIONAL, "Nombre d'articles par page.", 10);
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
        $articles = $this->articleRepository->findAll();

        $io->title("Gestion des articles");
        foreach ($articles as $key => $articleObject) {
            if ($key > 1 && $key % $options["limit"] <= 0) {
                $io->ask("Appuyez sur 'Entrée' pour continuer...");
            }

            $article = $articleObject->populateArray();

            $prices = $article["prices"];
            $priceArray = $prices->map(function ($value) use ($formatter) {
                return [
                    $value["amount"],
                    $value["duration"],
                    $value["frequency"],
                    $value["status"],
                    $formatter->truncate($value["description"], 27),
                ];
            });

            $io->title(sprintf("> Article #%d", $key));

            $io->definitionList(
                ["Element" => "Valeur"],
                new TableSeparator(),
                ["uniqueId"  => $article["uniqueId"]],
                ["available" => $article["available"]],
                ["tags"      => implode(", ", $article["tags"])],
                ["status"    => $article["status"]],
            );

            $io->note([
                sprintf("Titre : %s", $article["title"]),
                sprintf("Description : %s", $article["description"]),
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
