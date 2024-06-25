<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240622084139 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE work_sheet DROP FOREIGN KEY FK_AFC7EACD3A8E60EF');
        $this->addSql('DROP TABLE work_sheet');
        $this->addSql('ALTER TABLE material ADD kit_id VARCHAR(36) DEFAULT NULL, ADD equipment TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE material ADD CONSTRAINT FK_7CBE75953A8E60EF FOREIGN KEY (kit_id) REFERENCES kit (id)');
        $this->addSql('CREATE INDEX IDX_7CBE75953A8E60EF ON material (kit_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE work_sheet (id VARCHAR(36) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, kit_id VARCHAR(36) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, name VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, amount DOUBLE PRECISION NOT NULL, unit VARCHAR(20) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, INDEX IDX_AFC7EACD3A8E60EF (kit_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE work_sheet ADD CONSTRAINT FK_AFC7EACD3A8E60EF FOREIGN KEY (kit_id) REFERENCES kit (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE material DROP FOREIGN KEY FK_7CBE75953A8E60EF');
        $this->addSql('DROP INDEX IDX_7CBE75953A8E60EF ON material');
        $this->addSql('ALTER TABLE material DROP kit_id, DROP equipment');
    }
}
