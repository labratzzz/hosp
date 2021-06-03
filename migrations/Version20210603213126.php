<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210603213126 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE posts CHANGE created_at created_at DATETIME NOT NULL');
        $this->addSql('ALTER TABLE users ADD sex INT DEFAULT NULL, ADD polis VARCHAR(16) DEFAULT NULL, ADD phone VARCHAR(10) DEFAULT NULL, CHANGE created_at created_at DATETIME NOT NULL');
        $this->addSql('UPDATE users SET sex = 0');
        $this->addSql('ALTER TABLE users CHANGE sex sex INT NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE posts CHANGE created_at created_at DATETIME NOT NULL');
        $this->addSql('ALTER TABLE users DROP sex, DROP polis, DROP phone, CHANGE created_at created_at DATETIME NOT NULL');
    }
}
