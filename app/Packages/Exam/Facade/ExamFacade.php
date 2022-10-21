<?php

namespace App\Packages\Exam\Facade;

use App\Packages\Exam\Model\Exam;
use App\Packages\Exam\Service\ExamService;

class ExamFacade
{
    public function __construct(
        protected ExamService $examService
    )
    {
    }

    public function enrollExam(string $subjectId, string $studentId, int $numberOfQuestions) : Exam
    {
        return $this->examService->enrollExam($subjectId,$studentId, $numberOfQuestions);
    }

    public function listExams(): array
    {
        return $this->examService->listExams();
    }

    public function examById(string $id): Exam
    {
        return $this->examService->examById($id);
    }

    public function submitExam(Exam $exam) : Exam
    {
        return $this->examService->submitExam($exam);

    }

    public function removeExam(string $id) : void
    {
        $this->examService->removeExam($id);
    }
}