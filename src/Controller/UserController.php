<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController {
	/**
	 * @Route("api/users", methods={"GET"})
	 **/
	public function list() {
		return new Response("test");
	}


	/**
	 * @Route("api/users/{id}", methods={"GET"})
	 **/
	public function display($id) {
		return new Response("test display single $id record");
	}

	/**
	 * @Route("api/users/", methods={"POST"})
	 **/
	public function store() {
		return new Response("test store");
	}

	/**
	 * @Route("api/users/{id}", methods={"DELETE"})
	 **/
	public function delete($id) {
		return new Response("test delete");
	}
}