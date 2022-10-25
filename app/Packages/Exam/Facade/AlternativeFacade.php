<?php

namespace App\Packages\Exam\Facade;

use App\Packages\Exam\Model\Alternative;
use App\Packages\Exam\Service\AlternativeService;
use App\Packages\Exam\Model\Question;
use Exception;

class AlternativeFacade
{
    public function __construct(
        protected AlternativeService $alternativeService
    )
    {
    }


    /**
     * @throws Exception
     */
    public function enrollAlternative(string $description, bool $correct, string $questionId) : Alternative|Exception
    {
        return $this->alternativeService->enrollAlternative($description,$correct, $questionId);
    }

    public function listAlternatives(): array
    {
        return $this->alternativeService->listAlternatives();
    }

    public function alternativeById(string $id): Alternative
    {
        return $this->alternativeService->alternativeById($id);
    }

    public function updateAlternative(string|null $description, bool|null $correct, string $id): Alternative
    {
        return $this->alternativeService->updateAlternative($description, $correct, $id);
    }

    public function removeAlternative(string $id) : void
    {
        $this->alternativeService->removeAlternative($id);
    }
}