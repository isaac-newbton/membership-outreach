<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200107213128 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE phone_call (id INT AUTO_INCREMENT NOT NULL, contact_action_id INT DEFAULT NULL, phone_number VARCHAR(30) DEFAULT NULL, recording_url VARCHAR(2048) DEFAULT NULL, INDEX IDX_2F8A7D2CF3C3D34E (contact_action_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE phone_call ADD CONSTRAINT FK_2F8A7D2CF3C3D34E FOREIGN KEY (contact_action_id) REFERENCES contact_action (id)');
        $this->addSql('DROP TABLE `call`');
        $this->addSql('ALTER TABLE email ADD contact_action_id INT DEFAULT NULL, ADD to_email VARCHAR(255) DEFAULT NULL, ADD from_email VARCHAR(255) DEFAULT NULL, ADD cc_email VARCHAR(2048) DEFAULT NULL, ADD bcc_email VARCHAR(2048) DEFAULT NULL, ADD subject VARCHAR(255) DEFAULT NULL, ADD body LONGTEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE email ADD CONSTRAINT FK_E7927C74F3C3D34E FOREIGN KEY (contact_action_id) REFERENCES contact_action (id)');
        $this->addSql('CREATE INDEX IDX_E7927C74F3C3D34E ON email (contact_action_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE `call` (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('DROP TABLE phone_call');
        $this->addSql('ALTER TABLE email DROP FOREIGN KEY FK_E7927C74F3C3D34E');
        $this->addSql('DROP INDEX IDX_E7927C74F3C3D34E ON email');
        $this->addSql('ALTER TABLE email DROP contact_action_id, DROP to_email, DROP from_email, DROP cc_email, DROP bcc_email, DROP subject, DROP body');
    }
}
