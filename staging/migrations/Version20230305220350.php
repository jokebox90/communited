<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230305220350 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE blog_categories (unique_id VARCHAR(36) NOT NULL, slug VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(510) DEFAULT NULL, image VARCHAR(255) DEFAULT NULL, PRIMARY KEY(unique_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE blog_posts (unique_id VARCHAR(36) NOT NULL, title VARCHAR(255) NOT NULL, description VARCHAR(510) DEFAULT NULL, content LONGTEXT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(unique_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE blog_categorized (post_id VARCHAR(36) NOT NULL, category_id VARCHAR(36) NOT NULL, INDEX IDX_95C9D844B89032C (post_id), INDEX IDX_95C9D8412469DE2 (category_id), PRIMARY KEY(post_id, category_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE blog_categorized ADD CONSTRAINT FK_95C9D844B89032C FOREIGN KEY (post_id) REFERENCES blog_posts (unique_id)');
        $this->addSql('ALTER TABLE blog_categorized ADD CONSTRAINT FK_95C9D8412469DE2 FOREIGN KEY (category_id) REFERENCES blog_categories (unique_id)');
        $this->addSql('DROP INDEX uniq_8d93d649f85e0677 ON app_users');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_C2502824F85E0677 ON app_users (username)');
        $this->addSql('DROP INDEX uniq_8d93d649e7927c74 ON app_users');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_C2502824E7927C74 ON app_users (email)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE blog_categorized DROP FOREIGN KEY FK_95C9D844B89032C');
        $this->addSql('ALTER TABLE blog_categorized DROP FOREIGN KEY FK_95C9D8412469DE2');
        $this->addSql('DROP TABLE blog_categories');
        $this->addSql('DROP TABLE blog_posts');
        $this->addSql('DROP TABLE blog_categorized');
        $this->addSql('DROP INDEX uniq_c2502824e7927c74 ON app_users');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649E7927C74 ON app_users (email)');
        $this->addSql('DROP INDEX uniq_c2502824f85e0677 ON app_users');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649F85E0677 ON app_users (username)');
    }
}
