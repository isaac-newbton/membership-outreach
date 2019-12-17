<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191217201730 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE organization (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE question (id INT AUTO_INCREMENT NOT NULL, question LONGTEXT NOT NULL, type SMALLINT NOT NULL, options LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE survey (id INT AUTO_INCREMENT NOT NULL, survey_template_id INT NOT NULL, organization_id INT DEFAULT NULL, due_date DATETIME DEFAULT NULL, INDEX IDX_AD5F9BFCBD22D0BD (survey_template_id), INDEX IDX_AD5F9BFC32C8A3DE (organization_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE survey_response (id INT AUTO_INCREMENT NOT NULL, survey_id INT NOT NULL, question_id INT NOT NULL, answer LONGTEXT DEFAULT NULL, INDEX IDX_628C4DDCB3FE509D (survey_id), INDEX IDX_628C4DDC1E27F6BF (question_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE survey_template (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE survey_template_question (survey_template_id INT NOT NULL, question_id INT NOT NULL, INDEX IDX_3A5691E6BD22D0BD (survey_template_id), INDEX IDX_3A5691E61E27F6BF (question_id), PRIMARY KEY(survey_template_id, question_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE survey ADD CONSTRAINT FK_AD5F9BFCBD22D0BD FOREIGN KEY (survey_template_id) REFERENCES survey_template (id)');
        $this->addSql('ALTER TABLE survey ADD CONSTRAINT FK_AD5F9BFC32C8A3DE FOREIGN KEY (organization_id) REFERENCES organization (id)');
        $this->addSql('ALTER TABLE survey_response ADD CONSTRAINT FK_628C4DDCB3FE509D FOREIGN KEY (survey_id) REFERENCES survey (id)');
        $this->addSql('ALTER TABLE survey_response ADD CONSTRAINT FK_628C4DDC1E27F6BF FOREIGN KEY (question_id) REFERENCES question (id)');
        $this->addSql('ALTER TABLE survey_template_question ADD CONSTRAINT FK_3A5691E6BD22D0BD FOREIGN KEY (survey_template_id) REFERENCES survey_template (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE survey_template_question ADD CONSTRAINT FK_3A5691E61E27F6BF FOREIGN KEY (question_id) REFERENCES question (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE survey DROP FOREIGN KEY FK_AD5F9BFC32C8A3DE');
        $this->addSql('ALTER TABLE survey_response DROP FOREIGN KEY FK_628C4DDC1E27F6BF');
        $this->addSql('ALTER TABLE survey_template_question DROP FOREIGN KEY FK_3A5691E61E27F6BF');
        $this->addSql('ALTER TABLE survey_response DROP FOREIGN KEY FK_628C4DDCB3FE509D');
        $this->addSql('ALTER TABLE survey DROP FOREIGN KEY FK_AD5F9BFCBD22D0BD');
        $this->addSql('ALTER TABLE survey_template_question DROP FOREIGN KEY FK_3A5691E6BD22D0BD');
        $this->addSql('DROP TABLE organization');
        $this->addSql('DROP TABLE question');
        $this->addSql('DROP TABLE survey');
        $this->addSql('DROP TABLE survey_response');
        $this->addSql('DROP TABLE survey_template');
        $this->addSql('DROP TABLE survey_template_question');
    }
}
