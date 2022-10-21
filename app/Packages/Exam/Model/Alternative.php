<?php

namespace App\Packages\Exam\Model;

use Doctrine\ORM\Mapping as ORM;
use Illuminate\Support\Str;
use Doctrine\ORM\Mapping\ManyToOne;

/**
 * @ORM\Entity
 * @ORM\Table(name="alternatives")
 */
class Alternative
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
     * @ManyToOne(targetEntity="Question", inversedBy="alternatives")
     * @var Question
     */
    private Question $question;


    public function __construct(string $description, bool $correct, Question $question)
    {
        $this->id = Str::uuid()->toString();
        $this->description = $description;
        $this->correct = $correct;
        $this->question = $question;

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
     * @return Question
     */
    public function getQuestion(): Question
    {
        return $this->question;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function setCorrect(bool $correct): void
    {
        $this->correct = $correct;
    }

}