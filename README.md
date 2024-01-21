# TextMagic test task
A test task for TextMagic
The task is:

You need to create a simple testing system supporting questions with fuzzy logic and the ability to select multiple
answer options.
What are questions with fuzzy logic? "2 + 2 ="
1. 4
2. 3 + 1
3. 10
The correct responses here will be **1 OR 2 OR (1 AND 2)**. At the same time, any other combinations (for example, **1 AND 3**)
will not be considered correct, despite the fact that they include a correct answer.
What is expected as a result?
A link to GitHub / Bitbucket with code and instructions for deploying the project. The project should be wrapped in a
docker. The user should be able to take the test from beginning to end and see two lists at the end - questions they
answered correctly and questions where the answers contained errors. You should be able to take the test as many times
as you like. Every test result should be saved in the database (displaying results is not necessary) (Optional) Both the
questions and the answers to each question should be shown to the user in a random order for each new series of tests.
Requirements: The task should be completed using Symfony and PostgreSQL. The appearance does not matter, authorization
is not needed, admin panel is not needed, it is enough to once add questions with answers to the database.

# How to run the project locally

## 
To run the project locally after cloning the code just run next command form the folder the project is cloned to
```bash
docker compose build
```

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
