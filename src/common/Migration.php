<?php


namespace MediaZoo\MediaZooPlugin\common;


abstract class Migration
{

	public function Up() {
	}


	public function Down() {
	}

	protected function runQuery(array $queries) {
		global $wpdb;
		$wpdb->show_errors();
		if (is_array($queries)) {
			foreach ($queries as $query) {
				$wpdb->query($query);
			}
		}
	}

}
