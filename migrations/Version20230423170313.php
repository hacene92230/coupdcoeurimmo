<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230423170313 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE rental_application (id INT AUTO_INCREMENT NOT NULL, id_card_recto VARCHAR(255) NOT NULL, id_card_verso VARCHAR(255) NOT NULL, tax_form VARCHAR(255) NOT NULL, pay_stub1 VARCHAR(255) NOT NULL, pay_stub2 VARCHAR(255) NOT NULL, pay_stub3 VARCHAR(255) NOT NULL, proof_residence VARCHAR(255) NOT NULL, guarantor_pay_stub1 VARCHAR(255) NOT NULL, guarantor_pay_stub2 VARCHAR(255) NOT NULL, guarantor_pay_stub3 VARCHAR(255) NOT NULL, guarantor TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE rental_application');
    }
}
