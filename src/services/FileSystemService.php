<?php


namespace MediaZoo\MediaZooPlugin\services;

use MediaZoo\MediaZooPlugin\models\FileSystemQuery;

if (!defined('WPINC')) {
	die;
}

class FileSystemService
{

	/**
	 * @var FileSystemService hold the main login
	 */
	private static ?FileSystemService $instance = null;


	/**
	 * Instantiate a Plugin object.
	 *
	 * Don't call the constructor directly, use the `Plugin::get_instance()`
	 * static method instead.
	 *
	 * @since 0.1.0
	 */
	protected function __construct()
	{
	}

	/**
	 * Singletons should not be cloneable.
	 */
	protected function __clone()
	{
	}

	/**
	 * Singletons should not be restorable from strings.
	 */
	public function __wakeup()
	{
		throw new \Exception("Cannot unserialize a singleton.");
	}

	public static function getInstance(): FileSystemService
	{
		if (self::$instance == null) {
			self::$instance = new FileSystemService();
		}
		return self::$instance;
	}

	public function getFiles(int $folder_id = null)
	{
		return FileSystemQuery::getInstance()->getFiles($folder_id);
	}

	public function getFolders(int $folder_id = null)
	{
		return FileSystemQuery::getInstance()->getCurrentLevelMediaFolders($folder_id);
	}

	public function isFolderExist(array $folder_id)
	{
		if (FileSystemQuery::getInstance()->hasFolderExistedByFolderID($folder_id)) {
			return false;
		}
		return true;
	}

	public function deleteFolders(array $folder_ids)
	{
		if ($this->isFolderExist($folder_ids)) {
			// fetching files
			$files = [];
			foreach ($folder_ids as $folder_id) {
				$files = array_merge($files, $this->getFiles($folder_id));
			}
			// let delete folder file
			foreach ($files as $file) {
				wp_delete_attachment($file->ID);
			}

			FileSystemQuery::getInstance()->deleteFolders($folder_ids);
			return true;
		}
		return false;
	}

	public function deleteFiles(array $files_ids)
	{
		foreach ($files_ids as $file_id) {
			wp_delete_attachment($file_id);
		}
	}

	public function createFolder(string $folder_name, ?string $folder_color, ?string $folder_description, ?int $folder_id)
	{
		if (FileSystemQuery::getInstance()->hasFolderOnCurrentLevel($folder_name, $folder_id)) {
			return false;
		}
		return FileSystemQuery::getInstance()->createFolder($folder_name, $folder_color, $folder_description, $folder_id);
	}
}
