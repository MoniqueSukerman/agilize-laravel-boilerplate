<?php

namespace App\Packages\Exam\Model;

use App\Packages\Student\Model\Student;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Illuminate\Support\Str;

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
     * @ORM\Column(type="datetime")
     */
    private \DateTime $createdAt;

    /**
     * @ManyToOne(targetEntity="Student")
     */
    private Student $student;

    /**
     * @ManyToOne(targetEntity="Subject")
     */
    private Subject $subject;

    /**
     * @ORM\OneToMany(targetEntity="QuestionExam", mappedBy="exam", cascade={"persist"})
     * @var ArrayCollection|QuestionExam[]
     */
    private ArrayCollection|array $questions;


    public function __construct(Subject $subject, Student $student)
    {
        $this->id = Str::uuid()->toString();
        $this->status = 'open';
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

    public function setStatus(string $status): void
    {
        $this->status = $status;
    }

}