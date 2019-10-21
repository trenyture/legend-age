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
	
	Router::group(['prefix' => '/user'], function () {
		Router::get('/{userId?}', 'UserController@retrieve')->where(['userId' => '[0-9]+']);
		Router::post('/', 'UserController@insert');
		Router::put('/{userId}', 'UserController@update')->where(['userId' => '[0-9]+']);
		Router::delete('/{userId}', 'UserController@delete')->where(['userId' => '[0-9]+']);
	});
	
	/*Please!*/
	Router::post('/contact', 'EmailController@contact');

	Router::error(function(Request $request, \Exception $exception) {
		http_response_code(404);
		die();
	});

?>
