<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231210123827 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526C1BC7E6B6 FOREIGN KEY (writer_id) REFERENCES `person` (id)');
        $this->addSql('ALTER TABLE person CHANGE password password VARCHAR(128) DEFAULT NULL');
        $this->addSql('ALTER TABLE recipe_person ADD CONSTRAINT FK_B9C2CF57217BBB47 FOREIGN KEY (person_id) REFERENCES `person` (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `person` CHANGE password password LONGBLOB DEFAULT NULL');
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526C1BC7E6B6');
        $this->addSql('ALTER TABLE recipe_person DROP FOREIGN KEY FK_B9C2CF57217BBB47');
    }
}
