<?php

namespace App\Packages\Exam\Service;

use App\Packages\Exam\Model\Alternative;
use App\Packages\Exam\Model\AlternativeExam;
use App\Packages\Exam\Model\Exam;
use App\Packages\Exam\Model\Question;
use App\Packages\Exam\Model\QuestionExam;
use App\Packages\Exam\Repository\AlternativeExamRepository;
use App\Packages\Exam\Repository\AlternativeRepository;
use App\Packages\Exam\Repository\ExamRepository;
use App\Packages\Exam\Repository\QuestionExamRepository;
use App\Packages\Exam\Repository\QuestionRepository;
use App\Packages\Exam\Repository\SubjectRepository;
use App\Packages\Student\Repository\StudentRepository;
use Illuminate\Support\Collection;

class ExamService
{
    public function __construct(
        protected ExamRepository $examRepository,
        protected SubjectRepository $subjectRepository,
        protected StudentRepository $studentRepository,
        protected QuestionRepository $questionRepository,
        protected AlternativeRepository $alternativeRepository,
        protected QuestionExamRepository $questionExamRepository,
        protected AlternativeExamRepository $alternativeExamRepository
    )
    {
    }

    public function questionToQuestionExam(Question $question, Exam $exam) : QuestionExam
    {
        $description = $question->getDescription();

        return new QuestionExam($description, $exam);
    }

    public function alternativeToAlternativeExam(Alternative $alternative, QuestionExam $question) : AlternativeExam
    {
        $description = $alternative->getDescription();
        $correct = $alternative->getCorrect();

        return new AlternativeExam($description, $correct, $question);
    }

    public function addAlternatives(array $alternatives, QuestionExam $question) : void
    {
        foreach ($alternatives as $alternative) {
            $alternativeExam = $this->alternativeToAlternativeExam($alternative, $question);
            $question->addAlternative($alternativeExam);
        }
    }

    public function addQuestions(array $questions, Exam $exam) : void
    {
        foreach ($questions as $question) {
            $questionExam = $this->questionToQuestionExam($question, $exam);
            $exam->addQuestion($questionExam);
            $alternatives = $this->alternativeRepository->alternativesByQuestion($question);

            $this->addAlternatives($alternatives, $questionExam);
        }
    }

    public function enrollExam(string $subjectId, string $studentId, int $numberOfQuestions): Exam
    {
        $subject = $this->subjectRepository->subjectById($subjectId);
        $student = $this->studentRepository->studentById($studentId);

        $questions = $this->questionRepository->questionBySubject($numberOfQuestions, $subject);

        $exam = new Exam($subject, $student, $numberOfQuestions);

        $this->addQuestions($questions, $exam);

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

    public function setChosenAlternative($answers) : void
    {
        foreach ($answers as $answer){
            $chosenAlternativeId = $answer['alternative_id'];
            $chosenAlternative = $this->alternativeExamRepository->alternativeById($chosenAlternativeId);
            $chosenAlternative->setChosen(true);
            $question = $chosenAlternative->getQuestion();
            $correctAlternativeId = $this->alternativeExamRepository->alternativeCorrectId($question)->getId();

            if($chosenAlternativeId === $correctAlternativeId){
                $question->setRightAnswer(true);
            } else {
                $question->setRightAnswer(false);
            }
        }
    }

    public function setGrade(Exam $exam) : void
    {
        $totalRightAnswers = count($this->questionExamRepository->rightAnswers($exam));
        $totalQuestions = $exam->getNumberOfQuestions();

        $grade = ($totalRightAnswers / $totalQuestions) * 10;

        $exam->setGrade($grade);

        $this->examRepository->addExam($exam);
    }

    public function submitExam(Exam $exam, $answers) : Exam
    {
        $this->setChosenAlternative($answers);

        $exam->setSubmittedAt();

        $createdAt = $exam->getCreatedAt();
        $submittedAt = $exam->getSubmittedAt();

        $interval = new \DateInterval('P3YT1H');

        $limitTime = $createdAt->add($interval);

        if ($submittedAt <= $limitTime) {
            $exam->setStatus('concluded');
            $this->examRepository->addExam($exam);
        }

        $this->setGrade($exam);

        return $exam;

    }

    public function removeExam( string $id) : void
    {
        $exam = $this->examById($id);

        $this->examRepository->removeExam($exam);
    }
}