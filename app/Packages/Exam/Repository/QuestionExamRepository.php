<?php

namespace App\Packages\Exam\Repository;

use App\Packages\Base\AbstractRepository;
use App\Packages\Exam\Model\QuestionExam;
use LaravelDoctrine\ORM\Facades\EntityManager;
use App\Packages\Exam\Model\Exam;


class QuestionExamRepository extends AbstractRepository
{
    public string $entityName = QuestionExam::class;

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

        return $query->getResult();
    }

}