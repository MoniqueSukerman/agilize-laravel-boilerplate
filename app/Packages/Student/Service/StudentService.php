<?php

namespace App\Packages\Student\Service;

use App\Packages\Student\Model\Student;
use App\Packages\Student\Repository\StudentRepository;
use LaravelDoctrine\ORM\Facades\EntityManager;

class StudentService
{
    public function __construct(
        protected StudentRepository $studentRepository
    )
    {
    }

    public function enrollStudent(string $name): Student
    {
            $student = new Student($name);
            $this->studentRepository->addStudent($student);
            return $student;
    }

    public function listStudents() : array
    {
            return $this->studentRepository->listStudents();
    }

    public function studentById(string $id) : Student
    {
        return $this->studentRepository->studentById($id);
    }

    public function updateStudent(string $name, string $id) : Student
    {
        $student = $this->studentById($id);

        $student->setName($name);

        $this->studentRepository->addStudent($student);
        return $this->studentById($id);
    }

    public function removeStudent( string $id) : void
    {
        $student = $this->studentById($id);

        $this->studentRepository->removeStudent($student);
    }
}