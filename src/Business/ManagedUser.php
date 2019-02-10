<?php

namespace App\Business;


use App\Entity\User;
use Doctrine\Common\Persistence\ObjectRepository;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Serializer\Serializer;

class ManagedUser extends ManagedAbstract
{
    public function __construct(EntityManager $entityManager, $repositoryObject)
    {
        $this->entityManager = $entityManager;
        $this->entity = new User();
        $this->objectRepository = $repositoryObject;
    }

    public function save($data) {
        $this->entity->setName($data['name']);
        $this->entity->setAdmin($data['admin']);
        $this->entity->setPassword($data['password']);

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
            'admin' => $user->getAdmin(),
        ];
    }


}