<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200220145845 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE posted_content (id INT AUTO_INCREMENT NOT NULL, organization_id INT NOT NULL, title VARCHAR(255) DEFAULT NULL, external_id VARCHAR(255) DEFAULT NULL, content LONGTEXT DEFAULT NULL, permalink VARCHAR(2048) DEFAULT NULL, meta LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:json)\', uuid CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', UNIQUE INDEX UNIQ_D696A6BDD17F50A6 (uuid), INDEX IDX_D696A6BD32C8A3DE (organization_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE posted_content_hit (id INT AUTO_INCREMENT NOT NULL, posted_content_id INT NOT NULL, type VARCHAR(30) NOT NULL, meta LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:json)\', datetime DATETIME NOT NULL, INDEX IDX_6DFFD2534AF685BB (posted_content_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE posted_content ADD CONSTRAINT FK_D696A6BD32C8A3DE FOREIGN KEY (organization_id) REFERENCES organization (id)');
        $this->addSql('ALTER TABLE posted_content_hit ADD CONSTRAINT FK_6DFFD2534AF685BB FOREIGN KEY (posted_content_id) REFERENCES posted_content (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE posted_content_hit DROP FOREIGN KEY FK_6DFFD2534AF685BB');
        $this->addSql('DROP TABLE posted_content');
        $this->addSql('DROP TABLE posted_content_hit');
    }
}
