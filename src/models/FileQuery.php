<?php


namespace MediaZoo\MediaZooPlugin\models;


use DateTime;
use MediaZoo\MediaZooPlugin\models\dto\File;

class FileQuery
{
	/**
	 * @var FileQuery hold the main login
	 */
	private static ?FileQuery $instance = null;

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

	public static function getInstance(): FileQuery
	{
		if (self::$instance == null) {
			self::$instance = new FileQuery();
		}
		return self::$instance;
	}

	/***
	 * will fetch all register file from system
	 * @return array<File>
	 */
	public function getFiles()
	{
		global $wpdb;
		$query = $wpdb->prepare('
						select
						post.`ID`,  user.`user_nicename` as `post_author`,  post.`post_date`, post.`post_title`, post.`post_name` ,
						post.`post_excerpt` as caption,post.`post_content` as description, post.`guid` ,post.`post_mime_type`
						from ' . $wpdb->prefix . 'posts as post
						left join ' . $wpdb->prefix . 'users as user on user.`ID` = post.`post_author`
						where post.`post_type` = \'attachment\'
						order by post.`post_date`');
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
				if (strcmp($mine_type , 'image')) {
					$attachmentInfo['alt'] = get_post_meta( $id, '_wp_attachment_image_alt', true );
				}
				$file = new File($id, $author, $registerDate, $title, $name
					, $path, $url, $thumb, $mine_type, (is_array($metaData)) ? $metaData : [], (is_array($attachmentInfo)) ? $attachmentInfo : []);
				array_push($files, $file);
			}
		}
		return $files;
	}

}
