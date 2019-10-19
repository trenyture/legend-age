<?php

	include dirname(__FILE__).'/Classes/Middleware.php';

	use Pecee\SimpleRouter\SimpleRouter as Router;
	use Pecee\Http\Request;

	Router::get('/', function() {
		echo json_encode(["success" => true]);
		die();
	});

	/*Apply your routes here*/
	Router::group(['prefix' => '/login'], function () {
	    Router::post('/', 'LoginController@signin');
	    Router::put('/', 'LoginController@newPassword');
	    Router::delete('/', 'LoginController@logout');
	});
	/*Please!*/

	Router::error(function(Request $request, \Exception $exception) {
		http_error_code(404);
		die();
	});

?>
