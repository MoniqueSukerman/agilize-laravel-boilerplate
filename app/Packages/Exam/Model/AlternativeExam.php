<?php

namespace App\Packages\Exam\Model;

use Doctrine\ORM\Mapping as ORM;
use Illuminate\Support\Str;

/**
 * @ORM\Entity
 * @ORM\Table(name="alternatives_exams")
 */
class AlternativeExam
{
    /**
     * @ORM\Id
     * @ORM\Column(type="uuid", unique=true)
     */
    private string $id;

    /**
     * @ORM\Column(type="string")
     */
    private string $description;

    /**
     * @ORM\Column(type="boolean")
     */
    private bool $correct;

    /**
     * @ORM\Column(type="boolean")
     */
    private bool $chosen;

    /**
     * @ORM\ManyToOne(targetEntity="QuestionExam", inversedBy="alternatives")
     * @var QuestionExam
     */
    private QuestionExam $questionExam;


    public function __construct(string $description, bool $correct, QuestionExam $question)
    {
        $this->id = Str::uuid()->toString();
        $this->description = $description;
        $this->correct = $correct;
        $this->chosen = false;
        $this->questionExam = $question;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @return boolean
     */
    public function getCorrect(): bool
    {
        return $this->correct;
    }

    /**
     * @return boolean
     */
    public function getChosen(): bool
    {
        return $this->chosen;
    }

    /**
     * @return QuestionExam
     */
    public function getQuestion(): QuestionExam
    {
        return $this->questionExam;
    }

    public function setQuestion(QuestionExam $question): void
    {
        $this->questionExam = $question;
    }

    public function setChosen($chosen): void
    {
        $this->chosen = $chosen;
    }

}