<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230214140249 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE messenger_messages (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, body BLOB NOT NULL, headers BLOB NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL)');
        $this->addSql('CREATE INDEX messenger_messages_idx ON messenger_messages (queue_name, available_at, delivered_at)');
        $this->addSql('CREATE TABLE shop_addresses (unique_id VARCHAR(36) NOT NULL, customer_id VARCHAR(36) DEFAULT NULL, street VARCHAR(120) NOT NULL, postal_code VARCHAR(10) NOT NULL, locality VARCHAR(60) NOT NULL, country VARCHAR(60) NOT NULL, residence VARCHAR(120) DEFAULT NULL, floor INTEGER DEFAULT NULL, entry_code VARCHAR(10) DEFAULT NULL, intercom VARCHAR(10) DEFAULT NULL, additional_notes CLOB DEFAULT NULL, status VARCHAR(20) NOT NULL, PRIMARY KEY(unique_id), CONSTRAINT FK_767DFB9D9395C3F3 FOREIGN KEY (customer_id) REFERENCES shop_customers (unique_id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_767DFB9D9395C3F3 ON shop_addresses (customer_id)');
        $this->addSql('CREATE INDEX address_idx ON shop_addresses (status, customer_id)');
        $this->addSql('CREATE TABLE shop_customers (unique_id VARCHAR(36) NOT NULL, grade VARCHAR(20) NOT NULL, first_name VARCHAR(30) NOT NULL, last_name VARCHAR(30) NOT NULL, phone_number VARCHAR(20) NOT NULL, birth_date DATE NOT NULL, email_address VARCHAR(60) NOT NULL, status VARCHAR(20) NOT NULL, PRIMARY KEY(unique_id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_7BE4C0AA6B01BC5B ON shop_customers (phone_number)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_7BE4C0AAB08E074E ON shop_customers (email_address)');
        $this->addSql('CREATE INDEX customer_idx ON shop_customers (status)');
        $this->addSql('CREATE TABLE shop_items (unique_id VARCHAR(36) NOT NULL, title VARCHAR(255) NOT NULL, description CLOB NOT NULL, available INTEGER NOT NULL, tags CLOB NOT NULL --(DC2Type:simple_array)
        , created_at DATETIME NOT NULL, modified_at DATETIME NOT NULL, status VARCHAR(20) NOT NULL, PRIMARY KEY(unique_id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_2608B31F2B36786B ON shop_items (title)');
        $this->addSql('CREATE INDEX item_idx ON shop_items (status)');
        $this->addSql('CREATE TABLE shop_orders (unique_id VARCHAR(36) NOT NULL, customer_id VARCHAR(36) DEFAULT NULL, address_id VARCHAR(36) DEFAULT NULL, reference VARCHAR(60) NOT NULL, email_address VARCHAR(60) DEFAULT NULL, additional_notes CLOB DEFAULT NULL, created_at DATETIME NOT NULL, status VARCHAR(20) NOT NULL, modified_at DATETIME NOT NULL, PRIMARY KEY(unique_id), CONSTRAINT FK_608DDB6C9395C3F3 FOREIGN KEY (customer_id) REFERENCES shop_customers (unique_id) ON DELETE SET NULL NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_608DDB6CF5B7AF75 FOREIGN KEY (address_id) REFERENCES shop_addresses (unique_id) ON DELETE SET NULL NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_608DDB6CAEA34913 ON shop_orders (reference)');
        $this->addSql('CREATE INDEX IDX_608DDB6C9395C3F3 ON shop_orders (customer_id)');
        $this->addSql('CREATE INDEX IDX_608DDB6CF5B7AF75 ON shop_orders (address_id)');
        $this->addSql('CREATE INDEX order_idx ON shop_orders (customer_id, address_id)');
        $this->addSql('CREATE TABLE shop_payments (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, order_id VARCHAR(36) NOT NULL, customer_id VARCHAR(36) NOT NULL, unique_id VARCHAR(36) NOT NULL, amount DOUBLE PRECISION NOT NULL, user_agent CLOB NOT NULL, user_ip VARCHAR(60) NOT NULL, card_name VARCHAR(30) NOT NULL, card_number VARCHAR(30) NOT NULL, card_type VARCHAR(20) NOT NULL, additional_notes CLOB DEFAULT NULL, created_at DATETIME NOT NULL, status VARCHAR(20) NOT NULL, CONSTRAINT FK_BE6A61A49395C3F3 FOREIGN KEY (customer_id) REFERENCES shop_customers (unique_id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_BE6A61A48D9F6D38 FOREIGN KEY (order_id) REFERENCES shop_orders (unique_id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_BE6A61A49395C3F3 ON shop_payments (customer_id)');
        $this->addSql('CREATE INDEX IDX_BE6A61A48D9F6D38 ON shop_payments (order_id)');
        $this->addSql('CREATE INDEX payment_idx ON shop_payments (unique_id, order_id, customer_id)');
        $this->addSql('CREATE TABLE shop_prices (unique_id VARCHAR(36) NOT NULL, item_id VARCHAR(36) DEFAULT NULL, status VARCHAR(20) NOT NULL, amount DOUBLE PRECISION NOT NULL, duration INTEGER NOT NULL, frequency VARCHAR(20) NOT NULL, description VARCHAR(120) NOT NULL, PRIMARY KEY(unique_id), CONSTRAINT FK_61694BDB126F525E FOREIGN KEY (item_id) REFERENCES shop_items (unique_id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_61694BDB126F525E ON shop_prices (item_id)');
        $this->addSql('CREATE INDEX price_idx ON shop_prices (item_id, status)');
        $this->addSql('CREATE TABLE shop_sold (unique_id VARCHAR(36) NOT NULL, order_id VARCHAR(36) NOT NULL, price_id VARCHAR(36) NOT NULL, additional_notes CLOB DEFAULT NULL, PRIMARY KEY(unique_id), CONSTRAINT FK_59203BE28D9F6D38 FOREIGN KEY (order_id) REFERENCES shop_orders (unique_id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_59203BE2D614C7E7 FOREIGN KEY (price_id) REFERENCES shop_prices (unique_id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_59203BE28D9F6D38 ON shop_sold (order_id)');
        $this->addSql('CREATE INDEX IDX_59203BE2D614C7E7 ON shop_sold (price_id)');
        $this->addSql('CREATE INDEX sold_idx ON shop_sold (order_id, price_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE messenger_messages');
        $this->addSql('DROP TABLE shop_addresses');
        $this->addSql('DROP TABLE shop_customers');
        $this->addSql('DROP TABLE shop_items');
        $this->addSql('DROP TABLE shop_orders');
        $this->addSql('DROP TABLE shop_payments');
        $this->addSql('DROP TABLE shop_prices');
        $this->addSql('DROP TABLE shop_sold');
    }
}
