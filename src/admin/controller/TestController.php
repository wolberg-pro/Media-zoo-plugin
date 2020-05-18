<?php


namespace MediaZoo\MediaZooPlugin\admin\controller;


use WP_REST_Request;

if (!defined('WPINC')) {
	die;
}

class TestController extends Controller
{

	public function test(WP_REST_Request $request)
	{
		$pingNum = $request->get_param('count');
		$data = new \stdClass();
		$data->pings = [];
		for ($i = 1; $i <= $pingNum; $i++) {
			array_push($data->pings, 'Pong ' . $i);
		}
		return $data;
	}

	public function validationTest($param, WP_REST_Request $request, $key)
	{
		return $this->verifyNonce($request) && is_numeric($param);
	}

	public function permissionTest($route, WP_REST_Request $request)
	{
		$pingNum = $request->get_param('count');
		return current_user_can($route['permission']);
	}
}
