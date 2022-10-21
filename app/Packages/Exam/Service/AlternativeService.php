<?php

namespace App\Packages\Exam\Service;

use App\Packages\Exam\Model\Alternative;
use App\Packages\Exam\Model\Question;
use App\Packages\Exam\Repository\AlternativeRepository;
use App\Packages\Exam\Repository\QuestionRepository;

class AlternativeService
{
    public function __construct(
        protected AlternativeRepository $alternativeRepository,
        protected  QuestionRepository $questionRepository
    )
    {
    }

    public function enrollAlternative(string $description, bool $correct, string $questionId): Alternative
    {
            $alternative = new Alternative($description, $correct, $this->questionRepository->questionById($questionId));
            $this->alternativeRepository->addAlternative($alternative);
            return $alternative;
    }

    public function listAlternatives() : array
    {
            return $this->alternativeRepository->listAlternatives();
    }

    public function alternativeById(string $id) : Alternative
    {
        return $this->alternativeRepository->alternativeById($id);
    }

    public function updateAlternative(string|null $description, bool|null $correct, string $id) : Alternative
    {
        $alternative = $this->alternativeById($id);

        $alternative->setDescription($description);
        $alternative->setCorrect($correct);



        $this->alternativeRepository->addAlternative($alternative);
        return $alternative;
    }

    public function removeAlternative( string $id) : void
    {
        $alternative = $this->alternativeById($id);

        $this->alternativeRepository->removeAlternative($alternative);
    }
}