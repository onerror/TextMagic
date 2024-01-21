<?php

namespace App\Dto;

class TestAttemptAnswerDTO
{
    private array $userAnswerBitmask;
    private int $questionId;
    
    private int $testAttemptId;
    /**
     * @return mixed
     */
    public function getUserAnswerBitmask()
    {
        return $this->userAnswerBitmask;
    }
    
    /**
     * @param mixed $userAnswerBitmask
     */
    public function setUserAnswerBitmask($userAnswerBitmask): void
    {
        $this->userAnswerBitmask = $userAnswerBitmask;
    }
    
    /**
     * @return mixed
     */
    public function getQuestionId()
    {
        return $this->questionId;
    }
    
    /**
     * @param mixed $questionId
     */
    public function setQuestionId($questionId): void
    {
        $this->questionId = $questionId;
    }
    
    public function getTestAttemptId(): int
    {
        return $this->testAttemptId;
    }
    
    public function setTestAttemptId(int $testAttemptId): void
    {
        $this->testAttemptId = $testAttemptId;
    }
    
}