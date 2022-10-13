<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221005073233 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE server_ram_module (id INT AUTO_INCREMENT NOT NULL, server_id INT NOT NULL, ram_id INT NOT NULL, INDEX IDX_AB74932CDFC5FC5E (server_id_id), INDEX IDX_AB74932C8AC2A195 (ram_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE server_ram_module ADD CONSTRAINT FK_AB74932CDFC5FC5E FOREIGN KEY (server_id) REFERENCES server (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE server_ram_module ADD CONSTRAINT FK_AB74932C8AC2A195 FOREIGN KEY (ram_id) REFERENCES ram_module (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE server_ram_module DROP FOREIGN KEY FK_AB74932CDFC5FC5E');
        $this->addSql('ALTER TABLE server_ram_module DROP FOREIGN KEY FK_AB74932C8AC2A195');
        $this->addSql('DROP TABLE server_ram_module');
    }
}
