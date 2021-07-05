<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210705205949 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commandes DROP FOREIGN KEY FK_35D4282CFC56F556');
        $this->addSql('DROP TABLE notes');
        $this->addSql('ALTER TABLE commandes DROP FOREIGN KEY FK_35D4282C17C4B2B0');
        $this->addSql('DROP INDEX UNIQ_35D4282CFC56F556 ON commandes');
        $this->addSql('DROP INDEX UNIQ_35D4282C17C4B2B0 ON commandes');
        $this->addSql('ALTER TABLE commandes DROP notes_id, DROP commentaires_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE notes (id INT AUTO_INCREMENT NOT NULL, valeurs INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE commandes ADD notes_id INT DEFAULT NULL, ADD commentaires_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE commandes ADD CONSTRAINT FK_35D4282C17C4B2B0 FOREIGN KEY (commentaires_id) REFERENCES commentaires (id)');
        $this->addSql('ALTER TABLE commandes ADD CONSTRAINT FK_35D4282CFC56F556 FOREIGN KEY (notes_id) REFERENCES notes (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_35D4282CFC56F556 ON commandes (notes_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_35D4282C17C4B2B0 ON commandes (commentaires_id)');
    }
}
