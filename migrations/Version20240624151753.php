<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240624151753 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE work_materials (id VARCHAR(36) NOT NULL, work_id VARCHAR(36) DEFAULT NULL, material_id VARCHAR(36) DEFAULT NULL, INDEX IDX_F91FBEE0BB3453DB (work_id), INDEX IDX_F91FBEE0E308AC6F (material_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE work_materials ADD CONSTRAINT FK_F91FBEE0BB3453DB FOREIGN KEY (work_id) REFERENCES work (id)');
        $this->addSql('ALTER TABLE work_materials ADD CONSTRAINT FK_F91FBEE0E308AC6F FOREIGN KEY (material_id) REFERENCES material (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE work_materials DROP FOREIGN KEY FK_F91FBEE0BB3453DB');
        $this->addSql('ALTER TABLE work_materials DROP FOREIGN KEY FK_F91FBEE0E308AC6F');
        $this->addSql('DROP TABLE work_materials');
    }
}
