<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class GroupController extends AbstractController {
	/**
	 * @Route("api/groups", methods={"GET"}, name="groups_list")
	 **/
	public function list() {
		return $this->json("list");
	}


	/**
	 * @Route("api/groups/{id}", methods={"GET"}, name="groups_display")
	 **/
	public function display($id) {
		return new Response("test display single $id record");
	}

	/**
	 * @Route("api/groups/", methods={"POST"}, name="groups_store")
	 **/
	public function store() {
		return new Response("test store");
	}

	/**
	 * @Route("api/groups/{id}", methods={"DELETE"}, name="groups_delete")
	 **/
	public function delete($id) {
		return new Response("test delete");
	}

	/**
	 * @Route("api/groups/{groupId}/users", methods={"GET"}, name="groups_users_list")
	 **/
	public function listAssociateUsers($groupId) {
		return new Response("test list");
	}

	/**
	 * @Route("api/groups/{groupId}/users", methods={"POST"}, name="groups_users_store")
	 **/
	public function associateUsers($groupId) {
		return new Response("test store");
	}

	/**
	 * @Route("api/groups/{groupId}/users", methods={"DELETE"}, name="groups_users_delete")
	 **/
	public function dessociateUsers($groupId) {
		return new Response("test store");
	}
}