<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210530155340 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE posts DROP FOREIGN KEY FK_885DBAFA143E90CC');
        $this->addSql('DROP TABLE files');
        $this->addSql('DROP INDEX IDX_885DBAFA143E90CC ON posts');
        $this->addSql('ALTER TABLE posts ADD image VARCHAR(255) NOT NULL, DROP title_image_id, CHANGE created_at created_at DATETIME NOT NULL');
        $this->addSql('ALTER TABLE users CHANGE created_at created_at DATETIME NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE files (id INT AUTO_INCREMENT NOT NULL, uploader_id INT DEFAULT NULL, post_id INT DEFAULT NULL, name VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, path VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, extension VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, size INT NOT NULL, uploaded_at DATETIME NOT NULL, INDEX IDX_635405916678C77 (uploader_id), INDEX IDX_63540594B89032C (post_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE files ADD CONSTRAINT FK_635405916678C77 FOREIGN KEY (uploader_id) REFERENCES users (id) ON UPDATE NO ACTION ON DELETE SET NULL');
        $this->addSql('ALTER TABLE files ADD CONSTRAINT FK_63540594B89032C FOREIGN KEY (post_id) REFERENCES posts (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE posts ADD title_image_id INT DEFAULT NULL, DROP image, CHANGE created_at created_at DATETIME NOT NULL');
        $this->addSql('ALTER TABLE posts ADD CONSTRAINT FK_885DBAFA143E90CC FOREIGN KEY (title_image_id) REFERENCES files (id) ON UPDATE NO ACTION ON DELETE SET NULL');
        $this->addSql('CREATE INDEX IDX_885DBAFA143E90CC ON posts (title_image_id)');
        $this->addSql('ALTER TABLE users CHANGE created_at created_at DATETIME NOT NULL');
    }
}
