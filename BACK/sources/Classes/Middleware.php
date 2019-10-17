<?php

namespace Marketplace\Middlewares;

use Pecee\SimpleRouter\SimpleRouter as Router;
use Pecee\Http\Middleware\IMiddleware;
use Pecee\Http\Request;

class Authentificated implements IMiddleware {

	public function handle(Request $request) {
		var_dump($request);
		die();
		if(!isset($_SESSION['user']) || $_SESSION['user'] === NULL) {
			http_response_code(401);
			die();
		}
	}
}

class NotAuthentificated implements IMiddleware {
	public function handle(Request $request) {
		if(isset($_SESSION['user']) && $_SESSION['user'] !== NULL) {
			http_response_code(403);
			die();
		}
	}
}
