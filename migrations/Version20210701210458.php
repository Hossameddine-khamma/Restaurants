<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210701210458 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE commandes (id INT AUTO_INCREMENT NOT NULL, users_id INT NOT NULL, notes_id INT DEFAULT NULL, restaurants_id INT NOT NULL, commentaires_id INT DEFAULT NULL, type TINYINT(1) NOT NULL, heure DATETIME NOT NULL, INDEX IDX_35D4282C67B3B43D (users_id), UNIQUE INDEX UNIQ_35D4282CFC56F556 (notes_id), INDEX IDX_35D4282C4DCA160A (restaurants_id), UNIQUE INDEX UNIQ_35D4282C17C4B2B0 (commentaires_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE commandes_menus (commandes_id INT NOT NULL, menus_id INT NOT NULL, INDEX IDX_F2044C6E8BF5C2E6 (commandes_id), INDEX IDX_F2044C6E14041B84 (menus_id), PRIMARY KEY(commandes_id, menus_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE commentaires (id INT AUTO_INCREMENT NOT NULL, users_id INT NOT NULL, valeurs VARCHAR(255) NOT NULL, INDEX IDX_D9BEC0C467B3B43D (users_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE menus (id INT AUTO_INCREMENT NOT NULL, entree VARCHAR(255) NOT NULL, plat VARCHAR(255) NOT NULL, dessert VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE notes (id INT AUTO_INCREMENT NOT NULL, valeurs INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE restaurants (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE restaurants_menus (restaurants_id INT NOT NULL, menus_id INT NOT NULL, INDEX IDX_1CE484A4DCA160A (restaurants_id), INDEX IDX_1CE484A14041B84 (menus_id), PRIMARY KEY(restaurants_id, menus_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE users (id INT AUTO_INCREMENT NOT NULL, restaurant_id INT DEFAULT NULL, identifiant VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, adresse VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_1483A5E9C90409EC (identifiant), INDEX IDX_1483A5E9B1E7706E (restaurant_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE users_notes (users_id INT NOT NULL, notes_id INT NOT NULL, INDEX IDX_E66C02C567B3B43D (users_id), INDEX IDX_E66C02C5FC56F556 (notes_id), PRIMARY KEY(users_id, notes_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE commandes ADD CONSTRAINT FK_35D4282C67B3B43D FOREIGN KEY (users_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE commandes ADD CONSTRAINT FK_35D4282CFC56F556 FOREIGN KEY (notes_id) REFERENCES notes (id)');
        $this->addSql('ALTER TABLE commandes ADD CONSTRAINT FK_35D4282C4DCA160A FOREIGN KEY (restaurants_id) REFERENCES restaurants (id)');
        $this->addSql('ALTER TABLE commandes ADD CONSTRAINT FK_35D4282C17C4B2B0 FOREIGN KEY (commentaires_id) REFERENCES commentaires (id)');
        $this->addSql('ALTER TABLE commandes_menus ADD CONSTRAINT FK_F2044C6E8BF5C2E6 FOREIGN KEY (commandes_id) REFERENCES commandes (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE commandes_menus ADD CONSTRAINT FK_F2044C6E14041B84 FOREIGN KEY (menus_id) REFERENCES menus (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE commentaires ADD CONSTRAINT FK_D9BEC0C467B3B43D FOREIGN KEY (users_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE restaurants_menus ADD CONSTRAINT FK_1CE484A4DCA160A FOREIGN KEY (restaurants_id) REFERENCES restaurants (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE restaurants_menus ADD CONSTRAINT FK_1CE484A14041B84 FOREIGN KEY (menus_id) REFERENCES menus (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE users ADD CONSTRAINT FK_1483A5E9B1E7706E FOREIGN KEY (restaurant_id) REFERENCES restaurants (id)');
        $this->addSql('ALTER TABLE users_notes ADD CONSTRAINT FK_E66C02C567B3B43D FOREIGN KEY (users_id) REFERENCES users (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE users_notes ADD CONSTRAINT FK_E66C02C5FC56F556 FOREIGN KEY (notes_id) REFERENCES notes (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commandes_menus DROP FOREIGN KEY FK_F2044C6E8BF5C2E6');
        $this->addSql('ALTER TABLE commandes DROP FOREIGN KEY FK_35D4282C17C4B2B0');
        $this->addSql('ALTER TABLE commandes_menus DROP FOREIGN KEY FK_F2044C6E14041B84');
        $this->addSql('ALTER TABLE restaurants_menus DROP FOREIGN KEY FK_1CE484A14041B84');
        $this->addSql('ALTER TABLE commandes DROP FOREIGN KEY FK_35D4282CFC56F556');
        $this->addSql('ALTER TABLE users_notes DROP FOREIGN KEY FK_E66C02C5FC56F556');
        $this->addSql('ALTER TABLE commandes DROP FOREIGN KEY FK_35D4282C4DCA160A');
        $this->addSql('ALTER TABLE restaurants_menus DROP FOREIGN KEY FK_1CE484A4DCA160A');
        $this->addSql('ALTER TABLE users DROP FOREIGN KEY FK_1483A5E9B1E7706E');
        $this->addSql('ALTER TABLE commandes DROP FOREIGN KEY FK_35D4282C67B3B43D');
        $this->addSql('ALTER TABLE commentaires DROP FOREIGN KEY FK_D9BEC0C467B3B43D');
        $this->addSql('ALTER TABLE users_notes DROP FOREIGN KEY FK_E66C02C567B3B43D');
        $this->addSql('DROP TABLE commandes');
        $this->addSql('DROP TABLE commandes_menus');
        $this->addSql('DROP TABLE commentaires');
        $this->addSql('DROP TABLE menus');
        $this->addSql('DROP TABLE notes');
        $this->addSql('DROP TABLE restaurants');
        $this->addSql('DROP TABLE restaurants_menus');
        $this->addSql('DROP TABLE users');
        $this->addSql('DROP TABLE users_notes');
    }
}
