<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240623092545 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE material_files (id VARCHAR(36) NOT NULL, material_id VARCHAR(36) DEFAULT NULL, file_id VARCHAR(36) DEFAULT NULL, INDEX IDX_50D2EC17E308AC6F (material_id), INDEX IDX_50D2EC1793CB796C (file_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE material_files ADD CONSTRAINT FK_50D2EC17E308AC6F FOREIGN KEY (material_id) REFERENCES material (id)');
        $this->addSql('ALTER TABLE material_files ADD CONSTRAINT FK_50D2EC1793CB796C FOREIGN KEY (file_id) REFERENCES file (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE material_files DROP FOREIGN KEY FK_50D2EC17E308AC6F');
        $this->addSql('ALTER TABLE material_files DROP FOREIGN KEY FK_50D2EC1793CB796C');
        $this->addSql('DROP TABLE material_files');
    }
}
