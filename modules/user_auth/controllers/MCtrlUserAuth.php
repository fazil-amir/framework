<?php
class MCtrlUserAuth extends CI_Controller {
	public function __construct(){		
		parent::__construct();					
	}
	
	/* =====================================
		PROCESS LOGIN	
	================================================================================================================ */
	public function processLogin(){
		$this -> user_auth -> processLogin();
	}
	
	/* =====================================
		PROCESS LOGOUT	
	================================================================================================================ */
	public function processLogout(){
		$this -> user_auth -> processLogout();
  }

}