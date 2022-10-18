<?php

namespace App\Packages\Exam\Repository;

use App\Packages\Base\AbstractRepository;
use App\Packages\Exam\Model\Subject;
use LaravelDoctrine\ORM\Facades\EntityManager;

class SubjectRepository extends AbstractRepository
{
    public string $entityName = Subject::class;

    public function addSubject(Subject $subject)
    {
        EntityManager::persist($subject);
        EntityManager::flush();
    }

    public function listSubjects() : array
    {
        return $this->findAll();
    }

    public function subjectById($id) : Subject
    {
        return $this->find($id);
    }

    public function removeSubject(Subject $subject)
    {
        EntityManager::remove($subject);
        EntityManager::flush();
    }

}