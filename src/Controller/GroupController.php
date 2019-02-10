<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class GroupController extends AbstractController {
	/**
	 * @Route("api/groups", methods={"GET","POST"}, name="groups_list_store")
	 **/
	public function list() {
		return $this->json("list");
	}


	/**
	 * @Route("api/groups/{id}", methods={"GET","DELETE"}, name="groups_delete_show")
	 **/
	public function display($id) {
		return new Response("test display single $id record");
	}

	/**
	 * @Route("api/groups/{groupId}/users", methods={"GET","POST"}, name="groups_users_list_store")
	 **/
	public function listAssociateUsers($groupId) {
		return new Response("test");
	}

	/**
	 * @Route("api/groups/{groupId}/users/{userIds}", methods={"DELETE"}, name="groups_users_unassociate")
	 **/
	public function dessociateUsers($groupId, $userId) {
		return new Response("test");
	}
}