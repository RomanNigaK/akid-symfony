<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240628184418 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE person ADD construction_control_id VARCHAR(36) DEFAULT NULL');
        $this->addSql('ALTER TABLE person ADD CONSTRAINT FK_34DCD176EC1C622A FOREIGN KEY (construction_control_id) REFERENCES construction_control (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_34DCD176EC1C622A ON person (construction_control_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE person DROP FOREIGN KEY FK_34DCD176EC1C622A');
        $this->addSql('DROP INDEX UNIQ_34DCD176EC1C622A ON person');
        $this->addSql('ALTER TABLE person DROP construction_control_id');
    }
}
