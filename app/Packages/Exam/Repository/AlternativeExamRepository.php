<?php

namespace App\Packages\Exam\Repository;

use App\Packages\Base\AbstractRepository;
use App\Packages\Exam\Model\AlternativeExam;
use App\Packages\Exam\Model\QuestionExam;
use LaravelDoctrine\ORM\Facades\EntityManager;

class AlternativeExamRepository extends AbstractRepository
{
    public string $entityName = AlternativeExam::class;

    public function alternativeById(string $id) : AlternativeExam
    {
        return $this->find($id);
    }

    public function correctAlternative(QuestionExam $question) : AlternativeExam
    {

        $queryBuilder = EntityManager::createQueryBuilder();

        $query = $queryBuilder
            ->select('a')
            ->from(AlternativeExam::class,'a')
            ->where('a.questionExam = :question')
            ->andWhere('a.correct = true')
            ->setParameter('question', $question)
            ->getQuery();


        $result = $query->getResult();

        $alternative = null;

        /** @var AlternativeExam $correctsAlternative */
        foreach ($result as $correctsAlternative){
           $alternative = $correctsAlternative;
        }
        return $alternative;
    }

    public function chosenAlternative(QuestionExam $question) : AlternativeExam
    {

        $queryBuilder = EntityManager::createQueryBuilder();

        $query = $queryBuilder
            ->select('a')
            ->from(AlternativeExam::class,'a')
            ->where('a.questionExam = :question')
            ->andWhere('a.chosen = true')
            ->setParameter('question', $question)
            ->getQuery();


        $result = $query->getResult();

        $alternative = null;

        /** @var AlternativeExam $chosenAlternative */
        foreach ($result as $chosenAlternative){
            $alternative = $chosenAlternative;
        }
        return $alternative;
    }

}