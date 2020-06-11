<?php


namespace MediaZoo\MediaZooPlugin\models;


use DateTime;
use MediaZoo\MediaZooPlugin\models\dto\File;
use MediaZoo\MediaZooPlugin\models\dto\Folder;

class FileSystemQuery
{
	/**
	 * @var FileSystemQuery hold the main login
	 */
	private static ?FileSystemQuery $instance = null;

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

	public static function getInstance(): FileSystemQuery
	{
		if (self::$instance == null) {
			self::$instance = new FileSystemQuery();
		}
		return self::$instance;
	}

	/***
	 * will fetch all register file from system
	 * @param int|null $folder_id
	 * @return array<File>
	 */
	public function getFiles(int $folder_id = null)
	{
		global $wpdb;
		if (is_null($folder_id)) {
			$query = $wpdb->prepare('
						select
						post.`ID`,  user.`user_nicename` as `post_author`,  post.`post_date`, post.`post_title`, post.`post_name` ,
						post.`post_excerpt` as caption,post.`post_content` as description, post.`guid` ,post.`post_mime_type`
						from ' . $wpdb->prefix . 'posts as post
						left join ' . $wpdb->prefix . 'users as user on user.`ID` = post.`post_author`
						where post.`post_type` = \'attachment\' and post.`post_media_folder_id` IS NULL
						order by post.`post_date`');
		} else {
			$query = $wpdb->prepare('
						select
						post.`ID`,  user.`user_nicename` as `post_author`,  post.`post_date`, post.`post_title`, post.`post_name` ,
						post.`post_excerpt` as caption,post.`post_content` as description, post.`guid` ,post.`post_mime_type`
						from ' . $wpdb->prefix . 'posts as post
						left join ' . $wpdb->prefix . 'users as user on user.`ID` = post.`post_author`
						where post.`post_type` = \'attachment\' and post.`post_media_folder_id` = %d`
						order by post.`post_date`', $folder_id);
		}
		$results = $wpdb->get_results($query);
		$files = [];
		if (!empty($results)) {
			foreach ($results as $row) {
				$id = intval($row->ID);
				$author = $row->post_author;
				$registerDate = $row->post_date;
				$title = $row->post_title;
				$name = $row->post_name;
				$url = $row->guid;
				$path = get_attached_file($id);
				$metaData = wp_get_attachment_metadata($id);
				$mine_type = $row->post_mime_type;
				$thumb = wp_get_attachment_thumb_url($id);
				$attachmentInfo = [
					'alt' => '',
					'description' => $row->description,
					'caption' => $row->caption,

				];
				if (strcmp($mine_type, 'image')) {
					$attachmentInfo['alt'] = get_post_meta($id, '_wp_attachment_image_alt', true);
				}
				$file = new File(
					$id,
					$author,
					$registerDate,
					$title,
					$name,
					$path,
					$url,
					$thumb,
					$mine_type,
					(is_array($metaData)) ? $metaData : [],
					(is_array($attachmentInfo)) ? $attachmentInfo : []
				);
				array_push($files, $file);
			}
		}
		return $files;
	}

	public function getCurrentLevelMediaFolders(int $folder_id = null)
	{
		global $wpdb;
		if (is_null($folder_id)) {
			$query = $wpdb->prepare('
						select
						folder.`id`,  folder.`name`, folder.`color`, folder.`description`
						from ' . $wpdb->prefix . 'media_folders as folder
						where folder.`parent_id` IS NULL
						order by folder.`id`');
		} else {
			$query = $wpdb->prepare('
						select
						folder.`id`,  folder.`name`, folder.`color`, folder.`description`
						from ' . $wpdb->prefix . 'media_folders as folder
						where folder.`parent_id` = %d
						order by folder.`id`', $folder_id);
		}
		$results = $wpdb->get_results($query);
		$folders = [];
		if (!empty($results)) {
			foreach ($results as $row) {
				$id = intval($row->id);
				$name = $row->name;
				$color = $row->color;
				$description = $row->description;
				$folder = new Folder($id, $name, $color, $description);
				array_push($folders, $folder);
			}
		}
		return $folders;
	}
	public function getFolder(int $folder_id)
	{
		global $wpdb;
		$query = $wpdb->prepare('
						select
						folder.`id`,  folder.`name`, folder.`color`, folder.`description`
						from ' . $wpdb->prefix . 'media_folders as folder
						where folder.`id` = %d
						order by folder.`id`', $folder_id);
		$row = $wpdb->get_row($query);
		$id = intval($row->id);
		$name = $row->name;
		$color = $row->color;
		$description = $row->description;
		return new Folder($id, $name, $color, $description);
	}

	public function hasFolderOnCurrentLevel(string $folder_name, ?int $folder_id = null)
	{
		global $wpdb;
		if (is_null($folder_id)) {
			$query = $wpdb->prepare('
						select
						folder.`id`
						from ' . $wpdb->prefix . 'media_folders as folder
						where folder.`parent_id` IS NULL AND folder.`name` = %s
						order by folder.`id`', $folder_name);
		} else {
			$query = $wpdb->prepare('
						select
						folder.`id`,  folder.`name`, folder.`color`, folder.`description`
						from ' . $wpdb->prefix . 'media_folders as folder
						where folder.`parent_id` = %d AND folder.`name` = %s
						order by folder.`id`', $folder_id, $folder_name);
		}
		$results = $wpdb->get_results($query);
		if (!empty($results)) {
			return true;
		}
		return false;
	}

	public function deleteFolders(array $folder_ids)
	{
		global $wpdb;
		$folder_ids =  implode(',', $folder_ids);
		$query = $wpdb->prepare('DELETE from ' . $wpdb->prefix . 'media_folders where `id` in (%s)', $folder_ids);
		$wpdb->query($query);
	}

	public function hasFoldersWithinFolderID(array $folder_ids)
	{
		global $wpdb;
		$folder_ids =  explode(',', array_map(function ($folder_id) {
			return intval($folder_id);
		}, $folder_ids));
		$query = $wpdb->prepare('
					select
					count(folder.`id`)  as total
					from ' . $wpdb->prefix . 'media_folders as folder
					where folder.`id` in (%s)
					order by folder.`id`', $folder_ids);
		$results = $wpdb->get_row($query);
		if (!empty($results) && $results->total > 0) {
			return true;
		}
		return false;
	}

	public function createFolder(string $folder_name, ?string $folder_color, ?string $folder_description, ?int $folder_id)
	{
		global $wpdb;
		$wpdb->insert($wpdb->prefix . 'media_folders', array(
			'name' => $folder_name,
			'color' => $folder_color,
			'description' => $folder_description,
			'parent_id' => $folder_id
		));
		$insert_id = $wpdb->insert_id;
		return $this->getFolder($insert_id);
	}
}
