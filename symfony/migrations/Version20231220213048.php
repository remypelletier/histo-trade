<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231220213048 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `order` ADD broker_order_id INT NOT NULL, CHANGE fees fee DOUBLE PRECISION DEFAULT NULL, CHANGE fees_type fee_type VARCHAR(64) DEFAULT NULL');
        $this->addSql('ALTER TABLE position CHANGE created_timestamp created_timestamp INT NOT NULL, CHANGE ended_timestamp ended_timestamp INT DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE position CHANGE created_timestamp created_timestamp DOUBLE PRECISION DEFAULT NULL, CHANGE ended_timestamp ended_timestamp DOUBLE PRECISION DEFAULT NULL');
        $this->addSql('ALTER TABLE `order` DROP broker_order_id, CHANGE fee fees DOUBLE PRECISION DEFAULT NULL, CHANGE fee_type fees_type VARCHAR(64) DEFAULT NULL');
    }
}
