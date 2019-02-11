<?php

namespace App\Business;

use App\Entity\User;
use Doctrine\Common\Persistence\ObjectRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMException;


class ManagedAbstract implements ManagedInterface
{
    protected $entity;
    /**
     * @var ObjectRepository
     */
    protected $objectRepository;
    /**
     * @var EntityManager
     */
    protected $entityManager;

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

    public function getAll() {
        $records = $this->objectRepository->findall();
        $result = [];
        foreach ($records as $record) {
            $result[] = $this->toArray($record);
        }
        return $result;
    }

    /**
     * @param $id
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function deleteRecord($id) {
        $record = $this->objectRepository->find($id);

        if (!$record) {
            throw new ORMException('Non existing Record');
        }

        $this->entityManager->remove($record);

        $this->entityManager->flush();
    }

    /**
     * @param $id
     * @return object|null
     */
    public function show($id)
    {
        return $this->toArray($this->find($id));
    }

    public function find($id)
    {
        return $this->objectRepository->find($id);
    }

    public function findBy($filter)
    {
        return $this->objectRepository->findBy($filter);
    }

    public function save($data)
    {
        throw new \Exception('Must be implemented in concrete classes');
    }
}