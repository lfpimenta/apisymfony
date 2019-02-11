<?php

namespace App\Controller;

use App\Business\ManagedGroup;
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
    /**
     * @Route("api/groups", methods={"GET","POST"}, name="groups_list_store")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
	public function listStore(Request $request) {
        if($request->isMethod('GET')) {
            return $this->json(
                $this->getManagedGroup()->getAll(),
                Response::HTTP_OK
            );
        }

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
     * @Route("api/groups/{id}", methods={"GET","DELETE"}, name="groups_delete_show")
     * @param $id
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\JsonResponse|Response
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
	public function displayDelete($id, Request $request) {
        if($request->isMethod('DELETE')) {
            try {
                $this->getManagedGroup()->deleteRecord($id);
            } catch (OptimisticLockException $e) {
                return new Response('', Response::HTTP_PRECONDITION_FAILED);
            } catch (ORMException $e) {
                return new Response('', Response::HTTP_PRECONDITION_FAILED);
            }

            return new Response('', Response::HTTP_NO_CONTENT);
        }

        $user = $this->getManagedGroup()->show($id);
        if ($user) {
            return $this->json($user, Response::HTTP_OK);
        }

        return new Response('', Response::HTTP_NOT_FOUND);
	}

    /**
     * @Route("api/groups/{groupId}/users", methods={"GET","POST"}, name="groups_users_list_store")
     * @param $groupId
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
	public function listAssociateUsers($groupId, Request $request) {
        if($request->isMethod('GET')) {
            $record = $this->getManagedUserGroup()->findBy(['groupid' => $groupId]);

            return $this->json(
                $this->getManagedUserGroup()->toArray($record),
                Response::HTTP_OK
            );
        }

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
     * @Route("api/groups/{groupId}/users/{userId}", methods={"DELETE"}, name="groups_users_unassociate")
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

    protected function getManagedGroup()
    {
        return new ManagedGroup(
            $this->getDoctrine()->getManager(),
            $this->getDoctrine()->getRepository(Groups::class)
        );
    }

    protected function getManagedUserGroup()
    {
        return new ManagedUserGroup(
            $this->getDoctrine()->getManager(),
            $this->getDoctrine()->getRepository(UserGroup::class),
            $this->getDoctrine()
        );
    }
}