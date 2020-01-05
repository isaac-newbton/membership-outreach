<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200105135758 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE tag (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE organization_tag (organization_id INT NOT NULL, tag_id INT NOT NULL, INDEX IDX_904E86032C8A3DE (organization_id), INDEX IDX_904E860BAD26311 (tag_id), PRIMARY KEY(organization_id, tag_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE organization_tag ADD CONSTRAINT FK_904E86032C8A3DE FOREIGN KEY (organization_id) REFERENCES organization (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE organization_tag ADD CONSTRAINT FK_904E860BAD26311 FOREIGN KEY (tag_id) REFERENCES tag (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE organization_tag DROP FOREIGN KEY FK_904E860BAD26311');
        $this->addSql('DROP TABLE tag');
        $this->addSql('DROP TABLE organization_tag');
    }
}
