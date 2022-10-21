<?php

namespace App\Packages\Exam\Model;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Illuminate\Support\Str;

/**
 * @ORM\Entity
 * @ORM\Table(name="questions_exams")
 */
class QuestionExam
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
     * @ORM\ManyToOne(targetEntity="Exam", inversedBy="questions_exams")
     * @var Exam
     */
    private Exam $exam;

    /**
     * @ORM\OneToMany(targetEntity="AlternativeExam", mappedBy="question", cascade={"persist"})
     * @var Collection|AlternativeExam[]
     */
    protected Collection|array $alternatives;


    public function __construct(string $description, Exam $exam)
    {
        $this->id = Str::uuid()->toString();
        $this->description = $description;
        $this->exam = $exam;
        $this->alternatives = new ArrayCollection();
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
     * @return Exam
     */
    public function getExam(): Exam
    {
        return $this->exam;
    }

    public function setExam(Exam $exam) : void
    {
        $this->exam = $exam;
    }

    public function addAlternative(AlternativeExam $alternative) : void
    {
        if(!$this->alternatives->contains($alternative)) {
            $alternative->setQuestion($this);
            $this->alternatives->add($alternative);
        }
    }
}