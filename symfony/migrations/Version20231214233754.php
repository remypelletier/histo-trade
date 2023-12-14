<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231214233754 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE broker (id INT AUTO_INCREMENT NOT NULL, broker_api_key_id_id INT DEFAULT NULL, name VARCHAR(128) NOT NULL, INDEX IDX_F6AAF03B4239D151 (broker_api_key_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE broker_api_key (id INT AUTO_INCREMENT NOT NULL, secret_key VARCHAR(255) NOT NULL, access_key VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `order` (id INT AUTO_INCREMENT NOT NULL, position_id_id INT DEFAULT NULL, open DOUBLE PRECISION NOT NULL, fees DOUBLE PRECISION DEFAULT NULL, fees_type VARCHAR(64) DEFAULT NULL, side VARCHAR(32) NOT NULL, quantity DOUBLE PRECISION NOT NULL, leverage DOUBLE PRECISION DEFAULT NULL, created_timestamp INT NOT NULL, INDEX IDX_F5299398F3847A8A (position_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE position (id INT AUTO_INCREMENT NOT NULL, user_id_id INT DEFAULT NULL, symbol VARCHAR(64) NOT NULL, open_average DOUBLE PRECISION DEFAULT NULL, close_average DOUBLE PRECISION DEFAULT NULL, side VARCHAR(32) NOT NULL, pnl DOUBLE PRECISION DEFAULT NULL, quantity DOUBLE PRECISION NOT NULL, leverage DOUBLE PRECISION DEFAULT NULL, created_timestamp INT NOT NULL, ended_timestamp INT DEFAULT NULL, INDEX IDX_462CE4F59D86650F (user_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, broker_api_key_id_id INT DEFAULT NULL, firstname VARCHAR(128) NOT NULL, lastname VARCHAR(128) NOT NULL, email VARCHAR(255) NOT NULL, role VARCHAR(64) NOT NULL, created_at INT NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), INDEX IDX_8D93D6494239D151 (broker_api_key_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE broker ADD CONSTRAINT FK_F6AAF03B4239D151 FOREIGN KEY (broker_api_key_id_id) REFERENCES broker_api_key (id)');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F5299398F3847A8A FOREIGN KEY (position_id_id) REFERENCES position (id)');
        $this->addSql('ALTER TABLE position ADD CONSTRAINT FK_462CE4F59D86650F FOREIGN KEY (user_id_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D6494239D151 FOREIGN KEY (broker_api_key_id_id) REFERENCES broker_api_key (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE broker DROP FOREIGN KEY FK_F6AAF03B4239D151');
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F5299398F3847A8A');
        $this->addSql('ALTER TABLE position DROP FOREIGN KEY FK_462CE4F59D86650F');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D6494239D151');
        $this->addSql('DROP TABLE broker');
        $this->addSql('DROP TABLE broker_api_key');
        $this->addSql('DROP TABLE `order`');
        $this->addSql('DROP TABLE position');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
