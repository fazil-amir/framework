<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CI_Controller {
	private static $instance;

	public function __construct() {
		include 'maps/panel.php';

		self::$instance =& $this;
		foreach (is_loaded() as $var => $class) {
			$this->$var =& load_class($class);
		}

		$this->load =& load_class('Loader', 'core');
		$this->load->initialize();
		log_message('info', 'Controller Class Initialized');
		$this -> load -> library('../../modules/language/library/Language');
		
		
		if(strpos($_SERVER['REQUEST_URI'], 'panel')) {
			$this -> load -> library('../../modules/user_auth/library/user_auth'); 
			$this -> load -> library('../../modules/user_management/library/user_management'); 
			$this -> user_auth -> checkLoginSession();
		}

		if(in_array('WIDGETS', $panel['load']) || isset($panel['load']['WIDGETS'])) {
			$this -> load -> library('../../modules/widgets/library/widgets');
		}

		if(in_array('BLOCK_CMS', $panel['load']) || isset($panel['load']['BLOCK_CMS'])) {
			$this -> load -> library('../../modules/block_cms/library/Block_cms');
		}

	}

	public static function &get_instance() {
		return self::$instance;
	}

	public function sendJSON($echo , $sleep = 0) {
		if( $sleep ) sleep($sleep);
		header('Content-Type: application/json');
		echo json_encode($echo);
		die();
	}

}
