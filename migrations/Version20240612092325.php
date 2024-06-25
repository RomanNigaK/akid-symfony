<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240612092325 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE work ADD kit_id VARCHAR(36) DEFAULT NULL');
        $this->addSql('ALTER TABLE work ADD CONSTRAINT FK_534E68803A8E60EF FOREIGN KEY (kit_id) REFERENCES kit (id)');
        $this->addSql('CREATE INDEX IDX_534E68803A8E60EF ON work (kit_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE work DROP FOREIGN KEY FK_534E68803A8E60EF');
        $this->addSql('DROP INDEX IDX_534E68803A8E60EF ON work');
        $this->addSql('ALTER TABLE work DROP kit_id');
    }
}
