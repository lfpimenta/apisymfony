<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UserController extends AbstractController {
	/**
	 * @Route("api/users", methods={"GET"}, name="users_list")
	 **/
	public function list() {
		return $this->json([[ 'id' => 1, 'name' => 'name test']]);
	}


	/**
	 * @Route("api/users/{id}", methods={"GET"}, name="users_display")
	 **/
	public function display($id) {
		return new Response("test display single $id record");
	}

	/**
	 * @Route("api/users/", methods={"POST"}, name="users_store")
	 **/
	public function store() {
		return new Response("test store");
	}

	/**
	 * @Route("api/users/{id}", methods={"DELETE"}, name="users_delete")
	 **/
	public function delete($id) {
		return new Response("test delete");
	}
}