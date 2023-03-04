<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230304191714 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE rental (id INT AUTO_INCREMENT NOT NULL, tenant_id INT NOT NULL, property_id INT NOT NULL, UNIQUE INDEX UNIQ_1619C27D9033212A (tenant_id), UNIQUE INDEX UNIQ_1619C27D549213EC (property_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE rental ADD CONSTRAINT FK_1619C27D9033212A FOREIGN KEY (tenant_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE rental ADD CONSTRAINT FK_1619C27D549213EC FOREIGN KEY (property_id) REFERENCES properties (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE rental DROP FOREIGN KEY FK_1619C27D9033212A');
        $this->addSql('ALTER TABLE rental DROP FOREIGN KEY FK_1619C27D549213EC');
        $this->addSql('DROP TABLE rental');
    }
}
