<?php

namespace App\Packages\Exam\Repository;

use App\Packages\Base\AbstractRepository;
use App\Packages\Exam\Model\Question;
use App\Packages\Exam\Model\Subject;
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

    public function questionBySubject(int $quantity, Subject $subject) : array
    {
        $queryBuilder = EntityManager::createQueryBuilder();

//        $sql = 'SELECT id from table ORDER BY RAND() LIMIT 100'



        $query = $queryBuilder
            ->select('q')
            ->from(Question::class,'q')
            ->where('q.subject = :subject')
            ->setParameter('subject', $subject)
//            ->addSelect('RANDOM() as HIDDEN RANDOM')
//            ->orderBy('q','RANDOM()')
            ->setMaxResults($quantity)
            ->getQuery();

//        $query = EntityManager::createQuery($dql);
//        $questions = $query->getResult();

//        var_dump($query->getDQL());

        return $query->getResult();
    }

    public function removeQuestion(Question $question)
    {
        EntityManager::remove($question);
        EntityManager::flush();
    }

}