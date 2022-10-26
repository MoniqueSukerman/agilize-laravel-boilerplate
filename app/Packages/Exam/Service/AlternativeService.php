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

    public function isCorrectList(string $questionId) : array
    {
        $question = $this->questionRepository->questionById($questionId);

        $alternatives = $this->alternativeRepository->alternativesByQuestion($question);

        $isCorrectList = Collect();

        /**@var Alternative $alternative */
        foreach ($alternatives as $alternative){
            $isCorrect = $alternative->getCorrect();
            $isCorrectList->add($isCorrect);
        }

        return $isCorrectList->toArray();

    }

    public function oneAndOnlyCorrectAlternative($correct, $questionId) : bool
    {
        $isCorrectList = $this->isCorrectList($questionId);

        $correctAlternativeRegistered = in_array(true, $isCorrectList);

        if($correctAlternativeRegistered and $correct){
            return false;
        }

        if(count($isCorrectList) === 3 and !$correctAlternativeRegistered and !$correct){
            return false;
        }

        return true;
    }



    /**
     * @throws Exception
     */
    public function enrollAlternative(string $description, bool $correct, string $questionId): Alternative|Exception
    {
        $underTheLimit = $this->alternativesUnderTheLimit($questionId);

        $onlyOneCorrectAlternative = $this->oneAndOnlyCorrectAlternative($correct, $questionId);

        if(strlen($description) > 150){
            throw new Exception('150 characters is description the limit!');
        }

        if(strlen($description) < 10){
            throw new Exception('Description need to have more than 10 characters');
        }

        if(!$underTheLimit){
            throw new Exception('Each question has only 4 alternatives!');
        }

        if (!$onlyOneCorrectAlternative){
            throw new Exception('One and only one correct answer allowed');
        }

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

    /**
     * @throws Exception
     */
    public function updateAlternative(string|null $description, bool|null $correct, string $id) : Alternative
    {
        if(strlen($description) > 150){
            throw new Exception('150 characters is description the limit!');
        }

        if(strlen($description) < 10){
            throw new Exception('Description need to have more than 10 characters');
        }

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