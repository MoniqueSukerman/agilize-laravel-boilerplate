<?php

namespace App\Packages\Exam\Model;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Illuminate\Support\Str;

/**
 * @ORM\Entity
 * @ORM\Table(name="subjects")
 */
class Subject
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

    public function __construct(string $description)
    {
        $this->id = Str::uuid()->toString();
        $this->description = $description;
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

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

}