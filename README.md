# TextMagic test task

A test task for TextMagic
The task is:

You need to create a simple testing system supporting questions with fuzzy logic and the ability to select multiple
answer options.
What are questions with fuzzy logic? "2 + 2 ="
1. 4
2. 3 + 1
3. 10

The correct responses here will be **1 OR 2 OR (1 AND 2)**. At the same time, any other combinations (for example, **1 AND 3**) will not be considered correct, despite the fact that they include a correct answer.
What is expected as a result?
A link to GitHub / Bitbucket with code and instructions for deploying the project. The project should be wrapped in a
docker. The user should be able to take the test from beginning to end and see two lists at the end - questions they answered correctly and questions where the answers contained errors. You should be able to take the test as many times as you like. Every test result should be saved in the database (displaying results is not necessary) (Optional) Both the questions and the answers to each question should be shown to the user in a random order for each new series of tests.

Requirements: The task should be completed using Symfony and PostgreSQL. The appearance does not matter, authorization is not needed, admin panel is not needed, it is enough to once add questions with answers to the database.

# How to run the project locally

## 
To run the project locally after cloning the code just run next command form the folder the project is cloned to

```bash
docker compose build
```
this will run migrations to the database as well
```bash
docker compose up
```
or if you prefer the detached mode

```bash
docker compose up -d
```
then the site will be available at http://localhost
while the database will be available locally at
`jdbc:postgresql://localhost:5432/postgres`
login and password are `test`

# Disclaimer

All credentials are left in github on purpose, it will only work in docker and has only auth data for test purposes

# Ways to improve

- Unit tests. However, so far the app doesn't have much logic to test. Maybe a couple of integration test would be nice
- Login, auth, admin...
- The purpose of the app is a little vague, so the database schema would be reworked. For example, if more than 32 answer
options per question is needed, then all attempt answers would be stored separately in its own table having relations to
the test_attempt and question tables
- the same holds for the right answers. If the 'formula style' not needed, and there might be very long 'strings' 
of possible answers or formulas are not necessary at all, then another schema would be used, for example, 
we might have a table called right_answers having int (for 32 answer options) as a value and a relation to the question table
or if 32 (integer) is not enough then we would have the table right_answer having relations not only to the question table but to the answer_variant table as well.
- a method to break a test attempt
- calculating scores
- displaying right and wrong answers, not only questions
- if questions are typical and might be shared in many tests then it would be reasonable to add another table between 
a question and a test, their relation would become many to many. The same holds true for questions and answers
- environments for dev, test, prod