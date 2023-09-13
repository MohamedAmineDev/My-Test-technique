<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230913222846 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE article (id CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', article_description LONGTEXT NOT NULL, unit_description LONGTEXT NOT NULL, unit_code VARCHAR(255) NOT NULL, unit_price DOUBLE PRECISION NOT NULL, vat_amount DOUBLE PRECISION NOT NULL, vat_percentage DOUBLE PRECISION NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE contact (id CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', account_name VARCHAR(255) NOT NULL, address_line1 VARCHAR(255) DEFAULT NULL, address_line2 VARCHAR(255) DEFAULT NULL, city VARCHAR(255) DEFAULT NULL, contact_name VARCHAR(255) DEFAULT NULL, country VARCHAR(255) DEFAULT NULL, zip_code VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `order` (id CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', deliver_to_id CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', amount INT NOT NULL, currency VARCHAR(255) NOT NULL, order_number BIGINT DEFAULT NULL, INDEX IDX_F52993986D7914CF (deliver_to_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sales_order_line (id INT AUTO_INCREMENT NOT NULL, the_order_id CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', article_id CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', amount DOUBLE PRECISION NOT NULL, discount DOUBLE PRECISION NOT NULL, quantity INT NOT NULL, INDEX IDX_93D9398DC416F85B (the_order_id), INDEX IDX_93D9398D7294869C (article_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F52993986D7914CF FOREIGN KEY (deliver_to_id) REFERENCES contact (id)');
        $this->addSql('ALTER TABLE sales_order_line ADD CONSTRAINT FK_93D9398DC416F85B FOREIGN KEY (the_order_id) REFERENCES `order` (id)');
        $this->addSql('ALTER TABLE sales_order_line ADD CONSTRAINT FK_93D9398D7294869C FOREIGN KEY (article_id) REFERENCES article (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F52993986D7914CF');
        $this->addSql('ALTER TABLE sales_order_line DROP FOREIGN KEY FK_93D9398DC416F85B');
        $this->addSql('ALTER TABLE sales_order_line DROP FOREIGN KEY FK_93D9398D7294869C');
        $this->addSql('DROP TABLE article');
        $this->addSql('DROP TABLE contact');
        $this->addSql('DROP TABLE `order`');
        $this->addSql('DROP TABLE sales_order_line');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
