<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240627130458 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE person DROP FOREIGN KEY FK_34DCD176FC3FF006');
        $this->addSql('ALTER TABLE person ADD CONSTRAINT FK_34DCD176FC3FF006 FOREIGN KEY (representative_id) REFERENCES representative (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE person DROP FOREIGN KEY FK_34DCD176FC3FF006');
        $this->addSql('ALTER TABLE person ADD CONSTRAINT FK_34DCD176FC3FF006 FOREIGN KEY (representative_id) REFERENCES person (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
    }
}
