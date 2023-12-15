<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231215122431 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE broker_api_key ADD broker_id INT NOT NULL, ADD user_id INT NOT NULL');
        $this->addSql('ALTER TABLE broker_api_key ADD CONSTRAINT FK_7E70EE676CC064FC FOREIGN KEY (broker_id) REFERENCES broker (id)');
        $this->addSql('ALTER TABLE broker_api_key ADD CONSTRAINT FK_7E70EE67A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_7E70EE676CC064FC ON broker_api_key (broker_id)');
        $this->addSql('CREATE INDEX IDX_7E70EE67A76ED395 ON broker_api_key (user_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE broker_api_key DROP FOREIGN KEY FK_7E70EE676CC064FC');
        $this->addSql('ALTER TABLE broker_api_key DROP FOREIGN KEY FK_7E70EE67A76ED395');
        $this->addSql('DROP INDEX IDX_7E70EE676CC064FC ON broker_api_key');
        $this->addSql('DROP INDEX IDX_7E70EE67A76ED395 ON broker_api_key');
        $this->addSql('ALTER TABLE broker_api_key DROP broker_id, DROP user_id');
    }
}
