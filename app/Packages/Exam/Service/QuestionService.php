<?php

namespace App\Packages\Exam\Service;

use App\Packages\Exam\Model\Question;
use App\Packages\Exam\Model\Subject;
use App\Packages\Exam\Repository\QuestionRepository;
use App\Packages\Exam\Repository\SubjectRepository;
use Exception;

class QuestionService
{
    public function __construct(
        protected QuestionRepository $questionRepository,
        protected SubjectRepository $subjectRepository
    )
    {
    }

    /**
     * @throws Exception
     */
    public function enrollQuestion(string $description, string $subjectId): Question
    {

        if(strlen($description) > 150){
            throw new Exception('150 characters is description the limit!');
        }

        $question = new Question($description, $this->subjectRepository->subjectById($subjectId));
        $this->questionRepository->addQuestion($question);
        return $question;
    }

    public function listQuestions() : array
    {
            return $this->questionRepository->listQuestions();
    }

    public function questionById(string $id) : Question
    {
        return $this->questionRepository->questionById($id);
    }

    /**
     * @throws Exception
     */
    public function updateQuestion(string|null $description, string $id, Subject|null $subject) : Question
    {
        if(strlen($description) > 150){
            throw new Exception('150 characters is description the limit!');
        }

        $question = $this->questionById($id);

        if ($subject){
            $question->setSubject($subject);
        }

        $question->setDescription($description);



        $this->questionRepository->addQuestion($question);
        return $question;
    }

    public function removeQuestion( string $id) : void
    {
        $question = $this->questionById($id);

        $this->questionRepository->removeQuestion($question);
    }
}