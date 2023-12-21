<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231220221337 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `order` CHANGE created_timestamp created_timestamp DOUBLE PRECISION NOT NULL');
        $this->addSql('ALTER TABLE position CHANGE created_timestamp created_timestamp DOUBLE PRECISION NOT NULL, CHANGE ended_timestamp ended_timestamp DOUBLE PRECISION DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE position CHANGE created_timestamp created_timestamp INT NOT NULL, CHANGE ended_timestamp ended_timestamp INT DEFAULT NULL');
        $this->addSql('ALTER TABLE `order` CHANGE created_timestamp created_timestamp INT NOT NULL');
    }
}
