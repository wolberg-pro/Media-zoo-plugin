<?php


namespace MediaZoo\MediaZooPlugin\models\dto;


use DateTime;

class File
{
	public int $id;
	public string $author;
	public string $registerDateTime;
	public string $title;
	public string $name;
	public string $file_path;
	public string $file_url;
	public string $file_thumb_url;
	public string $file_mine_type;
	public array $file_meta_data;
	public array $file_info;

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
	public function __construct(int $id,
															string $author,
															string $registerDateTime,
															string $title,
															string $name,
															string $path,
															string $url,
															string $thoumb,
															string $mine_type,
															array $file_metaData,
															array $file_info)
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
