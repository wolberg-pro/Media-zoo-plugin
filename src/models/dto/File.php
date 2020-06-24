<?php


namespace MediaZoo\MediaZooPlugin\models\dto;


use DateTime;

class File
{
	public $id;
	public $author;
	public $registerDateTime;
	public $title;
	public $name;
	public $file_path;
	public $file_url;
	public $file_thumb_url;
	public $file_mine_type;
	public $file_meta_data;
	public $file_info;

	/***
	 * File constructor.
	 * @param int $id
	 * @param string $author
	 * @param string $registerDateTime
	 * @param string $title
	 * @param string $name
	 * @param string $path
	 * @param string $url
	 * @param string $thoumb
	 * @param string $mine_type
	 * @param array $file_metaData
	 * @param array $file_info
	 */
	public function __construct($id,
															$author,
															$registerDateTime,
															$title,
															$name,
															$path,
															$url,
															$thoumb,
															$mine_type,
															$file_metaData,
															$file_info)
	{
		$this->id = $id;
		$this->author = $author;
		$this->registerDateTime = $registerDateTime;
		$this->title = $title;
		$this->name = $name;
		$this->file_path =  $path;
		$this->file_url =  $url;
		$this->file_thumb_url = $thoumb;
		$this->file_mine_type =  $mine_type;
		$this->file_meta_data = $file_metaData;
		$this->file_info = $file_info;
	}

}
