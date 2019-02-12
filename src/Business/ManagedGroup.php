<?php

namespace App\Business;

use App\Entity\Groups;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMException;
use Doctrine\ORM\ORMInvalidArgumentException;

class ManagedGroup extends ManagedAbstract
{

    protected  $mngGroupUser;

    public function __construct(ManagerRegistry $managerRegistry)
    {
        $this->entityManager = $managerRegistry->getManager();
        $this->entity = new Groups();
        $this->objectRepository = $managerRegistry->getRepository(Groups::class);

        $this->mngGroupUser = new ManagedUserGroup($managerRegistry, $this);
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
    * @param $id
    * @throws ORMException
    * @throws \Doctrine\ORM\OptimisticLockException
    */
    public function deleteRecord($id) {
        $record = $this->objectRepository->find($id);

        if (!$record) {
            throw new ORMException('Non existing Record');
        }

        $groupUserRecords = $this->mngGroupUser->findBy(['groupid' => $id]);
        if ($groupUserRecords) {
            throw new ORMException('Group has users inside');
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