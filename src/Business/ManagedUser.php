<?php

namespace App\Business;


use App\Entity\User;
use Doctrine\Common\Persistence\ObjectRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMException;
use Doctrine\ORM\ORMInvalidArgumentException;
use Symfony\Component\Serializer\Serializer;

class ManagedUser
{
    protected $entity;
    /**
     * @var ObjectRepository
     */
    protected $objectRepository;
    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * @param ObjectRepository $objectRepository
     */
    public function setObjectRepository(ObjectRepository $objectRepository): void
    {
        $this->objectRepository = $objectRepository;
    }

    /**
     * @param $entity
     */
    public function setEntity($entity): void
    {
        $this->entity = $entity;
    }

    public function __construct(EntityManager $entityManager, $repositoryObject)
    {
        $this->entityManager = $entityManager;
        $this->entity = new User();
        $this->objectRepository = $repositoryObject;
    }

    public function getAll() {
        $users = $this->objectRepository->findall();
        $result = [];
        foreach ($users as $user) {
            $result[] = $this->toArray($user);
        }
        return $result;
    }

    /**
     * @param $id
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function deleteUser($id) {
        $user = $this->objectRepository->find($id);

        if (!$user) {
            throw new ORMException('Non existing user');
        }

        $this->entityManager->remove($user);

        $this->entityManager->flush();
    }

    /**
     * @param $data
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function save($data) {
        $this->entity->setName($data['name']);
        $this->entity->setAdmin($data['admin']);
        $this->entity->setPassword($data['password']);

        $this->entityManager->persist($this->entity);
        $this->entityManager->flush();
    }

    /**
     * @param $id
     * @return object|null
     */
    public function show($id)
    {
        $user = $this->objectRepository->find($id);

        return $this->toArray($user);
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