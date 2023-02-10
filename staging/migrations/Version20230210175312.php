<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230210175312 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE article (unique_id VARCHAR(36) NOT NULL, title VARCHAR(255) NOT NULL, description CLOB NOT NULL, available INTEGER NOT NULL, tags CLOB NOT NULL --(DC2Type:simple_array)
        , status VARCHAR(20) NOT NULL, PRIMARY KEY(unique_id))');
        $this->addSql('CREATE INDEX article_idx ON article (status)');
        $this->addSql('CREATE TABLE article_price (unique_id VARCHAR(36) NOT NULL, article_id VARCHAR(36) NOT NULL, amount DOUBLE PRECISION NOT NULL, description VARCHAR(120) NOT NULL, duration INTEGER NOT NULL, frequency VARCHAR(20) NOT NULL, status VARCHAR(20) NOT NULL, PRIMARY KEY(unique_id), CONSTRAINT FK_BD7F50C87294869C FOREIGN KEY (article_id) REFERENCES article (unique_id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_BD7F50C87294869C ON article_price (article_id)');
        $this->addSql('CREATE INDEX article_price_idx ON article_price (article_id, status)');
        $this->addSql('CREATE TABLE checkout (unique_id VARCHAR(36) NOT NULL, customer_id VARCHAR(36) NOT NULL, address_id VARCHAR(36) NOT NULL, reference VARCHAR(60) NOT NULL, email_address VARCHAR(60) NOT NULL, additional_notes CLOB DEFAULT NULL, created_at DATETIME NOT NULL, status VARCHAR(20) NOT NULL, PRIMARY KEY(unique_id), CONSTRAINT FK_AF382D4E9395C3F3 FOREIGN KEY (customer_id) REFERENCES customer (unique_id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_AF382D4EF5B7AF75 FOREIGN KEY (address_id) REFERENCES customer_postal_address (unique_id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_AF382D4E9395C3F3 ON checkout (customer_id)');
        $this->addSql('CREATE INDEX IDX_AF382D4EF5B7AF75 ON checkout (address_id)');
        $this->addSql('CREATE INDEX checkout_idx ON checkout (customer_id, address_id)');
        $this->addSql('CREATE TABLE checkout_item (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, checkout_id VARCHAR(36) NOT NULL, price_id VARCHAR(36) NOT NULL, unique_id VARCHAR(36) NOT NULL, additional_notes CLOB DEFAULT NULL, CONSTRAINT FK_F442D0C0146D8724 FOREIGN KEY (checkout_id) REFERENCES checkout (unique_id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_F442D0C0D614C7E7 FOREIGN KEY (price_id) REFERENCES article_price (unique_id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_F442D0C0146D8724 ON checkout_item (checkout_id)');
        $this->addSql('CREATE INDEX IDX_F442D0C0D614C7E7 ON checkout_item (price_id)');
        $this->addSql('CREATE INDEX checkout_item_ids ON checkout_item (unique_id, checkout_id, price_id)');
        $this->addSql('CREATE TABLE checkout_payment (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, checkout_id VARCHAR(36) NOT NULL, customer_id VARCHAR(36) NOT NULL, unique_id VARCHAR(36) NOT NULL, amount DOUBLE PRECISION NOT NULL, user_agent CLOB NOT NULL, user_ip VARCHAR(60) NOT NULL, card_name VARCHAR(30) NOT NULL, card_number VARCHAR(30) NOT NULL, card_type VARCHAR(20) NOT NULL, additional_notes CLOB DEFAULT NULL, created_at DATETIME NOT NULL, status VARCHAR(20) NOT NULL, CONSTRAINT FK_914360749395C3F3 FOREIGN KEY (customer_id) REFERENCES customer (unique_id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_91436074146D8724 FOREIGN KEY (checkout_id) REFERENCES checkout (unique_id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_914360749395C3F3 ON checkout_payment (customer_id)');
        $this->addSql('CREATE INDEX IDX_91436074146D8724 ON checkout_payment (checkout_id)');
        $this->addSql('CREATE INDEX checkout_payment_ids ON checkout_payment (unique_id, checkout_id, customer_id)');
        $this->addSql('CREATE TABLE customer (unique_id VARCHAR(36) NOT NULL, grade VARCHAR(20) NOT NULL, first_name VARCHAR(30) NOT NULL, last_name VARCHAR(30) NOT NULL, phone_number VARCHAR(20) NOT NULL, birth_date DATE NOT NULL, email_address VARCHAR(60) NOT NULL, status VARCHAR(20) NOT NULL, PRIMARY KEY(unique_id))');
        $this->addSql('CREATE INDEX customer_idx ON customer (status)');
        $this->addSql('CREATE TABLE customer_postal_address (unique_id VARCHAR(36) NOT NULL, customer_id VARCHAR(36) NOT NULL, street VARCHAR(120) NOT NULL, postal_code VARCHAR(10) NOT NULL, locality VARCHAR(60) NOT NULL, country VARCHAR(60) NOT NULL, residence VARCHAR(120) DEFAULT NULL, floor INTEGER DEFAULT NULL, entry_code VARCHAR(10) DEFAULT NULL, intercom VARCHAR(10) DEFAULT NULL, additional_notes CLOB DEFAULT NULL, status VARCHAR(20) NOT NULL, PRIMARY KEY(unique_id), CONSTRAINT FK_E43CF3D9395C3F3 FOREIGN KEY (customer_id) REFERENCES customer (unique_id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_E43CF3D9395C3F3 ON customer_postal_address (customer_id)');
        $this->addSql('CREATE INDEX customer_postal_address_idx ON customer_postal_address (status, customer_id)');
        $this->addSql('CREATE TABLE messenger_messages (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, body BLOB NOT NULL, headers BLOB NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL)');
        $this->addSql('CREATE INDEX messenger_messages_idx ON messenger_messages (queue_name, available_at, delivered_at)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE article');
        $this->addSql('DROP TABLE article_price');
        $this->addSql('DROP TABLE checkout');
        $this->addSql('DROP TABLE checkout_item');
        $this->addSql('DROP TABLE checkout_payment');
        $this->addSql('DROP TABLE customer');
        $this->addSql('DROP TABLE customer_postal_address');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
