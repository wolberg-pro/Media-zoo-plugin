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

	public function isFolderEmpty(array $folder_id)
	{
		if (FileSystemQuery::getInstance()->hasFoldersWithinFolderID($folder_id)) {
			return false;
		}
		return true;
	}

	public function deleteFolders(array $folder_ids)
	{
		if ($folder_ids > 0) return true;
		if ($this->isFolderEmpty($folder_ids)) {
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

	public function uploadNewMediaItem($file , $params) {

		$filename = basename($file);

		$upload_file = wp_upload_bits($filename, null, file_get_contents($file));
		if (!$upload_file['error']) {
			$wp_filetype = wp_check_filetype($filename, null);
			$attachment = array(
				'post_mime_type' => $wp_filetype['type'],
				'post_parent' => null,
				'post_media_folder_id' => $params['folder_id'],
				'post_title' => $params['name'],
				'post_content' => $params['description'],
				'post_excerpt' => $params['caption'],
				'post_status' => 'inherit'
			);
			$attachment_id = wp_insert_attachment($attachment, $upload_file['file'], null);
			if (!is_wp_error($attachment_id)) {
				require_once(ABSPATH . "wp-admin" . '/includes/image.php');
				$attachment_data = wp_generate_attachment_metadata($attachment_id, $upload_file['file']);
				wp_update_attachment_metadata($attachment_id,  $attachment_data);
				update_post_meta(
					$attachment_id,
					'_wp_attachment_image_alt',
					$params['alt']
				);
				return true;
			}
		}
		return false;
	}
}
