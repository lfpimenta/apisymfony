<?php

namespace App\Business;


use App\Entity\User;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\Common\Persistence\ObjectRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;

class ManagedUser extends ManagedAbstract
{
    protected $mngGroupUser;

    public function __construct(ManagerRegistry $managerRegistry)
    {
        $this->entityManager = $managerRegistry->getManager();
        $this->entity = new User();
        $this->objectRepository = $managerRegistry->getRepository(User::class);

        $this->mngGroupUser = new ManagedUserGroup($managerRegistry);
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
     * @param $id
     * @throws ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function deleteRecord($id) {
        $record = $this->objectRepository->find($id);

        if (!$record) {
            throw new ORMException('Non existing Record');
        }

        $groupUserRecords = $this->mngGroupUser->findBy(['userid' => $id]);
        if ($groupUserRecords) {
            throw new ORMException('User is present in group');
        }

        $this->entityManager->remove($record);

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