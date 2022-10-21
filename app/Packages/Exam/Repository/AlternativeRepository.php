<?php

namespace App\Packages\Exam\Repository;

use App\Packages\Base\AbstractRepository;
use App\Packages\Exam\Model\Alternative;
use LaravelDoctrine\ORM\Facades\EntityManager;

class AlternativeRepository extends AbstractRepository
{
    public string $entityName = Alternative::class;

    public function addAlternative(Alternative $alternative)
    {
        EntityManager::persist($alternative);
        EntityManager::flush();
    }

    public function listAlternatives() : array
    {
        return $this->findAll();
    }

    public function alternativeById(string $id) : Alternative
    {
        return $this->find($id);
    }

    public function removeAlternative(Alternative $alternative)
    {
        EntityManager::remove($alternative);
        EntityManager::flush();
    }

}