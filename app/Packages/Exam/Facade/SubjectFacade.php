<?php

namespace App\Packages\Exam\Facade;

use App\Packages\Exam\Model\Subject;
use App\Packages\Exam\Service\SubjectService;

class SubjectFacade
{
    public function __construct(
        protected SubjectService $subjectService
    )
    {
    }

    public function enrollSubject(string $description): Subject
    {
        return $this->subjectService->enrollSubject($description);
    }

    public function listSubjects(): array
    {
        return $this->subjectService->listSubjects();
    }

    public function subjectById($id): Subject
    {
        return $this->subjectService->subjectById($id);
    }

    public function updateSubject(string $description, string $id): Subject
    {
        return $this->subjectService->updateSubject($description, $id);
    }

    public function removeSubject(string $id) : void
    {
        $this->subjectService->removeSubject($id);
    }
}