<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210705175016 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commentaires_menus DROP FOREIGN KEY FK_E4D4673CB1E7706E');
        $this->addSql('DROP INDEX IDX_E4D4673CB1E7706E ON commentaires_menus');
        $this->addSql('ALTER TABLE commentaires_menus DROP restaurant_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commentaires_menus ADD restaurant_id INT NOT NULL');
        $this->addSql('ALTER TABLE commentaires_menus ADD CONSTRAINT FK_E4D4673CB1E7706E FOREIGN KEY (restaurant_id) REFERENCES restaurants (id)');
        $this->addSql('CREATE INDEX IDX_E4D4673CB1E7706E ON commentaires_menus (restaurant_id)');
    }
}
