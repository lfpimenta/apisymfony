<?php

namespace App\Business;

use App\Entity\Groups;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMException;
use Doctrine\ORM\ORMInvalidArgumentException;

class ManagedGroup extends ManagedAbstract
{

    public function __construct(EntityManager $entityManager, $repositoryObject)
    {
        $this->entityManager = $entityManager;
        $this->entity = new Groups();
        $this->objectRepository = $repositoryObject;
    }

    /**
     * @param $data
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function save($data) {
        $this->entity->setName($data['name']);

        $this->entityManager->persist($this->entity);
        $this->entityManager->flush();
    }

    /**
     * @param $record
     * @return array
     */
    protected function toArray($record): array
    {
        if ($record === null) {
            return [];
        }

        if(is_array($record)) {
            $result = [];
            foreach ($record as $rec) {
                $result[] = [
                    'id' => $rec->getId(),
                    'name' => $rec->getName(),
                ];
            }

            return $result;
        }

        return [
            'id' => $record->getId(),
            'name' => $record->getName(),
        ];
    }
}