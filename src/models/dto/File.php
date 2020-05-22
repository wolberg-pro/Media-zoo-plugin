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
	public string $file_mine_type;

	/***
	 * File constructor.
	 * @param int $id
	 * @param string $author
	 * @param string $registerDateTime
	 * @param string $title
	 * @param string $name
	 * @param string $path
	 * @param string $url
	 * @param string $mine_type
	 */
	public function __construct(int $id,
															string $author,
															string $registerDateTime,
															string $title,
															string $name,
															string $path,
															string $url,
															string $mine_type)
	{
		$this->id = $id;
		$this->author = $author;
		$this->registerDateTime = $registerDateTime;
		$this->title = $title;
		$this->name = $name;
		$this->file_path = $path;
		$this->file_url = $url;
		$this->file_mine_type = $mine_type;
	}

}
