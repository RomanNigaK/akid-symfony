<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240627115354 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE construction_control (id VARCHAR(36) NOT NULL, person_id VARCHAR(36) DEFAULT NULL, post_company VARCHAR(255) NOT NULL, fio VARCHAR(100) NOT NULL, data_order VARCHAR(100) NOT NULL, nrc VARCHAR(100) NOT NULL, create_at DATETIME NOT NULL, update_at DATETIME NOT NULL, UNIQUE INDEX UNIQ_52F29F3F217BBB47 (person_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE representative (id VARCHAR(36) NOT NULL, person_id VARCHAR(36) DEFAULT NULL, post_company VARCHAR(255) NOT NULL, fio VARCHAR(100) NOT NULL, data_order VARCHAR(100) NOT NULL, nrc VARCHAR(100) NOT NULL, create_at DATETIME NOT NULL, update_at DATETIME NOT NULL, UNIQUE INDEX UNIQ_2507390E217BBB47 (person_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE construction_control ADD CONSTRAINT FK_52F29F3F217BBB47 FOREIGN KEY (person_id) REFERENCES person (id)');
        $this->addSql('ALTER TABLE representative ADD CONSTRAINT FK_2507390E217BBB47 FOREIGN KEY (person_id) REFERENCES person (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE construction_control DROP FOREIGN KEY FK_52F29F3F217BBB47');
        $this->addSql('ALTER TABLE representative DROP FOREIGN KEY FK_2507390E217BBB47');
        $this->addSql('DROP TABLE construction_control');
        $this->addSql('DROP TABLE representative');
    }
}
