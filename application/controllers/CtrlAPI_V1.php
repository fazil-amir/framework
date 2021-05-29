<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class CtrlAPI_V1 extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this -> allowedKeys = [
			'7F138A09169B250E9DCB378140907378' ,
		];
		// CHECK API KEY
		try {
			if(! in_array($this -> uri -> segment(3), $this -> allowedKeys) ) {
				throw new Exception('Invalid API Key');
			}
		}
		catch(expecption $e) {
			echo $e;
		}		
	}

	/* ============================ 
		GET META
	====================================================================================================== */
	public function getMeta($key) {
		$data = [
			'API Version' 	=> '1.0',
			'API Key'		=> $key,
		];
		$this -> _response($data);
	}

	/* ============================ 
		GET NAVIGATION
	====================================================================================================== */
	public function getNavigation($key){
		$data = [
			'META_INFO' => [
				'changedID'			=> 98765,	
			],
			'NAV_LINKS' => [
				'Home' 		=> '/',
				'Sub Menu'	=> [
					'Sub Menu 1' => '/google',
					'Sub Menu 2' => '/yahoo',
					'Sub Menu 3' => '/gmail',
				],
			]
		];
		$this -> _response($data);
	}

	/* ============================ 
		RESPONSE
	====================================================================================================== */
	private function _response($data, $type = 'JSON'){
		sleep(2);
		switch($type) {
			case 'XML':  break;
			default: 
				header('Content-Type: application/json');
				echo json_encode( $data );
		}
	}
}
