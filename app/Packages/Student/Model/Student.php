<?php

namespace App\Packages\Student\Model;

use Doctrine\ORM\Mapping as ORM;
use Illuminate\Support\Str;
use LaravelDoctrine\ORM\Serializers\JsonSerializer;

/**
 * @ORM\Entity
 * @ORM\Table(name="students")
 */
class Student
{
    /**
     * @ORM\Id
     * @ORM\Column(type="uuid", unique=true)
     */
    private string $id;

    /**
     * @ORM\Column(type="string")
     */
    private string $name;


    public function __construct(string $name)
    {
        $this->id = Str::uuid()->toString();
        $this->name = $name;
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
    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

}