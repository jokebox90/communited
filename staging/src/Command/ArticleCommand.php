<?php

declare(strict_types=1);

// staging/src/Command/ArticleCommand.php

namespace App\Command;

use App\Collection\ArticleCollection;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
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
    protected function configure()
    {
        $this->setHelp("Vous permet de gérer les articles de votre boutique.");
        $this->addOption("limit", "l", InputOption::VALUE_OPTIONAL, "Nombre d'articles.", -1);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $io->section("Gestion des clients");

        $limitValue = $input->getOption("limit");
        $limit = ($limitValue > 0) ? $limitValue : 5;
        $articles = new ArticleCollection();
        $results = $articles->getAll($limit);

        $io = new SymfonyStyle($input, $output);
        for ($i = 0; $i < count($results); $i++) {
            $io->section(sprintf("Article #%d", $i + 1));

            $article = $results[$i];
            $output->writeln(sprintf(" * unique_id:    %s", $article["unique_id"]));
            $output->writeln(sprintf(" * title:        %s", $article["title"]));
            $output->writeln(sprintf(" * description:  %s", $article["description"]));
            $output->writeln(sprintf(" * available:    %d", $article["available"]));
            $output->writeln(sprintf(" * tags:         %s", implode(", ", $article["tags"])));
            $output->writeln(" * prices:");

            for ($j = 0; $j < count($article["prices"]); $j++) {
                $output->writeln(sprintf("\t * price #%d", $j + 1));

                $price = $article["prices"][$j];
                $output->writeln(sprintf("\t\t- amount:     %d € par semaine", $price["amount"]));
                $output->writeln(sprintf("\t\t- frequency:  %s", $price["frequency"]));
                $output->writeln(sprintf("\t\t- duration:   %d", $price["duration"]));
            }
            $output->writeln("");
        }

        $output->writeln("done.");
        return Command::SUCCESS;
    }
}
