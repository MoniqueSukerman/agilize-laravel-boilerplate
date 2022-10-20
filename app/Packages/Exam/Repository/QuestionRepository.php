<?php

namespace App\Packages\Exam\Repository;

use App\Packages\Base\AbstractRepository;
use App\Packages\Exam\Model\Question;
use LaravelDoctrine\ORM\Facades\EntityManager;

class QuestionRepository extends AbstractRepository
{
    public string $entityName = Question::class;

    public function addQuestion(Question $question)
    {
        EntityManager::persist($question);
        EntityManager::flush();
    }

    public function listQuestions() : array
    {
        return $this->findAll();
    }

    public function questionById(string $id) : Question
    {
        return $this->find($id);
    }

    public function removeQuestion(Question $question)
    {
        EntityManager::remove($question);
        EntityManager::flush();
    }

}