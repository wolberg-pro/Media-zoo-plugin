<?php


namespace MediaZoo\MediaZooPlugin\admin\controller;


if (!defined('WPINC')) {
	die;
}

use WP_REST_Request;

abstract class Controller
{
	protected function verifyNonce(WP_REST_Request $request){
		$nonce = $request->get_header('X-WP-Nonce');
		return wp_verify_nonce($nonce);
	}

}
