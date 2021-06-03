<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use App\DataFixtures\DoctorPostFixtures;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210602185833 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE doctor_posts (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE posts CHANGE created_at created_at DATETIME NOT NULL');
        $this->addSql('ALTER TABLE users ADD post_id INT DEFAULT NULL, DROP post, CHANGE created_at created_at DATETIME NOT NULL');
        $this->addSql('ALTER TABLE users ADD CONSTRAINT FK_1483A5E94B89032C FOREIGN KEY (post_id) REFERENCES doctor_posts (id) ON DELETE SET NULL');
        $this->addSql('CREATE INDEX IDX_1483A5E94B89032C ON users (post_id)');
        $insert = 'INSERT INTO doctor_posts(name) VALUES ';
        $values = '';
        $count = count(DoctorPostFixtures::POSTS);
        $counter = 0;
        foreach (DoctorPostFixtures::POSTS as $post) {
            if ($counter === $count - 1) break;
            $values = sprintf("%s('%s'),", $values, $post);
            $counter++;
        }
        $values = sprintf("%s('%s')", $values, DoctorPostFixtures::POSTS[$counter]);
        $this->addSql($insert.$values);
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE users DROP FOREIGN KEY FK_1483A5E94B89032C');
        $this->addSql('DROP TABLE doctor_posts');
        $this->addSql('ALTER TABLE posts CHANGE created_at created_at DATETIME NOT NULL');
        $this->addSql('DROP INDEX IDX_1483A5E94B89032C ON users');
        $this->addSql('ALTER TABLE users ADD post VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, DROP post_id, CHANGE created_at created_at DATETIME NOT NULL');
    }
}
