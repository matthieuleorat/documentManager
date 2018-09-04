<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180904065409 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SEQUENCE app_user_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE document_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE tag_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE folder_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE app_user (id INT NOT NULL, username VARCHAR(25) NOT NULL, email VARCHAR(100) NOT NULL, password VARCHAR(64) NOT NULL, is_active BOOLEAN NOT NULL, confirmation_token VARCHAR(180) DEFAULT NULL, password_requested_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_88BDF3E9F85E0677 ON app_user (username)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_88BDF3E9E7927C74 ON app_user (email)');
        $this->addSql('CREATE TABLE document (id INT NOT NULL, user_id INT NOT NULL, name VARCHAR(100) NOT NULL, original_file_name VARCHAR(100) DEFAULT NULL, path VARCHAR(100) DEFAULT NULL, description TEXT DEFAULT NULL, file VARCHAR(255) DEFAULT NULL, thumbnail VARCHAR(150) DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_D8698A76A76ED395 ON document (user_id)');
        $this->addSql('CREATE TABLE document_tag (document_id INT NOT NULL, tag_id INT NOT NULL, PRIMARY KEY(document_id, tag_id))');
        $this->addSql('CREATE INDEX IDX_D0234567C33F7837 ON document_tag (document_id)');
        $this->addSql('CREATE INDEX IDX_D0234567BAD26311 ON document_tag (tag_id)');
        $this->addSql('CREATE TABLE tag (id INT NOT NULL, user_id INT NOT NULL, name VARCHAR(100) NOT NULL, color VARCHAR(7) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_389B783A76ED395 ON tag (user_id)');
        $this->addSql('CREATE TABLE folder (id INT NOT NULL, user_id INT NOT NULL, name VARCHAR(100) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_ECA209CDA76ED395 ON folder (user_id)');
        $this->addSql('CREATE TABLE folder_document (folder_id INT NOT NULL, document_id INT NOT NULL, PRIMARY KEY(folder_id, document_id))');
        $this->addSql('CREATE INDEX IDX_11DC299C162CB942 ON folder_document (folder_id)');
        $this->addSql('CREATE INDEX IDX_11DC299CC33F7837 ON folder_document (document_id)');
        $this->addSql('ALTER TABLE document ADD CONSTRAINT FK_D8698A76A76ED395 FOREIGN KEY (user_id) REFERENCES app_user (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE document_tag ADD CONSTRAINT FK_D0234567C33F7837 FOREIGN KEY (document_id) REFERENCES document (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE document_tag ADD CONSTRAINT FK_D0234567BAD26311 FOREIGN KEY (tag_id) REFERENCES tag (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE tag ADD CONSTRAINT FK_389B783A76ED395 FOREIGN KEY (user_id) REFERENCES app_user (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE folder ADD CONSTRAINT FK_ECA209CDA76ED395 FOREIGN KEY (user_id) REFERENCES app_user (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE folder_document ADD CONSTRAINT FK_11DC299C162CB942 FOREIGN KEY (folder_id) REFERENCES folder (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE folder_document ADD CONSTRAINT FK_11DC299CC33F7837 FOREIGN KEY (document_id) REFERENCES document (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE document DROP CONSTRAINT FK_D8698A76A76ED395');
        $this->addSql('ALTER TABLE tag DROP CONSTRAINT FK_389B783A76ED395');
        $this->addSql('ALTER TABLE folder DROP CONSTRAINT FK_ECA209CDA76ED395');
        $this->addSql('ALTER TABLE document_tag DROP CONSTRAINT FK_D0234567C33F7837');
        $this->addSql('ALTER TABLE folder_document DROP CONSTRAINT FK_11DC299CC33F7837');
        $this->addSql('ALTER TABLE document_tag DROP CONSTRAINT FK_D0234567BAD26311');
        $this->addSql('ALTER TABLE folder_document DROP CONSTRAINT FK_11DC299C162CB942');
        $this->addSql('DROP SEQUENCE app_user_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE document_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE tag_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE folder_id_seq CASCADE');
        $this->addSql('DROP TABLE app_user');
        $this->addSql('DROP TABLE document');
        $this->addSql('DROP TABLE document_tag');
        $this->addSql('DROP TABLE tag');
        $this->addSql('DROP TABLE folder');
        $this->addSql('DROP TABLE folder_document');
    }
}
