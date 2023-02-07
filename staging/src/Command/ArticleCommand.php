<?php

declare(strict_types=1);

// staging/src/Command/ArticleCommand.php

namespace App\Command;

use App\Collection\ArticleCollection;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;


final class ArticleCommand extends Command
{
    protected function configure()
    {
        $this->setName('article');
        $this->setDescription('Articles de la boutique en ligne.');
        $this->setHelp("Vous permet de gérer les articles de votre boutique.");
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        $collection = ArticleCollection::getArticleCollection(5);

        $io->table(
            [
                "title",
                "description",
                "price",
                "duration",
                "available",
                "frequency",
            ],
            $collection
        );

        return Command::SUCCESS;
    }
}
