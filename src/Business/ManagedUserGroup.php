<?php

namespace App\Business;

use App\Entity\Groups;
use App\Entity\User;
use App\Entity\UserGroup;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMException;
use Doctrine\ORM\ORMInvalidArgumentException;
use Symfony\Component\Serializer\Serializer;

class ManagedUserGroup extends ManagedAbstract
{
    protected $doctrine;
    /**
     * @var $mngUser ManagedUser
     */
    protected $mngUser;
    protected $mngGroup;

    public function __construct(EntityManager $entityManager, $repositoryObject, ManagerRegistry $doctrine = null)
    {
        $this->entityManager = $entityManager;
        $this->entity = new UserGroup();
        $this->objectRepository = $repositoryObject;
        $this->doctrine = $doctrine;
        $this->mngUser = new ManagedUser($this->entityManager, $this->doctrine->getRepository(User::class));
        $this->mngGroup = new ManagedGroup($this->entityManager, $this->doctrine->getRepository(Groups::class));
    }

    /**
     * @param $data
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function save($data) {
        $groupId = $data['groupId'];
        $group = $this->mngGroup->find($groupId);

        $userIds = $data['userIds'];

        foreach ($userIds as $userId) {
            $foundRecord = $this->findBy(['userid' => $userId, 'groupid' => $groupId]);

            if (count($foundRecord) > 0) {
                continue;
            }

            $user = $this->mngUser->find($userId);
            if(!$user) {
                continue;
            }

            $newRecord = new UserGroup();
            $newRecord->setGroupid($group);
            $newRecord->setUserid($user);

            $this->entityManager->persist($newRecord);
            $this->entityManager->flush();
        }
    }

    /**
     * @param $parameters
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function deleteRecord($parameters) {
        $record = $this->objectRepository->findOneBy($parameters);

        if (!$record) {
            throw new ORMException('Non existing Record');
        }

        $this->entityManager->remove($record);

        $this->entityManager->flush();
    }

    /**
     * @param $record UserGroup
     * @return array
     */
    public function toArray($record): array
    {
        if ($record === null) {
            return [];
        }

        $result = [];
        if(is_array($record)) {
            foreach ($record as $rec) {
                $result[] = [
                    'id' => $rec->getId(),
                    'user' => $this->mngUser->show($rec->getUserid()->getId()),
                    'group' => $this->mngGroup->show($rec->getGroupid()),
                ];
            }

            return $result;
        }

        return [
            'id' => $record->getId(),
            'user' => $this->mngUser->show($record->getUserid()->getId()),
            'group' => $this->mngGroup->show($record->getGroupid()),
        ];
    }
}