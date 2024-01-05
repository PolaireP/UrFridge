<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240104124524 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE ingredient_photo (id INT AUTO_INCREMENT NOT NULL, ingredient_photo LONGBLOB NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE ingredient ADD ingredient_photo_id INT DEFAULT NULL, CHANGE avg_unit_volume avg_unit_volumn DOUBLE PRECISION DEFAULT NULL');
        $this->addSql('ALTER TABLE ingredient ADD CONSTRAINT FK_6BAF7870C981C02 FOREIGN KEY (ingredient_photo_id) REFERENCES ingredient_photo (id)');
        $this->addSql('CREATE INDEX IDX_6BAF7870C981C02 ON ingredient (ingredient_photo_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ingredient DROP FOREIGN KEY FK_6BAF7870C981C02');
        $this->addSql('DROP TABLE ingredient_photo');
        $this->addSql('DROP INDEX IDX_6BAF7870C981C02 ON ingredient');
        $this->addSql('ALTER TABLE ingredient DROP ingredient_photo_id, CHANGE avg_unit_volumn avg_unit_volume DOUBLE PRECISION DEFAULT NULL');
    }
}
