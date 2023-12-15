<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231215121217 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE broker DROP FOREIGN KEY FK_F6AAF03B4239D151');
        $this->addSql('DROP INDEX IDX_F6AAF03B4239D151 ON broker');
        $this->addSql('ALTER TABLE broker DROP broker_api_key_id_id');
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F5299398F3847A8A');
        $this->addSql('DROP INDEX IDX_F5299398F3847A8A ON `order`');
        $this->addSql('ALTER TABLE `order` DROP position_id_id');
        $this->addSql('ALTER TABLE position DROP FOREIGN KEY FK_462CE4F59D86650F');
        $this->addSql('DROP INDEX IDX_462CE4F59D86650F ON position');
        $this->addSql('ALTER TABLE position DROP user_id_id');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D6494239D151');
        $this->addSql('DROP INDEX IDX_8D93D6494239D151 ON user');
        $this->addSql('ALTER TABLE user DROP broker_api_key_id_id, CHANGE created_at created_at INT NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user ADD broker_api_key_id_id INT DEFAULT NULL, CHANGE created_at created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D6494239D151 FOREIGN KEY (broker_api_key_id_id) REFERENCES broker_api_key (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_8D93D6494239D151 ON user (broker_api_key_id_id)');
        $this->addSql('ALTER TABLE position ADD user_id_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE position ADD CONSTRAINT FK_462CE4F59D86650F FOREIGN KEY (user_id_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_462CE4F59D86650F ON position (user_id_id)');
        $this->addSql('ALTER TABLE broker ADD broker_api_key_id_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE broker ADD CONSTRAINT FK_F6AAF03B4239D151 FOREIGN KEY (broker_api_key_id_id) REFERENCES broker_api_key (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_F6AAF03B4239D151 ON broker (broker_api_key_id_id)');
        $this->addSql('ALTER TABLE `order` ADD position_id_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F5299398F3847A8A FOREIGN KEY (position_id_id) REFERENCES position (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_F5299398F3847A8A ON `order` (position_id_id)');
    }
}
