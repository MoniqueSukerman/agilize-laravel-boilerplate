<?php

namespace App\Packages\Exam\Model;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Illuminate\Support\Str;
use Doctrine\ORM\Mapping\ManyToOne;

/**
 * @ORM\Entity
 * @ORM\Table(name="questions")
 */
class Question
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
     * @ManyToOne(targetEntity="Subject")
     */
    private Subject $subject;

    /**
     * @ORM\OneToMany(targetEntity="Alternative", mappedBy="question_id", cascade={"persist", "remove"})
     * @var Collection|Alternative[]
     */
    protected Collection|array $alternatives;


    public function __construct(string $description, Subject $subject)
    {
        $this->id = Str::uuid()->toString();
        $this->description = $description;
        $this->subject = $subject;
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
     * @return Subject
     */
    public function getSubject(): Subject
    {
        return $this->subject;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function setSubject(Subject $subject): void
    {
        $this->subject = $subject;
    }

}