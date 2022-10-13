<?php

namespace App\Packages\Student\Facade;

use App\Packages\Student\Model\Student;
use App\Packages\Student\Service\StudentService;

class StudentFacade
{
    public function __construct(
        protected StudentService $studentService
    )
    {
    }

    public function enrollStudent(string $name): Student
    {
        return $this->studentService->enrollStudent($name);
    }

    public function listStudents(): array
    {
        return $this->studentService->listStudents();
    }

    public function studentById($id): Student
    {
        return $this->studentService->studentById($id);
    }

    public function studentByName($name): array
    {
        return $this->studentService->studentByName($name);
    }

    public function updateStudent(string $name, string $id): Student
    {
        return $this->studentService->updateStudent($name, $id);
    }

    public function removeStudent(string $id)
    {
        $this->studentService->removeStudent($id);
    }
}