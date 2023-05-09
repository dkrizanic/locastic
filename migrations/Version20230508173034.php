<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230508173034 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE racer (id VARCHAR(255) NOT NULL, race_id VARCHAR(255) NOT NULL, age_category_placement INT DEFAULT NULL, overall_placement INT DEFAULT NULL, full_name VARCHAR(255) NOT NULL, finish_time DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', distance VARCHAR(255) NOT NULL, age_category VARCHAR(255) NOT NULL, INDEX IDX_2ABA2E5F6E59D40D (race_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE racer ADD CONSTRAINT FK_2ABA2E5F6E59D40D FOREIGN KEY (race_id) REFERENCES race (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE racer DROP FOREIGN KEY FK_2ABA2E5F6E59D40D');
        $this->addSql('DROP TABLE racer');
    }
}
