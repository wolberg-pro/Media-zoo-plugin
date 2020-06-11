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
		$params = json_decode($request->get_body());
		$action_type = (isset($params->type)) ? trim(strtolower($params->type)) : null;
		$parent_folder_id = (isset($params->parent_folder_id) && is_numeric($params->parent_folder_id)) ? intval($params->parent_folder_id) : null;
		$data = new \stdClass();
		$data->status = false;
		$data->action = $action_type;
		switch ($action_type) {
			case 'upload_files':
				break;
			case 'folder':
				$folder_name = sanitize_file_name(trim($params->folder_name));
				$folder_color = sanitize_hex_color(trim($params->folder_color));
				$folder_description = sanitize_textarea_field(trim($params->folder_description));
				$folderObject = FileSystemService::getInstance()->createFolder($folder_name, $folder_color, $folder_description, $parent_folder_id);
				$data->status = true;
				$data->folder = $folderObject;
				break;
			default:
				$data->action = 'ignored';
		}
		return $data;
	}
	public function deleteFolders(WP_REST_Request $request)
	{
		$data = new \stdClass();
		$params = json_decode($request->get_body());
		$data->status = false;
		if (FileSystemService::getInstance()->deleteFolders($params->folders)) {
			$data->status =  true;
		} else {
			$data->message = "One or more folders Not empty and has folders within at please delete them";
		}
		return $data;
	}

	public function deleteFiles(WP_REST_Request $request)
	{
		$data = new \stdClass();
		$params = json_decode($request->get_body());
		FileSystemService::getInstance()->deleteFiles($params->files);
		$data->status = true;
		return $data;
	}

	public function deleteMediaItems(WP_REST_Request $request)
	{
		$data = new \stdClass();
		$params = json_decode($request->get_body());
		$data->operators = [
			'file' => $this->deleteFiles($request),
			'folder' => $this->deleteFolders($request),
		];
		$data->files = FileSystemService::getInstance()->GetFiles($params->folder_id);
		$data->folders = FileSystemService::getInstance()->getFolders($params->folder_id);
		return $data;
	}

	public function permissionFileSystem($route, WP_REST_Request $request)
	{
		return current_user_can($route['permission']);
	}
}
