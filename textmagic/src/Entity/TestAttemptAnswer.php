<?php

namespace App\Entity;

use App\Helpers\BinaryHelper;
use App\Repository\TestAttemptAnswerRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TestAttemptAnswerRepository::class)]
class TestAttemptAnswer
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $userAnswerBitmask = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Question $question = null;

    #[ORM\ManyToOne(inversedBy: 'testAttemptAnswers')]
    #[ORM\JoinColumn(nullable: false)]
    private ?TestAttempt $testAttempt = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUserAnswerBitmask(): ?int
    {
        return $this->userAnswerBitmask;
    }

    public function setUserAnswerBitmask(int $userAnswerBitmask): static
    {
        $this->userAnswerBitmask = $userAnswerBitmask;

        return $this;
    }

    public function getQuestion(): ?Question
    {
        return $this->question;
    }

    public function setQuestion(?Question $question): static
    {
        $this->question = $question;

        return $this;
    }

    public function getTestAttempt(): ?TestAttempt
    {
        return $this->testAttempt;
    }

    public function setTestAttempt(?TestAttempt $testAttempt): static
    {
        $this->testAttempt = $testAttempt;

        return $this;
    }
}
