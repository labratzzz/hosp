<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210529173325 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE appointments (id INT AUTO_INCREMENT NOT NULL, patient_id INT DEFAULT NULL, doctor_id INT DEFAULT NULL, date DATE NOT NULL, time_slot INT NOT NULL, INDEX IDX_6A41727A6B899279 (patient_id), INDEX IDX_6A41727A87F4FB17 (doctor_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE files (id INT AUTO_INCREMENT NOT NULL, uploader_id INT DEFAULT NULL, post_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, path VARCHAR(255) NOT NULL, extension VARCHAR(255) NOT NULL, size INT NOT NULL, uploaded_at DATETIME NOT NULL, INDEX IDX_635405916678C77 (uploader_id), INDEX IDX_63540594B89032C (post_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE appointments ADD CONSTRAINT FK_6A41727A6B899279 FOREIGN KEY (patient_id) REFERENCES users (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE appointments ADD CONSTRAINT FK_6A41727A87F4FB17 FOREIGN KEY (doctor_id) REFERENCES users (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE files ADD CONSTRAINT FK_635405916678C77 FOREIGN KEY (uploader_id) REFERENCES users (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE files ADD CONSTRAINT FK_63540594B89032C FOREIGN KEY (post_id) REFERENCES posts (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE posts DROP FOREIGN KEY FK_885DBAFAF675F31B');
        $this->addSql('ALTER TABLE posts ADD title_image_id INT DEFAULT NULL, CHANGE created_at created_at DATETIME NOT NULL');
        $this->addSql('ALTER TABLE posts ADD CONSTRAINT FK_885DBAFA143E90CC FOREIGN KEY (title_image_id) REFERENCES files (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE posts ADD CONSTRAINT FK_885DBAFAF675F31B FOREIGN KEY (author_id) REFERENCES users (id) ON DELETE SET NULL');
        $this->addSql('CREATE INDEX IDX_885DBAFA143E90CC ON posts (title_image_id)');
        $this->addSql('ALTER TABLE users ADD type INT NOT NULL, ADD post VARCHAR(255) DEFAULT NULL, CHANGE created_at created_at DATETIME NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE posts DROP FOREIGN KEY FK_885DBAFA143E90CC');
        $this->addSql('DROP TABLE appointments');
        $this->addSql('DROP TABLE files');
        $this->addSql('ALTER TABLE posts DROP FOREIGN KEY FK_885DBAFAF675F31B');
        $this->addSql('DROP INDEX IDX_885DBAFA143E90CC ON posts');
        $this->addSql('ALTER TABLE posts DROP title_image_id, CHANGE created_at created_at DATETIME NOT NULL');
        $this->addSql('ALTER TABLE posts ADD CONSTRAINT FK_885DBAFAF675F31B FOREIGN KEY (author_id) REFERENCES users (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE users DROP type, DROP post, CHANGE created_at created_at DATETIME NOT NULL');
    }
}
