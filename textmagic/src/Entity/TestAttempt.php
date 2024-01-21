<?php

namespace App\Entity;

use App\Repository\TestAttemptRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TestAttemptRepository::class)]
class TestAttempt
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Customer $customer = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Test $test = null;

    #[ORM\OneToMany(mappedBy: 'testAttempt', targetEntity: TestAttemptAnswer::class, orphanRemoval: true)]
    private Collection $testAttemptAnswers;

    #[ORM\Column(type: "boolean", options: ["default" => false])]
    private ?bool $isCompleted = false;

    public function __construct()
    {
        $this->testAttemptAnswers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCustomer(): ?Customer
    {
        return $this->customer;
    }

    public function setCustomer(?Customer $customer): static
    {
        $this->customer = $customer;

        return $this;
    }

    public function getTest(): ?Test
    {
        return $this->test;
    }

    public function setTest(?Test $test): static
    {
        $this->test = $test;

        return $this;
    }

    /**
     * @return Collection<int, TestAttemptAnswer>
     */
    public function getTestAttemptAnswers(): Collection
    {
        return $this->testAttemptAnswers;
    }

    public function addTestAttemptAnswer(TestAttemptAnswer $testAttemptAnswer): static
    {
        if (!$this->testAttemptAnswers->contains($testAttemptAnswer)) {
            $this->testAttemptAnswers->add($testAttemptAnswer);
            $testAttemptAnswer->setTestAttempt($this);
        }

        return $this;
    }

    public function removeTestAttemptAnswer(TestAttemptAnswer $testAttemptAnswer): static
    {
        if ($this->testAttemptAnswers->removeElement($testAttemptAnswer)) {
            // set the owning side to null (unless already changed)
            if ($testAttemptAnswer->getTestAttempt() === $this) {
                $testAttemptAnswer->setTestAttempt(null);
            }
        }

        return $this;
    }

    public function isIsCompleted(): ?bool
    {
        return $this->isCompleted;
    }

    public function setIsCompleted(bool $isCompleted): static
    {
        $this->isCompleted = $isCompleted;

        return $this;
    }
}
