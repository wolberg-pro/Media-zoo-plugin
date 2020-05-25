<?php


namespace MediaZoo\MediaZooPlugin\models\dto;


class Folder
{

	public int $id;
	public string $name;
	public ?string $color;
	public ?string $description;

	/***
	 * Folder constructor.
	 * @param int $id
	 * @param string $name
	 * @param string|null $color
	 * @param string|null $description
	 */
	public function __construct(int $id,
															string $name,
															?string $color,
															?string $description)
	{
		$this->id = $id;
		$this->name = $name;
		$this->color = $color;
		$this->description = $description;
	}

}
