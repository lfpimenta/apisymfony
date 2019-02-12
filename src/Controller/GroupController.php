<?php

namespace App\Controller;

use App\Business\ManagedGroup;
use App\Business\ManagedUser;
use App\Business\ManagedUserGroup;
use App\Entity\Groups;
use App\Entity\UserGroup;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Exception;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class GroupController extends AbstractController {

    public function list()
    {
        return $this->json(
                $this->getManagedGroup()->getAll(),
                Response::HTTP_OK
            );
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
	public function store(Request $request) {
        // TODO: validate input, and predict if source is from form
        $body = $request->getContent();
        $data = json_decode($body, true);

        $validData = true;

        if (!$validData) {
            return $this->json(
                '',
                Response::HTTP_PRECONDITION_FAILED
            );
        }


        try {
            $this->getManagedGroup()->save($data);
        } catch (Exception $e) {
            return $this->json(
                'Problem saving data',
                Response::HTTP_UNPROCESSABLE_ENTITY
            );
        }

        $response = $this->json(
            '',
            Response::HTTP_CREATED
        );

        return $response;
	}

    /**
     * @param $id
     * @param Request $request
     * @return Response
     */
    public function delete($id, Request $request)
    {
        try {
            $this->getManagedGroup()->deleteRecord($id);
        } catch (OptimisticLockException $e) {
            return new Response($e->getMessage(), Response::HTTP_PRECONDITION_FAILED);
        } catch (ORMException $e) {
            return new Response($e->getMessage(), Response::HTTP_PRECONDITION_FAILED);
        }

        return new Response('', Response::HTTP_NO_CONTENT);
    }

    /**
     * @param $id
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\JsonResponse|Response
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
	public function display($id, Request $request) {
        $record = $this->getManagedGroup()->show($id);
        if ($record) {
            return $this->json($record, Response::HTTP_OK);
        }

        return new Response('', Response::HTTP_NOT_FOUND);
	}

    /**
     * @param $groupId
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function listGroupUser($groupId, Request $request)
    {
        $record = $this->getManagedUserGroup()->findBy(['groupid' => $groupId]);

        return $this->json(
            $this->getManagedUserGroup()->toArray($record),
            Response::HTTP_OK
        );

    }

    /**
     * @param $groupId
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
	public function associateUsers($groupId, Request $request) {
        // TODO: validate input, and predict source is from form
        $body = $request->getContent();
        $data = json_decode($body, true);
        $data['groupId'] = $groupId;
        $validData = true;

        if (!$validData) {
            return $this->json(
                '',
                Response::HTTP_PRECONDITION_FAILED
            );
        }

        try {
            $this->getManagedUserGroup()->save($data);
        } catch (Exception $e) {
            return $this->json(
                'Problem saving data',
                Response::HTTP_UNPROCESSABLE_ENTITY
            );
        }

        $response = $this->json(
            '',
            Response::HTTP_CREATED
        );

        return $response;
	}

    /**
     * @param $groupId
     * @param $userId
     * @param Request $request
     * @return Response
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
	public function dessociateUsers($groupId, $userId, Request $request) {
        try {
            $this->getManagedUserGroup()->deleteRecord(['groupid' => $groupId, 'userid' => $userId]);
        } catch (OptimisticLockException $e) {
            return new Response('', Response::HTTP_PRECONDITION_FAILED);
        } catch (ORMException $e) {
            return new Response('', Response::HTTP_PRECONDITION_FAILED);
        }

        return new Response('', Response::HTTP_NO_CONTENT);
	}

    protected function getManagedUser()
    {
        return new ManagedUser($this->getDoctrine());
    }

    protected function getManagedGroup()
    {
        return new ManagedGroup($this->getDoctrine());
    }

    protected function getManagedUserGroup()
    {
        return new ManagedUserGroup($this->getDoctrine(), $this->getManagedGroup(), $this->getManagedUser());
    }
}