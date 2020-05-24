<?php


namespace MediaZoo\MediaZooPlugin\admin\controller;


use MediaZoo\MediaZooPlugin\services\FileSystemService;
use WP_REST_Request;

if (!defined('WPINC')) {
	die;
}

class FileSystemController extends Controller
{

	public function index(WP_REST_Request $request)
	{
//		$pingNum = $request->get_param('count');
		$data = new \stdClass();
		$data->status = false;
		$data->files = FileSystemService::getInstance()->GetFiles('');
		$data->folders = [];
		$data->metaData = [
			'entitiesCount' => 0,
		];
		return $data;
	}

	public function permissionFileSystem($route, WP_REST_Request $request)
	{
		return current_user_can($route['permission']);
	}

}
