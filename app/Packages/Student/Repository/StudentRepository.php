<?php

namespace App\Packages\Student\Repository;

use App\Packages\Base\AbstractRepository;
use App\Packages\Student\Model\Student;
use LaravelDoctrine\ORM\Facades\EntityManager;

class StudentRepository extends AbstractRepository
{
    public string $entityName = Student::class;

    public function addStudent(Student $student)
    {
        EntityManager::persist($student);
        EntityManager::flush();
    }

    public function listStudents() : array
    {
        return $this->findAll();
    }

    public function studentById($id) : Student
    {
        return $this->find($id);
    }

    public function studentByName($name) : array
    {
        return $this->findBy(['name'=> $name]);
    }

    public function removeStudent(Student $student)
    {
        EntityManager::remove($student);
        EntityManager::flush();
    }

}