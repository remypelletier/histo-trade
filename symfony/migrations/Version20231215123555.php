<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231215123555 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `order` ADD position_id INT NOT NULL');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F5299398DD842E46 FOREIGN KEY (position_id) REFERENCES position (id)');
        $this->addSql('CREATE INDEX IDX_F5299398DD842E46 ON `order` (position_id)');
        $this->addSql('ALTER TABLE position ADD user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE position ADD CONSTRAINT FK_462CE4F5A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_462CE4F5A76ED395 ON position (user_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE position DROP FOREIGN KEY FK_462CE4F5A76ED395');
        $this->addSql('DROP INDEX IDX_462CE4F5A76ED395 ON position');
        $this->addSql('ALTER TABLE position DROP user_id');
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F5299398DD842E46');
        $this->addSql('DROP INDEX IDX_F5299398DD842E46 ON `order`');
        $this->addSql('ALTER TABLE `order` DROP position_id');
    }
}
