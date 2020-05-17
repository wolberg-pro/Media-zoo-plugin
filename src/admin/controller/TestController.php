<?php


namespace MediaZoo\MediaZooPlugin;


use WP_REST_Request;

class TestController
{
	public function test(WP_REST_Request $request) {
		$pingNum = $request->get_param( 'id' );
		$data = new \stdClass();
		$data->pings  =  [];
		for ($i = 1 ; $i<= $pingNum; $i++){
			array_push($data->pings , 'Pong '.$i);
		}
		return $data;
	}

	public function validationTest($param ,$request , $key) {
		return is_numeric( $param );
	}
}
