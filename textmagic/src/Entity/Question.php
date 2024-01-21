<?php

namespace App\Entity;

use App\Repository\QuestionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: QuestionRepository::class)]
class Question
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(length: 255)]
    private ?string $rightAnswerFormula = null;

    #[ORM\OneToMany(mappedBy: 'question', targetEntity: AnswerVariant::class)]
    private Collection $answerVariants;
    
    #[ORM\OneToMany(mappedBy: 'question', targetEntity: TestAttemptAnswer::class)]
    private Collection $testAttemptAnswers;

    #[ORM\ManyToOne(inversedBy: 'questions')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Test $test = null;

    public function __construct()
    {
        $this->answerVariants = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getRightAnswerFormula(): ?string
    {
        return $this->rightAnswerFormula;
    }

    public function setRightAnswerFormula(string $rightAnswerFormula): static
    {
        $this->rightAnswerFormula = $rightAnswerFormula;

        return $this;
    }

    /**
     * @return Collection<int, AnswerVariant>
     */
    public function getAnswerVariants(): Collection
    {
        return $this->answerVariants;
    }

    public function addAnswerVariant(AnswerVariant $answerVariant): static
    {
        if (!$this->answerVariants->contains($answerVariant)) {
            $this->answerVariants->add($answerVariant);
            $answerVariant->setQuestion($this);
        }

        return $this;
    }

    public function removeAnswerVariant(AnswerVariant $answerVariant): static
    {
        if ($this->answerVariants->removeElement($answerVariant)) {
            // set the owning side to null (unless already changed)
            if ($answerVariant->getQuestion() === $this) {
                $answerVariant->setQuestion(null);
            }
        }

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
}
