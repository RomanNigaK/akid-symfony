<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240612094239 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE work_sheet (id VARCHAR(36) NOT NULL, kit_id VARCHAR(36) DEFAULT NULL, name VARCHAR(255) NOT NULL, amount DOUBLE PRECISION NOT NULL, unit VARCHAR(20) NOT NULL, INDEX IDX_AFC7EACD3A8E60EF (kit_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE work_sheet ADD CONSTRAINT FK_AFC7EACD3A8E60EF FOREIGN KEY (kit_id) REFERENCES kit (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE work_sheet DROP FOREIGN KEY FK_AFC7EACD3A8E60EF');
        $this->addSql('DROP TABLE work_sheet');
    }
}
