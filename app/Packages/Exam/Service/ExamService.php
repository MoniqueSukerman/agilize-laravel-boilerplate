<?php

namespace App\Packages\Exam\Service;

use App\Packages\Exam\Model\Exam;
use App\Packages\Exam\Repository\AlternativeRepository;
use App\Packages\Exam\Repository\ExamRepository;
use App\Packages\Exam\Repository\SubjectRepository;
use App\Packages\Student\Repository\StudentRepository;

class ExamService
{
    public function __construct(
        protected ExamRepository $examRepository,
        protected SubjectRepository $subjectRepository,
        protected  StudentRepository $studentRepository
    )
    {
    }

    public function enrollExam(string $subjectId, string $studentId, int $numberOfQuestions): Exam
    {
            $subject = $this->subjectRepository->subjectById($subjectId);
            $student = $this->studentRepository->studentById($studentId);

            $exam = new Exam($subject, $student, $numberOfQuestions);
            $this->examRepository->addExam($exam);
            return $exam;
    }

    public function listExams() : array
    {
            return $this->examRepository->listExams();
    }

    public function examById(string $id) : Exam
    {
        return $this->examRepository->examById($id);
    }

    public function removeExam( string $id) : void
    {
        $exam = $this->examById($id);

        $this->examRepository->removeExam($exam);
    }
}