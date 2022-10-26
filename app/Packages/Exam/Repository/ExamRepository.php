<?php

namespace App\Packages\Exam\Repository;

use App\Packages\Base\AbstractRepository;
use App\Packages\Exam\Model\Exam;
use LaravelDoctrine\ORM\Facades\EntityManager;

class ExamRepository extends AbstractRepository
{
    public string $entityName = Exam::class;

    public function addExam(Exam $exam)
    {
        EntityManager::persist($exam);
        EntityManager::flush();
    }

    public function listExams() : array
    {
        return $this->findAll();
    }

    public function examById(string $id) : Exam
    {
        return $this->find($id);
    }

    public function removeExam(Exam $exam)
    {
        EntityManager::remove($exam);
        EntityManager::flush();
    }

}