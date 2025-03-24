<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250324171755 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE freelance (id INT AUTO_INCREMENT NOT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE freelance_conso (id INT AUTO_INCREMENT NOT NULL, freelance_id INT DEFAULT NULL, first_name VARCHAR(255) DEFAULT NULL, last_name VARCHAR(255) DEFAULT NULL, job_title VARCHAR(255) DEFAULT NULL, linked_in_url VARCHAR(255) DEFAULT NULL, full_name VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_B3C282EAE8DF656B (freelance_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE freelance_jean_paul (id INT AUTO_INCREMENT NOT NULL, freelance_id INT DEFAULT NULL, first_name VARCHAR(255) DEFAULT NULL, last_name VARCHAR(255) DEFAULT NULL, job_title VARCHAR(255) DEFAULT NULL, jean_paul_id INT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_30B734A6E8DF656B (freelance_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE freelance_linked_in (id INT AUTO_INCREMENT NOT NULL, freelance_id INT DEFAULT NULL, first_name VARCHAR(255) DEFAULT NULL, last_name VARCHAR(255) DEFAULT NULL, job_title VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, url VARCHAR(255) NOT NULL, INDEX IDX_A0E12D3DE8DF656B (freelance_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE freelance_conso ADD CONSTRAINT FK_B3C282EAE8DF656B FOREIGN KEY (freelance_id) REFERENCES freelance (id)');
        $this->addSql('ALTER TABLE freelance_jean_paul ADD CONSTRAINT FK_30B734A6E8DF656B FOREIGN KEY (freelance_id) REFERENCES freelance (id)');
        $this->addSql('ALTER TABLE freelance_linked_in ADD CONSTRAINT FK_A0E12D3DE8DF656B FOREIGN KEY (freelance_id) REFERENCES freelance (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE freelance_conso DROP FOREIGN KEY FK_B3C282EAE8DF656B');
        $this->addSql('ALTER TABLE freelance_jean_paul DROP FOREIGN KEY FK_30B734A6E8DF656B');
        $this->addSql('ALTER TABLE freelance_linked_in DROP FOREIGN KEY FK_A0E12D3DE8DF656B');
        $this->addSql('DROP TABLE freelance');
        $this->addSql('DROP TABLE freelance_conso');
        $this->addSql('DROP TABLE freelance_jean_paul');
        $this->addSql('DROP TABLE freelance_linked_in');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
