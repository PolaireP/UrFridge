<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231230143340 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ingredient_type_ingredient DROP FOREIGN KEY FK_EC7DAABAC47B8755');
        $this->addSql('ALTER TABLE ingredient_type_ingredient DROP FOREIGN KEY FK_EC7DAABA933FE08C');
        $this->addSql('DROP TABLE ingredient_type_ingredient');
        $this->addSql('ALTER TABLE ingredient ADD ingredient_type_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE ingredient ADD CONSTRAINT FK_6BAF7870C47B8755 FOREIGN KEY (ingredient_type_id) REFERENCES ingredient_type (id)');
        $this->addSql('CREATE INDEX IDX_6BAF7870C47B8755 ON ingredient (ingredient_type_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE ingredient_type_ingredient (ingredient_type_id INT NOT NULL, ingredient_id INT NOT NULL, INDEX IDX_EC7DAABAC47B8755 (ingredient_type_id), INDEX IDX_EC7DAABA933FE08C (ingredient_id), PRIMARY KEY(ingredient_type_id, ingredient_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE ingredient_type_ingredient ADD CONSTRAINT FK_EC7DAABAC47B8755 FOREIGN KEY (ingredient_type_id) REFERENCES ingredient_type (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE ingredient_type_ingredient ADD CONSTRAINT FK_EC7DAABA933FE08C FOREIGN KEY (ingredient_id) REFERENCES ingredient (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE ingredient DROP FOREIGN KEY FK_6BAF7870C47B8755');
        $this->addSql('DROP INDEX IDX_6BAF7870C47B8755 ON ingredient');
        $this->addSql('ALTER TABLE ingredient DROP ingredient_type_id');
    }
}
