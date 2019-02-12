<?php

namespace App\Controller;

use App\Business\ManagedUser;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Exception;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\User;

class UserController extends AbstractController {

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function list(Request $request)
    {
        return $this->json(
            $this->getManagedUser()->getAll(),
            Response::HTTP_OK
        );
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     * @throws ORMException
     * @throws OptimisticLockException
     */
	public function store(Request $request) {
        // TODO: validate input, and predict source is from form
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
            $this->getManagedUser()->save($data);
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
     * @return \Symfony\Component\HttpFoundation\JsonResponse|Response
     */
    public function delete($id, Request $request)
    {
        try {
            $this->getManagedUser()->deleteRecord($id);
        } catch (ORMException $e) {
            return new Response($e->getMessage(), Response::HTTP_PRECONDITION_FAILED);
        } catch (OptimisticLockException $e) {
            return new Response($e->getMessage(), Response::HTTP_PRECONDITION_FAILED);
        }

        return new Response('', Response::HTTP_NO_CONTENT);
    }

    /**
     * @param $id
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\JsonResponse|Response
     */
	public function display($id, Request $request) {
        $user = $this->getManagedUser()->show($id);
        if ($user) {
            return $this->json($user, Response::HTTP_OK);
        }

        return new Response('', Response::HTTP_NOT_FOUND);
	}

    /**
     * @return ManagedUser
     */
    protected function getManagedUser(): ManagedUser {
        return new ManagedUser($this->getDoctrine());
    }
}