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
            "INSERT INTO public.question (id, title, right_answer_formula, test_id) VALUES (NEXTVAL('question_id_seq'), '2 + 2 =', '1,2,3',1);"
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
            "INSERT INTO public.question (id, title, right_answer_formula, test_id) VALUES (NEXTVAL('question_id_seq'), '1 + 1 =', '2', 1);"
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
        
        // 3
        $this->addSql(
            "INSERT INTO public.question (id, title, right_answer_formula, test_id) VALUES (NEXTVAL('question_id_seq'), '3 + 3 =', '1,4,8,5,9,12,13', 1);"
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
        
        // 4
        $this->addSql(
            "INSERT INTO public.question (id, title, right_answer_formula, test_id) VALUES (NEXTVAL('question_id_seq'), '4 + 4 =', '1,8,9', 1);"
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
        
        // 5
        $this->addSql(
            "INSERT INTO public.question (id, title, right_answer_formula, test_id) VALUES (NEXTVAL('question_id_seq'), '5 + 5 =', '4', 1);"
        );
        $this->addSql(
            "INSERT INTO public.answer_variant (id, question_id, title, alias) VALUES (NEXTVAL('answer_variant_id_seq'), 5, '6', 'x1');"
        );
        $this->addSql(
            "INSERT INTO public.answer_variant (id, question_id, title, alias) VALUES (NEXTVAL('answer_variant_id_seq'), 5, '18', 'x2');"
        );
        $this->addSql(
            "INSERT INTO public.answer_variant (id, question_id, title, alias) VALUES (NEXTVAL('answer_variant_id_seq'), 5, '10', 'x3');"
        );
        $this->addSql(
            "INSERT INTO public.answer_variant (id, question_id, title, alias) VALUES (NEXTVAL('answer_variant_id_seq'), 5, '9', 'x4');"
        );
        $this->addSql(
            "INSERT INTO public.answer_variant (id, question_id, title, alias) VALUES (NEXTVAL('answer_variant_id_seq'), 5, '0', 'x5');"
        );
        
        // 6
        $this->addSql(
            "INSERT INTO public.question (id, title, right_answer_formula, test_id) VALUES (NEXTVAL('question_id_seq'), '6 + 6 =', '8,16,24', 1);"
        );
        $this->addSql(
            "INSERT INTO public.answer_variant (id, question_id, title, alias) VALUES (NEXTVAL('answer_variant_id_seq'), 6, '3', 'x1');"
        );
        $this->addSql(
            "INSERT INTO public.answer_variant (id, question_id, title, alias) VALUES (NEXTVAL('answer_variant_id_seq'), 6, '9', 'x2');"
        );
        $this->addSql(
            "INSERT INTO public.answer_variant (id, question_id, title, alias) VALUES (NEXTVAL('answer_variant_id_seq'), 6, '0', 'x3');"
        );
        $this->addSql(
            "INSERT INTO public.answer_variant (id, question_id, title, alias) VALUES (NEXTVAL('answer_variant_id_seq'), 6, '12', 'x4');"
        );
        $this->addSql(
            "INSERT INTO public.answer_variant (id, question_id, title, alias) VALUES (NEXTVAL('answer_variant_id_seq'), 6, '5 + 7', 'x5');"
        );
        
        // 7
        $this->addSql(
            "INSERT INTO public.question (id, title, right_answer_formula, test_id) VALUES (NEXTVAL('question_id_seq'), '7 + 7 =', '2', 1);"
        );
        $this->addSql(
            "INSERT INTO public.answer_variant (id, question_id, title, alias) VALUES (NEXTVAL('answer_variant_id_seq'), 7, '5', 'x1');"
        );
        $this->addSql(
            "INSERT INTO public.answer_variant (id, question_id, title, alias) VALUES (NEXTVAL('answer_variant_id_seq'), 7, '14', 'x2');"
        );
        
        // 8
        $this->addSql(
            "INSERT INTO public.question (id, title, right_answer_formula, test_id) VALUES (NEXTVAL('question_id_seq'), '8 + 8 =', '1', 1);"
        );
        $this->addSql(
            "INSERT INTO public.answer_variant (id, question_id, title, alias) VALUES (NEXTVAL('answer_variant_id_seq'), 8, '16', 'x1');"
        );
        $this->addSql(
            "INSERT INTO public.answer_variant (id, question_id, title, alias) VALUES (NEXTVAL('answer_variant_id_seq'), 8, '12', 'x2');"
        );
        $this->addSql(
            "INSERT INTO public.answer_variant (id, question_id, title, alias) VALUES (NEXTVAL('answer_variant_id_seq'), 8, '9', 'x3');"
        );
        $this->addSql(
            "INSERT INTO public.answer_variant (id, question_id, title, alias) VALUES (NEXTVAL('answer_variant_id_seq'), 8, '5', 'x4');"
        );
        
        // 9
        $this->addSql(
            "INSERT INTO public.question (id, title, right_answer_formula, test_id) VALUES (NEXTVAL('question_id_seq'), '9 + 9 =', '1,4,8,5,9,12,13', 1);"
        );
        $this->addSql(
            "INSERT INTO public.answer_variant (id, question_id, title, alias) VALUES (NEXTVAL('answer_variant_id_seq'), 9, '18', 'x1');"
        );
        $this->addSql(
            "INSERT INTO public.answer_variant (id, question_id, title, alias) VALUES (NEXTVAL('answer_variant_id_seq'), 9, '9', 'x2');"
        );
        $this->addSql(
            "INSERT INTO public.answer_variant (id, question_id, title, alias) VALUES (NEXTVAL('answer_variant_id_seq'), 9, '17 + 1', 'x3');"
        );
        $this->addSql(
            "INSERT INTO public.answer_variant (id, question_id, title, alias) VALUES (NEXTVAL('answer_variant_id_seq'), 9, '2 + 16', 'x4');"
        );
        
        // 10
        $this->addSql(
            "INSERT INTO public.question (id, title, right_answer_formula, test_id) VALUES (NEXTVAL('question_id_seq'), '10 + 10 =', '8', 1);"
        );
        $this->addSql(
            "INSERT INTO public.answer_variant (id, question_id, title, alias) VALUES (NEXTVAL('answer_variant_id_seq'), 10, '0', 'x1');"
        );
        $this->addSql(
            "INSERT INTO public.answer_variant (id, question_id, title, alias) VALUES (NEXTVAL('answer_variant_id_seq'), 10, '2', 'x2');"
        );
        $this->addSql(
            "INSERT INTO public.answer_variant (id, question_id, title, alias) VALUES (NEXTVAL('answer_variant_id_seq'), 10, '8', 'x3');"
        );
        $this->addSql(
            "INSERT INTO public.answer_variant (id, question_id, title, alias) VALUES (NEXTVAL('answer_variant_id_seq'), 10, '20', 'x4');"
        );
    }
    
    public function down(Schema $schema): void
    {
    }
}