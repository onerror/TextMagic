<?php

namespace App\Service;

use App\Entity\Customer;
use App\Entity\Test;
use App\Repository\TestRepository;

class TestService
{
    public function __construct(private readonly TestRepository $testRepository)
    {
    
    }
    
    public function getTestById($testId): ?\App\Entity\Test
    {
            return $this->testRepository->find($testId);
    }
    
    public function getAnyUnfinishedTest(Customer $customer): ?\App\Entity\Test
    {
        $test = $this->testRepository->findOneWithUnfulfilledAttemptsOrNoAttempts($customer);
        return $test;
    }
    
}