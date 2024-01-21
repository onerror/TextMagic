<?php

namespace App\Service;

use App\Dto\TestAttemptAnswerDTO;
use App\Entity\Customer;
use App\Entity\Test;
use App\Entity\TestAttempt;
use App\Entity\TestAttemptAnswer;
use App\Helpers\BinaryHelper;
use App\Repository\QuestionRepository;
use App\Repository\TestAttemptAnswerRepository;
use App\Repository\TestAttemptRepository;

class TestAttemptService
{
    private array $possibleKeysForAnswerFormula;
    
    public function __construct(
        private TestAttemptRepository $testAttemptRepository,
        private QuestionRepository $questionRepository,
        private TestAttemptAnswerRepository $testAttemptAnswerRepository
    ) {
        for ($i = 1; $i < BinaryHelper::BYTES_IN_INTEGER + 1; $i++) {
            $this->possibleKeysForAnswerFormula[$i - 1] = 'x' . $i;
        }
    }
    
    public function getLastUncompletedTestAttempt(Test $test): ?\App\Entity\TestAttempt
    {
        $testAttempt = $this->testAttemptRepository->findOneBy(['test' => $test, 'isCompleted' => false],
                                                               ['id' => 'DESC']);
        return $testAttempt;
    }
    
    public function getLastCompletedTestAttempt(Test $test): ?\App\Entity\TestAttempt
    {
        $testAttempt = $this->testAttemptRepository->findOneBy(['test' => $test, 'isCompleted' => true],
                                                               ['id' => 'DESC']);
        return $testAttempt;
    }
    
    public function createNewAttempt(Customer $customer, Test $test): TestAttempt
    {
        $testAttempt = new TestAttempt();
        $testAttempt->setCustomer($customer);
        $testAttempt->setTest($test);
        $testAttempt->setIsCompleted(false);
        $this->testAttemptRepository->save($testAttempt);
        return $testAttempt;
    }
    
    public function addNewAnswer(TestAttemptAnswerDTO $dto)
    {
        $testAttemptAnswer = new TestAttemptAnswer();
        $testAttemptAnswer->setQuestion($this->questionRepository->find($dto->getQuestionId()));
        $testAttemptAnswer->setTestAttempt($this->testAttemptRepository->find($dto->getTestAttemptId()));
        $testAttemptAnswer->setUserAnswerBitmask(BinaryHelper::generateBitmask($dto->getUserAnswerBitmask()));
        
        $this->testAttemptAnswerRepository->save($testAttemptAnswer);
    }
    
    public function markAttemptCompleted(TestAttempt $testAttempt): void
    {
        $testAttempt->setIsCompleted(true);
        $this->testAttemptRepository->save($testAttempt);
    }
    
    public function getRandomUnansweredQuestion(TestAttempt $testAttempt): ?\App\Entity\Question
    {
        return $this->questionRepository->getRandomUnanwseredQuestion($testAttempt);
    }
    
    
    public function getById(int $testAttemptId): ?TestAttempt
    {
        return $this->testAttemptRepository->find($testAttemptId);
    }
    
    public function getQuestionsAnsweredRight(TestAttempt $testAttempt): array
    {
        $userAnswers = $testAttempt->getTestAttemptAnswers();
        $questions = [];
        foreach ($userAnswers as $key => $answer) {
            if (BinaryHelper::isBinaryAnswerFitsAnswerFormula(
                $answer->getUserAnswerBitmask(),
                $answer->getQuestion()->getRightAnswerFormula(),
                $this->possibleKeysForAnswerFormula
            )) {
                $questions[] = $answer->getQuestion();
            }
        }
        return $questions;
    }
    
    public function getQuestionsAnsweredWrong(TestAttempt $testAttempt): array
    {
        $userAnswers = $testAttempt->getTestAttemptAnswers();
        $questions = [];
        foreach ($userAnswers as $key => $answer) {
            if (!BinaryHelper::isBinaryAnswerFitsAnswerFormula(
                $answer->getUserAnswerBitmask(),
                $answer->getQuestion()->getRightAnswerFormula(),
                $this->possibleKeysForAnswerFormula
            )) {
                $questions[] = $answer->getQuestion();
            }
        }
        return $questions;
    }
}