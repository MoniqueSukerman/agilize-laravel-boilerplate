<?php

namespace App\Packages\Exam\Facade;

use App\Packages\Exam\Model\Question;
use App\Packages\Exam\Service\QuestionService;
use App\Packages\Exam\Model\Subject;

class QuestionFacade
{
    public function __construct(
        protected QuestionService $questionService
    )
    {
    }

    public function enrollQuestion(string $description, string $subjectId) : Question
    {
        return $this->questionService->enrollQuestion($description, $subjectId);
    }

    public function listQuestions(): array
    {
        return $this->questionService->listQuestions();
    }

    public function questionById(string $id): Question
    {
        return $this->questionService->questionById($id);
    }

    public function updateQuestion(string|null $description, string $id, Subject|null $subject): Question
    {
        return $this->questionService->updateQuestion($description, $id, $subject);
    }

    public function removeQuestion(string $id) : void
    {
        $this->questionService->removeQuestion($id);
    }
}