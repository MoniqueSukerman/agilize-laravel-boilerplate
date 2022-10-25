<?php

namespace App\Packages\Exam\Repository;

use App\Packages\Base\AbstractRepository;
use App\Packages\Exam\Model\AlternativeExam;
use App\Packages\Exam\Model\QuestionExam;
use LaravelDoctrine\ORM\Facades\EntityManager;
use App\Packages\Exam\Model\Exam;

//use App\Packages\Exam\Model\Subject;
//use LaravelDoctrine\ORM\Facades\EntityManager;

class QuestionExamRepository extends AbstractRepository
{
    public string $entityName = QuestionExam::class;


    public function questionById(string $id) : QuestionExam
    {
        return $this->find($id);
    }

    public function rightAnswers(Exam $exam) : array
    {
        $queryBuilder = EntityManager::createQueryBuilder();

        $query = $queryBuilder
            ->select('q')
            ->from(QuestionExam::class,'q')
            ->where('q.exam = :exam')
            ->andWhere('q.rightAnswer = true')
            ->setParameter('exam', $exam)
            ->getQuery();

//        var_dump($query->getResult());

        return $query->getResult();
    }

}