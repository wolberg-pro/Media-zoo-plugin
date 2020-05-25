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
		$queryParams = $request->get_file_params();
		$folder_id = (isset($queryParams['folder_id']) && is_numeric($queryParams['folder_id'])) ? intval($queryParams['folder_id']) : null;
		$data = new \stdClass();
		$data->files = FileSystemService::getInstance()->GetFiles($folder_id);
		$data->folders = FileSystemService::getInstance()->getFolders($folder_id);
		return $data;
	}

	public function create(WP_REST_Request $request)
	{
		$queryParams = $request->get_file_params();
		$folder_id = (isset($queryParams['folder_id']) && is_numeric($queryParams['folder_id'])) ? intval($queryParams['folder_id']) : null;
		$action_type = (isset($queryParams['type'])) ? trim(strtolower($queryParams['type'])) : null;
		$params = $request->get_body_params();
		$data = new \stdClass();
		$data->status = false;
		$data->action = $action_type;
		switch ($action_type) {
			case 'upload_files':
				break;
			case 'folder':
				$folder_name = sanitize_file_name(trim($params['folder_name']));
				$folder_color = sanitize_hex_color(trim($params['folder_color']));
				$folder_description = sanitize_textarea_field(trim($params['folder_description']));
				$folderObject = FileSystemService::getInstance()->createFolder($folder_name, $folder_color, $folder_description);
				break;
			default:
				$data->action = 'ignored';
		}
		return $data;

	}

	public function permissionFileSystem($route, WP_REST_Request $request)
	{
		return current_user_can($route['permission']);
	}

}
