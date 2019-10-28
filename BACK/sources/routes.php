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
	
	Router::group(['prefix' => '/command'], function () {
		Router::get('/{commandId?}', 'CommandController@retrieve')->where(['commandId' => '[0-9]+']);
		Router::post('/', 'CommandController@insert');
		Router::put('/{commandId}', 'CommandController@update')->where(['commandId' => '[0-9]+']);
		Router::delete('/{commandId}', 'CommandController@delete')->where(['commandId' => '[0-9]+']);
	});

	Router::group(['prefix' => '/order'], function () {
		Router::post('/', 'OrderController@create');
		Router::post('/test', 'OrderController@update');
	});

	Router::get('/country', 'CountryController@retrieve');

	Router::post('/contact', 'ContactController@contact');
	
	/*Please!*/

	Router::error(function(Request $request, \Exception $exception) {
		http_response_code($exception->getCode());
		$resp = ["details" => [$exception->getMessage()]];
		if(ENV != "prod") {
			$resp["stack"] = $exception->getTraceAsString();
		}
		echo json_encode($resp);
		die();
	});

?>
