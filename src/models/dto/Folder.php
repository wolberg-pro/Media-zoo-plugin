<?php


namespace MediaZoo\MediaZooPlugin\models\dto;


class Folder
{

	public $id;
	public $name;
	public $color;
	public $description;

	/***
	 * Folder constructor.
	 * @param int $id
	 * @param string $name
	 * @param string|null $color
	 * @param string|null $description
	 */
	public function __construct($id,
															$name,
															$color,
															$description)
	{
		$this->id = $id;
		$this->name = $name;
		$this->color = $color;
		$this->description = $description;
	}

}
