<?php

namespace App\Packages\Exam\Service;

use App\Packages\Exam\Model\Subject;
use App\Packages\Exam\Repository\SubjectRepository;
use Exception;

class SubjectService
{
    public function __construct(
        protected SubjectRepository $subjectRepository
    )
    {
    }

    /**
     * @throws Exception
     */
    public function enrollSubject(string $description): Subject
    {
        if(strlen($description) > 150){
            throw new Exception('150 characters is description the limit!');
        }

        $subject = new Subject($description);
        $this->subjectRepository->addSubject($subject);
        return $subject;
    }

    public function listSubjects() : array
    {
            return $this->subjectRepository->listSubjects();
    }

    public function subjectById(string $id) : Subject
    {
        return $this->subjectRepository->subjectById($id);
    }

    /**
     * @throws Exception
     */
    public function updateSubject(string $description, string $id) : Subject
    {

        if(strlen($description) > 150){
            throw new Exception('150 characters is the description limit!');
        }

        $subject = $this->subjectById($id);

        $subject->setDescription($description);

        $this->subjectRepository->addSubject($subject);
        return $this->subjectById($id);
    }

    public function removeSubject( string $id) : void
    {
        $subject = $this->subjectById($id);

        $this->subjectRepository->removeSubject($subject);
    }
}