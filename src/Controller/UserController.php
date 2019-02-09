<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;

class UserController {
	public function list() {
		return new Response("test");
	}

	public function store() {
		return new Response("test store");
	}

	public function delete() {
		return new Response("test delete");
	}
}