<?php

namespace App\Controller;

use App\Business\ManagedUser;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\User;

class UserController extends AbstractController {
	/**
	 * @Route("api/users", methods={"GET", "POST"}, name="users_list_store")
	 **/
	public function list(Request $request) {
        if($request->isMethod('GET')) {
			return $this->json(
			    $this->getManagedUser()->getAll(),
                Response::HTTP_OK
            );
		}

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
	 * @Route("api/users/{id}", methods={"GET", "DELETE"}, name="users_delete_display")
	 **/
	public function display($id, Request $request) {
        if($request->isMethod('DELETE')) {
            try {
                $this->getManagedUser()->deleteRecord($id);
            } catch (ORMException $e) {
                return new Response('', Response::HTTP_PRECONDITION_FAILED);
            } catch (OptimisticLockException $e) {
                return new Response('', Response::HTTP_PRECONDITION_FAILED);
            }

            return new Response('', Response::HTTP_NO_CONTENT);
        }

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
        return new ManagedUser(
            $this->getDoctrine()->getManager(),
            $this->getDoctrine()->getRepository(User::class)
        );
    }
}