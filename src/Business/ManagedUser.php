<?php

namespace App\Business;


use App\Entity\User;
use Doctrine\Common\Persistence\ObjectRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;

class ManagedUser extends ManagedAbstract
{
    public function __construct(EntityManager $entityManager, $repositoryObject)
    {
        $this->entityManager = $entityManager;
        $this->entity = new User();
        $this->objectRepository = $repositoryObject;
    }

    /**
     * @param $data
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function save($data) {
        $this->entity->setName($data['name']);
        $this->entity->setAdmin($data['admin']);
        $this->entity->setPassword($data['password']);

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
                    'admin' => $rec->getAdmin(),
                ];
            }

            return $result;
        }

        return [
            'id' => $record->getId(),
            'name' => $record->getName(),
            'admin' => $record->getAdmin(),
        ];
    }


}