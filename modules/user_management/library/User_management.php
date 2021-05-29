<?php
include_once 'modules/user_auth/library/User_auth.php';

class CI_User_management extends CI_User_auth {
	public function __construct() {
		parent::__construct();	
	}

	public function getFullName() {
		return $this -> getCurrentUser()['user_full_name'];
	}
	
	public function getUserType() {
		return $this -> getCurrentUser()['user_type'];
	}
}

?>