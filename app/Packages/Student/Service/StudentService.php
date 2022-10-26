<?php

namespace App\Packages\Student\Service;

use App\Packages\Student\Model\Student;
use App\Packages\Student\Repository\StudentRepository;
use Exception;
use LaravelDoctrine\ORM\Facades\EntityManager;

class StudentService
{
    public function __construct(
        protected StudentRepository $studentRepository
    )
    {
    }

    /**
     * @throws Exception
     */
    public function enrollStudent(string $name): Student
    {

        if(strlen($name) > 150){
            throw new Exception('150 characters is the name limit!');
        }

        if(strlen($name) <= 3){
            throw new Exception('Name need to have more than 3 characters');
        }

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

    /**
     * @throws Exception
     */
    public function updateStudent(string $name, string $id) : Student
    {
        if(strlen($name) > 150){
            throw new Exception('150 characters is the name limit!');
        }

        if(strlen($name) < 3){
            throw new Exception('Name need to have more than 3 characters');
        }

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