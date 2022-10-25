<?php

namespace App\Packages\Exam\Model;

use App\Packages\Student\Model\Student;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Illuminate\Support\Str;
use Ramsey\Uuid\Type\Integer;
use App\Packages\Exam\Model\QuestionExam;
use App\Packages\Exam\Model\Subject;
use Doctrine\ORM\Mapping\ManyToOne;

/**
 * @ORM\Entity
 * @ORM\Table(name="exams")
 */
class Exam
{
    /**
     * @ORM\Id
     * @ORM\Column(type="uuid", unique=true)
     */
    private string $id;

    /**
     * @ORM\Column(type="string")
     */
    private string $status;

    /**
     * @ORM\Column(type="integer")
     */
    private int $numberOfQuestions;

    /**
     * @ORM\Column(type="datetime")
     */
    private \DateTime $createdAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private \DateTime $submittedAt;

    /**
     * @ORM\ManyToOne(targetEntity="App\Packages\Student\Model\Student")
     */
    private Student $student;

    /**
     * @ORM\ManyToOne(targetEntity="Subject")
     */
    private Subject $subject;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private int $grade;

    /**
     * @ORM\OneToMany(targetEntity="QuestionExam", mappedBy="exam", cascade={"persist", "remove"})
     * @var Collection|QuestionExam[]
     */
    private Collection|array $questions;


    public function __construct(Subject $subject, Student $student, int $numberOfQuestions)
    {
        $this->id = Str::uuid()->toString();
        $this->status = 'open';
        $this->numberOfQuestions = $numberOfQuestions;
        $this->createdAt = new \DateTime('now');
        $this->subject = $subject;
        $this->student = $student;
        $this->questions = new ArrayCollection;
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
    public function getStatus(): string
        {
        return $this->status;
    }

    /**
     * @return string
     */
    public function getNumberOfQuestions(): string
    {
        return $this->numberOfQuestions;
    }

    /**
     * @return Student
     */
    public function getStudent(): Student
    {
        return $this->student;
    }

    /**
     * @return Subject
     */
    public function getSubject(): Subject
    {
        return $this->subject;
    }

    /**
     * @return datetime
     */
    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    public function getSubmittedAt() : DateTime
    {
        return $this->submittedAt;
    }

    public function getExamQuestions() : Collection
    {
        return $this->questions;
    }

    public function setGrade($grade): void
    {
        $this->grade = $grade;
    }

    public function getGrade() : int
    {
        return $this->grade;
    }

    public function setStatus(string $status): void
    {
        $this->status = $status;
    }

    public function setSubmittedAt(): void
    {
        $this->submittedAt = new DateTime('now');
    }

    public function addQuestion(QuestionExam $question) : void
    {
        if(!$this->questions->contains($question)) {
            $question->setExam($this);
            $this->questions->add($question);
        }
    }

}