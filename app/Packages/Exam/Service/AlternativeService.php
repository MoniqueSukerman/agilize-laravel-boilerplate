<?php

namespace App\Packages\Exam\Service;

use App\Packages\Exam\Model\Alternative;
use App\Packages\Exam\Model\Question;
use App\Packages\Exam\Model\QuestionExam;
use App\Packages\Exam\Repository\AlternativeRepository;
use App\Packages\Exam\Repository\QuestionRepository;
use Exception;

class AlternativeService
{
    public function __construct(
        protected AlternativeRepository $alternativeRepository,
        protected  QuestionRepository $questionRepository
    )
    {
    }

    public function alternativesUnderTheLimit(string $questionId) : bool
    {
        $question = $this->questionRepository->questionById($questionId);

        $alreadyExistentAlternatives = $this->alternativeRepository->alternativesByQuestion($question);

        $alreadyExistentAlternativesQuantity = count($alreadyExistentAlternatives);

        $limit = 4;

        return $alreadyExistentAlternativesQuantity < $limit;
    }

    public function convertToAlternative ($alternative) : Alternative
    {
        return $alternative;
    }

    public function isCorrectList(string $questionId) : array
    {
        $question = $this->questionRepository->questionById($questionId);

        $alternatives = $this->alternativeRepository->alternativesByQuestion($question);

        $isCorrectList = Collect();

        foreach ($alternatives as $alternative){
            $alternativeEntity = $this->convertToAlternative($alternative);
            $isCorrect = $alternativeEntity->getCorrect();
            $isCorrectList->add($isCorrect);
        }

        return $isCorrectList->toArray();

    }

    public function onlyOneCorrectAlternative($correct, $questionId) : bool
    {
        $isCorrectList = $this->isCorrectList($questionId);

        $firstRegister = count($isCorrectList) === 0;

        $correctAlternativeRegistered = in_array(true, $isCorrectList);

        if($firstRegister){
            return true;
        } else {
            return $correctAlternativeRegistered !== $correct;
        }

    }



    /**
     * @throws Exception
     */
    public function enrollAlternative(string $description, bool $correct, string $questionId): Alternative|Exception
    {
        $underTheLimit = $this->alternativesUnderTheLimit($questionId);

        $onlyOneCorrectAlternative = $this->onlyOneCorrectAlternative($correct, $questionId);

        if($underTheLimit and $onlyOneCorrectAlternative){
            $alternative = new Alternative($description, $correct, $this->questionRepository->questionById($questionId));
            $this->alternativeRepository->addAlternative($alternative);
            return $alternative;

        }
        return new Exception('Já existem 4 alternativas cadastradas para essa questão');
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