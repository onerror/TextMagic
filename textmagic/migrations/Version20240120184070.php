<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240120184070 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }
    
    public function up(Schema $schema): void
    {
        $this->addSql("ALTER SEQUENCE customer_id_seq RESTART WITH 1;");
        $this->addSql("ALTER SEQUENCE test_id_seq RESTART WITH 1;");
        $this->addSql("ALTER SEQUENCE question_id_seq RESTART WITH 1;");
        $this->addSql("ALTER SEQUENCE answer_variant_id_seq RESTART WITH 1;");

        $this->addSql(
            "INSERT INTO public.customer (id, surname, login, first_name) VALUES (NEXTVAL('customer_id_seq'), 'Tестов', 'test', 'Тест');"
        );
        $this->addSql("INSERT INTO public.test (id, title) VALUES (NEXTVAL('test_id_seq'), 'Завлекательный тест');");
        
        // 1
        $this->addSql(
            "INSERT INTO public.question (id, title, right_answer_formula, test_id) VALUES (NEXTVAL('question_id_seq'), '2 + 2 =', 'x1 OR x2 OR (x1 AND x2)',1);"
        );
        $this->addSql(
            "INSERT INTO public.answer_variant (id, question_id, title, alias) VALUES (NEXTVAL('answer_variant_id_seq'), 1, '4', 'x1');"
        );
        $this->addSql(
            "INSERT INTO public.answer_variant (id, question_id, title, alias) VALUES (NEXTVAL('answer_variant_id_seq'), 1, '3+1', 'x2');"
        );
        $this->addSql(
            "INSERT INTO public.answer_variant (id, question_id, title, alias) VALUES (NEXTVAL('answer_variant_id_seq'), 1, '10', 'x3');"
        );
        // 2
        $this->addSql(
            "INSERT INTO public.question (id, title, right_answer_formula, test_id) VALUES (NEXTVAL('question_id_seq'), '1 + 1 =', 'x2', 1);"
        );
        $this->addSql(
            "INSERT INTO public.answer_variant (id, question_id, title, alias) VALUES (NEXTVAL('answer_variant_id_seq'), 2, '3', 'x1');"
        );
        $this->addSql(
            "INSERT INTO public.answer_variant (id, question_id, title, alias) VALUES (NEXTVAL('answer_variant_id_seq'), 2, '2', 'x2');"
        );
        $this->addSql(
            "INSERT INTO public.answer_variant (id, question_id, title, alias) VALUES (NEXTVAL('answer_variant_id_seq'), 2, '0', 'x3');"
        );
        
        //3
        $this->addSql(
            "INSERT INTO public.question (id, title, right_answer_formula, test_id) VALUES (NEXTVAL('question_id_seq'), '3 + 3 =', 'x1 OR x3 OR x4 OR (x1 AND x3) OR (x1 AND x4) OR (x3 AND x4) OR (x1 AND x3 AND x4)', 1);"
        );
        $this->addSql(
            "INSERT INTO public.answer_variant (id, question_id, title, alias) VALUES (NEXTVAL('answer_variant_id_seq'), 3, '1 + 5', 'x1');"
        );
        $this->addSql(
            "INSERT INTO public.answer_variant (id, question_id, title, alias) VALUES (NEXTVAL('answer_variant_id_seq'), 3, '1', 'x2');"
        );
        $this->addSql(
            "INSERT INTO public.answer_variant (id, question_id, title, alias) VALUES (NEXTVAL('answer_variant_id_seq'), 3, '6', 'x3');"
        );
        $this->addSql(
            "INSERT INTO public.answer_variant (id, question_id, title, alias) VALUES (NEXTVAL('answer_variant_id_seq'), 3, '2 + 4', 'x4');"
        );
        
        //4
        $this->addSql(
            "INSERT INTO public.question (id, title, right_answer_formula, test_id) VALUES (NEXTVAL('question_id_seq'), '4 + 4 =', 'x1 OR x4 OR (x1 AND x4)', 1);"
        );
        $this->addSql(
            "INSERT INTO public.answer_variant (id, question_id, title, alias) VALUES (NEXTVAL('answer_variant_id_seq'), 4, '8', 'x1');"
        );
        $this->addSql(
            "INSERT INTO public.answer_variant (id, question_id, title, alias) VALUES (NEXTVAL('answer_variant_id_seq'), 4, '4', 'x2');"
        );
        $this->addSql(
            "INSERT INTO public.answer_variant (id, question_id, title, alias) VALUES (NEXTVAL('answer_variant_id_seq'), 4, '0', 'x3');"
        );
        $this->addSql(
            "INSERT INTO public.answer_variant (id, question_id, title, alias) VALUES (NEXTVAL('answer_variant_id_seq'), 4, '0 + 8', 'x4');"
        );
        
    }
    
    public function down(Schema $schema): void
    {
    }
}