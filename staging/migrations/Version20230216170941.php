<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230216170941 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE messenger_messages (id INT AUTO_INCREMENT NOT NULL, body LONGBLOB NOT NULL, headers LONGBLOB NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX messenger_messages_idx (queue_name, available_at, delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE shop_addresses (unique_id VARCHAR(36) NOT NULL, customer_id VARCHAR(36) DEFAULT NULL, street VARCHAR(120) NOT NULL, postal_code VARCHAR(10) NOT NULL, locality VARCHAR(60) NOT NULL, country VARCHAR(60) NOT NULL, residence VARCHAR(120) DEFAULT NULL, floor INT DEFAULT NULL, entry_code VARCHAR(10) DEFAULT NULL, intercom VARCHAR(10) DEFAULT NULL, additional_notes LONGTEXT DEFAULT NULL, status VARCHAR(20) NOT NULL, created_at DATETIME NOT NULL, modified_at DATETIME NOT NULL, INDEX IDX_767DFB9D9395C3F3 (customer_id), INDEX address_idx (status, customer_id), PRIMARY KEY(unique_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE shop_contacts (unique_id VARCHAR(36) NOT NULL, merchant_id VARCHAR(36) DEFAULT NULL, status VARCHAR(20) NOT NULL, created_at DATETIME NOT NULL, modified_at DATETIME NOT NULL, contact_name VARCHAR(60) NOT NULL, email_address VARCHAR(60) NOT NULL, phone_number VARCHAR(20) NOT NULL, street VARCHAR(120) NOT NULL, postal_code VARCHAR(10) NOT NULL, locality VARCHAR(60) NOT NULL, country VARCHAR(60) NOT NULL, siret VARCHAR(14) NOT NULL, vat VARCHAR(12) NOT NULL, role VARCHAR(60) NOT NULL, additional_notes LONGTEXT NOT NULL, INDEX IDX_E8F8EFE56796D554 (merchant_id), PRIMARY KEY(unique_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE shop_customers (unique_id VARCHAR(36) NOT NULL, status VARCHAR(20) NOT NULL, created_at DATETIME NOT NULL, modified_at DATETIME NOT NULL, grade VARCHAR(20) NOT NULL, first_name VARCHAR(30) NOT NULL, last_name VARCHAR(30) NOT NULL, phone_number VARCHAR(20) NOT NULL, birth_date DATE NOT NULL, email_address VARCHAR(60) NOT NULL, UNIQUE INDEX UNIQ_7BE4C0AA6B01BC5B (phone_number), UNIQUE INDEX UNIQ_7BE4C0AAB08E074E (email_address), INDEX customer_idx (status), PRIMARY KEY(unique_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE shop_items (unique_id VARCHAR(36) NOT NULL, title VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, available INT NOT NULL, tags LONGTEXT NOT NULL COMMENT \'(DC2Type:simple_array)\', created_at DATETIME NOT NULL, modified_at DATETIME NOT NULL, status VARCHAR(20) NOT NULL, UNIQUE INDEX UNIQ_2608B31F2B36786B (title), INDEX item_idx (status), PRIMARY KEY(unique_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE shop_merchants (unique_id VARCHAR(36) NOT NULL, status VARCHAR(20) NOT NULL, created_at DATETIME NOT NULL, modified_at DATETIME NOT NULL, company_name VARCHAR(60) NOT NULL, activity VARCHAR(30) NOT NULL, email_address VARCHAR(60) NOT NULL, phone_number VARCHAR(60) NOT NULL, street VARCHAR(120) NOT NULL, postal_code VARCHAR(10) NOT NULL, locality VARCHAR(60) NOT NULL, country VARCHAR(60) NOT NULL, registration_date DATETIME NOT NULL, website TINYTEXT DEFAULT NULL, PRIMARY KEY(unique_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE shop_orders (unique_id VARCHAR(36) NOT NULL, customer_id VARCHAR(36) DEFAULT NULL, address_id VARCHAR(36) DEFAULT NULL, reference VARCHAR(60) NOT NULL, email_address VARCHAR(60) DEFAULT NULL, additional_notes LONGTEXT DEFAULT NULL, created_at DATETIME NOT NULL, status VARCHAR(20) NOT NULL, modified_at DATETIME NOT NULL, UNIQUE INDEX UNIQ_608DDB6CAEA34913 (reference), INDEX IDX_608DDB6C9395C3F3 (customer_id), INDEX IDX_608DDB6CF5B7AF75 (address_id), INDEX order_idx (customer_id, address_id), PRIMARY KEY(unique_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE shop_payments (unique_id VARCHAR(36) NOT NULL, customer_id VARCHAR(36) DEFAULT NULL, order_id VARCHAR(36) NOT NULL, amount DOUBLE PRECISION NOT NULL, user_agent LONGTEXT NOT NULL, user_ip VARCHAR(60) NOT NULL, card_name VARCHAR(30) NOT NULL, card_number VARCHAR(30) NOT NULL, card_type VARCHAR(20) NOT NULL, additional_notes LONGTEXT DEFAULT NULL, created_at DATETIME NOT NULL, status VARCHAR(20) NOT NULL, modified_at DATETIME NOT NULL, INDEX IDX_BE6A61A49395C3F3 (customer_id), INDEX IDX_BE6A61A48D9F6D38 (order_id), INDEX payment_idx (unique_id, order_id, customer_id), PRIMARY KEY(unique_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE shop_prices (unique_id VARCHAR(36) NOT NULL, item_id VARCHAR(36) DEFAULT NULL, contact_id VARCHAR(36) NOT NULL, status VARCHAR(20) NOT NULL, amount DOUBLE PRECISION NOT NULL, duration INT NOT NULL, frequency VARCHAR(20) NOT NULL, description VARCHAR(120) NOT NULL, created_at DATETIME NOT NULL, modified_at DATETIME NOT NULL, INDEX IDX_61694BDB126F525E (item_id), INDEX IDX_61694BDBE7A1254A (contact_id), INDEX price_idx (item_id, status), PRIMARY KEY(unique_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE shop_sold (unique_id VARCHAR(36) NOT NULL, order_id VARCHAR(36) NOT NULL, price_id VARCHAR(36) NOT NULL, additional_notes LONGTEXT DEFAULT NULL, created_at DATETIME NOT NULL, modified_at DATETIME NOT NULL, INDEX IDX_59203BE28D9F6D38 (order_id), INDEX IDX_59203BE2D614C7E7 (price_id), INDEX sold_idx (order_id, price_id), PRIMARY KEY(unique_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');

        $this->addSql('ALTER TABLE shop_addresses ADD CONSTRAINT FK_767DFB9D9395C3F3 FOREIGN KEY (customer_id) REFERENCES shop_customers (unique_id)');
        $this->addSql('ALTER TABLE shop_contacts ADD CONSTRAINT FK_E8F8EFE56796D554 FOREIGN KEY (merchant_id) REFERENCES shop_merchants (unique_id)');
        $this->addSql('ALTER TABLE shop_orders ADD CONSTRAINT FK_608DDB6C9395C3F3 FOREIGN KEY (customer_id) REFERENCES shop_customers (unique_id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE shop_orders ADD CONSTRAINT FK_608DDB6CF5B7AF75 FOREIGN KEY (address_id) REFERENCES shop_addresses (unique_id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE shop_payments ADD CONSTRAINT FK_BE6A61A49395C3F3 FOREIGN KEY (customer_id) REFERENCES shop_customers (unique_id)');
        $this->addSql('ALTER TABLE shop_payments ADD CONSTRAINT FK_BE6A61A48D9F6D38 FOREIGN KEY (order_id) REFERENCES shop_orders (unique_id)');
        $this->addSql('ALTER TABLE shop_prices ADD CONSTRAINT FK_61694BDB126F525E FOREIGN KEY (item_id) REFERENCES shop_items (unique_id)');
        $this->addSql('ALTER TABLE shop_prices ADD CONSTRAINT FK_61694BDBE7A1254A FOREIGN KEY (contact_id) REFERENCES shop_contacts (unique_id)');
        $this->addSql('ALTER TABLE shop_sold ADD CONSTRAINT FK_59203BE28D9F6D38 FOREIGN KEY (order_id) REFERENCES shop_orders (unique_id)');
        $this->addSql('ALTER TABLE shop_sold ADD CONSTRAINT FK_59203BE2D614C7E7 FOREIGN KEY (price_id) REFERENCES shop_prices (unique_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE shop_addresses DROP FOREIGN KEY FK_767DFB9D9395C3F3');
        $this->addSql('ALTER TABLE shop_contacts DROP FOREIGN KEY FK_E8F8EFE56796D554');
        $this->addSql('ALTER TABLE shop_orders DROP FOREIGN KEY FK_608DDB6C9395C3F3');
        $this->addSql('ALTER TABLE shop_orders DROP FOREIGN KEY FK_608DDB6CF5B7AF75');
        $this->addSql('ALTER TABLE shop_payments DROP FOREIGN KEY FK_BE6A61A49395C3F3');
        $this->addSql('ALTER TABLE shop_payments DROP FOREIGN KEY FK_BE6A61A48D9F6D38');
        $this->addSql('ALTER TABLE shop_prices DROP FOREIGN KEY FK_61694BDB126F525E');
        $this->addSql('ALTER TABLE shop_prices DROP FOREIGN KEY FK_61694BDBE7A1254A');
        $this->addSql('ALTER TABLE shop_sold DROP FOREIGN KEY FK_59203BE28D9F6D38');
        $this->addSql('ALTER TABLE shop_sold DROP FOREIGN KEY FK_59203BE2D614C7E7');
        $this->addSql('DROP TABLE messenger_messages');
        $this->addSql('DROP TABLE shop_addresses');
        $this->addSql('DROP TABLE shop_contacts');
        $this->addSql('DROP TABLE shop_customers');
        $this->addSql('DROP TABLE shop_items');
        $this->addSql('DROP TABLE shop_merchants');
        $this->addSql('DROP TABLE shop_orders');
        $this->addSql('DROP TABLE shop_payments');
        $this->addSql('DROP TABLE shop_prices');
        $this->addSql('DROP TABLE shop_sold');
    }
}
