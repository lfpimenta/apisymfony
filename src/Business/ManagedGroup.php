<?php

namespace App\Business;

use App\Entity\Groups;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMException;
use Doctrine\ORM\ORMInvalidArgumentException;
use Symfony\Component\Serializer\Serializer;

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
     * @param $user
     * @return array
     */
    protected function toArray($user): array
    {
        if ($user === null) {
            return [];
        }

        return [
            'id' => $user->getId(),
            'name' => $user->getName(),
        ];
    }
}