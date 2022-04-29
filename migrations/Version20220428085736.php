<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220428085736 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE etape (id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', voyage_id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', departure_id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', arrival_id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', type VARCHAR(255) NOT NULL, number VARCHAR(255) NOT NULL, seat VARCHAR(255) DEFAULT NULL, gate VARCHAR(255) DEFAULT NULL, baggage_drop VARCHAR(255) DEFAULT NULL, step_order SMALLINT NOT NULL, INDEX IDX_285F75DD68C9E5AF (voyage_id), INDEX IDX_285F75DD7704ED06 (departure_id), INDEX IDX_285F75DD62789708 (arrival_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ville (id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE voyage (id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE etape ADD CONSTRAINT FK_285F75DD68C9E5AF FOREIGN KEY (voyage_id) REFERENCES voyage (id)');
        $this->addSql('ALTER TABLE etape ADD CONSTRAINT FK_285F75DD7704ED06 FOREIGN KEY (departure_id) REFERENCES ville (id)');
        $this->addSql('ALTER TABLE etape ADD CONSTRAINT FK_285F75DD62789708 FOREIGN KEY (arrival_id) REFERENCES ville (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE etape DROP FOREIGN KEY FK_285F75DD7704ED06');
        $this->addSql('ALTER TABLE etape DROP FOREIGN KEY FK_285F75DD62789708');
        $this->addSql('ALTER TABLE etape DROP FOREIGN KEY FK_285F75DD68C9E5AF');
        $this->addSql('DROP TABLE etape');
        $this->addSql('DROP TABLE ville');
        $this->addSql('DROP TABLE voyage');
    }
}
