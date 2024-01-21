<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240120173230 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE answer_variant_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE customer_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE question_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE test_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE test_attempt_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE test_attempt_answer_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE answer_variant (id INT NOT NULL, question_id INT NOT NULL, title VARCHAR(255) NOT NULL, alias VARCHAR(16) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_B90370DC1E27F6BF ON answer_variant (question_id)');
        $this->addSql('CREATE TABLE customer (id INT NOT NULL, surname VARCHAR(255) DEFAULT NULL, login VARCHAR(255) NOT NULL, first_name VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE question (id INT NOT NULL, title VARCHAR(255) NOT NULL, right_answer_formula VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE test (id INT NOT NULL, title VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE test_attempt (id INT NOT NULL, customer_id INT NOT NULL, test_id INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_C4ADD6AE9395C3F3 ON test_attempt (customer_id)');
        $this->addSql('CREATE INDEX IDX_C4ADD6AE1E5D0459 ON test_attempt (test_id)');
        $this->addSql('CREATE TABLE test_attempt_answer (id INT NOT NULL, question_id INT NOT NULL, test_attempt_id INT NOT NULL, user_answer_bitmask INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_8185D8D11E27F6BF ON test_attempt_answer (question_id)');
        $this->addSql('CREATE INDEX IDX_8185D8D1CAA20852 ON test_attempt_answer (test_attempt_id)');
        $this->addSql('CREATE TABLE messenger_messages (id BIGSERIAL NOT NULL, body TEXT NOT NULL, headers TEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, available_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, delivered_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_75EA56E0FB7336F0 ON messenger_messages (queue_name)');
        $this->addSql('CREATE INDEX IDX_75EA56E0E3BD61CE ON messenger_messages (available_at)');
        $this->addSql('CREATE INDEX IDX_75EA56E016BA31DB ON messenger_messages (delivered_at)');
        $this->addSql('COMMENT ON COLUMN messenger_messages.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN messenger_messages.available_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN messenger_messages.delivered_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE OR REPLACE FUNCTION notify_messenger_messages() RETURNS TRIGGER AS $$
            BEGIN
                PERFORM pg_notify(\'messenger_messages\', NEW.queue_name::text);
                RETURN NEW;
            END;
        $$ LANGUAGE plpgsql;');
        $this->addSql('DROP TRIGGER IF EXISTS notify_trigger ON messenger_messages;');
        $this->addSql('CREATE TRIGGER notify_trigger AFTER INSERT OR UPDATE ON messenger_messages FOR EACH ROW EXECUTE PROCEDURE notify_messenger_messages();');
        $this->addSql('ALTER TABLE answer_variant ADD CONSTRAINT FK_B90370DC1E27F6BF FOREIGN KEY (question_id) REFERENCES question (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE test_attempt ADD CONSTRAINT FK_C4ADD6AE9395C3F3 FOREIGN KEY (customer_id) REFERENCES customer (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE test_attempt ADD CONSTRAINT FK_C4ADD6AE1E5D0459 FOREIGN KEY (test_id) REFERENCES test (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE test_attempt_answer ADD CONSTRAINT FK_8185D8D11E27F6BF FOREIGN KEY (question_id) REFERENCES question (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE test_attempt_answer ADD CONSTRAINT FK_8185D8D1CAA20852 FOREIGN KEY (test_attempt_id) REFERENCES test_attempt (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE answer_variant_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE customer_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE question_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE test_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE test_attempt_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE test_attempt_answer_id_seq CASCADE');
        $this->addSql('ALTER TABLE answer_variant DROP CONSTRAINT FK_B90370DC1E27F6BF');
        $this->addSql('ALTER TABLE test_attempt DROP CONSTRAINT FK_C4ADD6AE9395C3F3');
        $this->addSql('ALTER TABLE test_attempt DROP CONSTRAINT FK_C4ADD6AE1E5D0459');
        $this->addSql('ALTER TABLE test_attempt_answer DROP CONSTRAINT FK_8185D8D11E27F6BF');
        $this->addSql('ALTER TABLE test_attempt_answer DROP CONSTRAINT FK_8185D8D1CAA20852');
        $this->addSql('DROP TABLE answer_variant');
        $this->addSql('DROP TABLE customer');
        $this->addSql('DROP TABLE question');
        $this->addSql('DROP TABLE test');
        $this->addSql('DROP TABLE test_attempt');
        $this->addSql('DROP TABLE test_attempt_answer');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
