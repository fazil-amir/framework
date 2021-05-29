<?php 
class CI_User_Auth {
	public $currentUser = null;
	private $_ci;
	private $tableName = 'm_users';

	function __construct() {
		$this -> _ci =& get_instance();	
	}

	/* =====================================
		GET USER DETAILS AGAINST A USER DURING LOGIN
	================================================================================================================ */
	private function _getUserDetails($username, $password) {
		$res = $this -> _ci -> db -> select('user_id, user_name, user_type, user_full_name, user_email, disabled')
								 -> from($this -> tableName)
								 -> where(['trashed' => 0, 'user_name' => $username, 'password' => $password]) 
								 -> order_by('pr_id', 'DESC') 
								 -> get()
								 -> result_array();
		return $res ? $res[0] : [];
	}

	/* =====================================
		PROCESS LOGIN	
	================================================================================================================ */
	public function processLogin() {
		$username 		= $this -> _ci -> input -> post('username');
		$password 		= $this -> _ci -> input -> post('password');
		$result 			= $this -> _getUserDetails($username, $password);
		$messages 		= ['error' => ''];
		if (count($result)) {
			// Valid user but check if disabled
			if($result['disabled'] == 0) {
				// Valid user. 
				$this -> _ci -> session -> setSession(['LOGIN' => $result]);
				var_dump($this -> _ci -> session -> hasSession('LOGIN'));
				$this -> currentUser = $result;
				redirect('/panel');
			} else {
				$messages = ['error' => 'Your account is disabled.'];		
			}
		} else {
			$messages = ['error' => 'Invalid Credentials'];			
		}
		echo $this -> _ci -> load -> view('layouts/lay_login', $messages, TRUE);
		die();
	}

	/* =====================================	
		PROCESS LOGOUT	
	================================================================================================================ */
	public function processLogout(){
		$this -> _ci -> session -> clearSession('LOGIN');
		$this -> currentUser = null;
		redirect('/panel/user-auth/login');
	}

	/* =====================================	
		GETS CALLED IN CONTROLLER BY DEFAULT	
	================================================================================================================ */
	public function checkLoginSession() {	
		if (!$this -> _ci -> session -> hasSession('LOGIN') && $this -> _ci -> uri -> segment(3) != 'login' ) {
			redirect('/panel/user-auth/login');		
		}
		return true;
	}

	/* =====================================
		GETS CURRENT USER
	================================================================================================================ */
	public function getCurrentUser() {
		return $this -> _ci -> session -> getSession('LOGIN');
	}
}