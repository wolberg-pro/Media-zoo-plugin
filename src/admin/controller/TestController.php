<?php


namespace MediaZoo\MediaZooPlugin\admin\controllers;


use WP_REST_Request;

if (!defined('WPINC')) {
	die;
}

class TestController
{
	public function test(WP_REST_Request $request)
	{
		$pingNum = $request->get_param('id');
		$data = new \stdClass();
		$data->pings = [];
		for ($i = 1; $i <= $pingNum; $i++) {
			array_push($data->pings, 'Pong ' . $i);
		}
		return $data;
	}

	public function validationTest($param, WP_REST_Request $request, $key)
	{
		return is_numeric($param);
	}

	public function permissionTest($route, WP_REST_Request $request)
	{
		$pingNum = $request->get_param('id');
		return true;//current_user_can($route['permission']);
	}
}
