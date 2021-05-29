<?php
class MCtrlLanguage extends CI_Controller {
	public function __construct() {
		parent::__construct();
	}
	public function changeLanguage($key){	
		$this -> language -> setLanguage(strtoupper($key));
		redirect($_SERVER["HTTP_REFERER"]);
	}
}