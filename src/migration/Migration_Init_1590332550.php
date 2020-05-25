<?php


namespace MediaZoo\MediaZooPlugin\migration;


use MediaZoo\MediaZooPlugin\common\Migration;

class Migration_Init_1590332550 extends Migration
{
	public function Up()
	{
		global $wpdb;
		$queries = [];
		array_push($queries, $wpdb->prepare('CREATE TABLE `wp_media_folders` (
																											`id` INT(10) NOT NULL AUTO_INCREMENT,
																											`parent_id` INT(10) NULL DEFAULT NULL,
																											`name` VARCHAR(30) NOT NULL COLLATE \'utf8mb4_bin\',
																											`color` VARCHAR(15) NULL DEFAULT NULL COLLATE \'utf8mb4_bin\',
																											`description` TEXT NULL COLLATE \'utf8mb4_bin\',
																											PRIMARY KEY (`id`)
																										)'));
		array_push($queries, $wpdb->prepare('ALTER TABLE `wp_posts` ADD COLUMN `post_meida_folder_id` INT(10) UNSIGNED NULL DEFAULT NULL AFTER `ID`;'));
		$this->runQuery($queries);
	}

	public function Down()
	{
		global $wpdb;
		$queries = [];
		array_push($queries, $wpdb->prepare('DROP TABLE IF EXISTS `wp_media_folders`'));
		array_push($queries, $wpdb->prepare('ALTER TABLE `wp_posts` DROP COLUMN `post_meida_folder_id`'));
		$this->runQuery($queries);
	}
}