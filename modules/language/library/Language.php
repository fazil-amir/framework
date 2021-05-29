<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
class CI_Language {
	
	private $_ci;
	private $_language;
	private $_defaultLanguage;

	function __construct() {
		$this -> _ci =& get_instance();
		require 'maps/application.php';
		$this -> _ci -> load -> helper('cookie');
		$this -> _language = isset($application['INFO']['language']) ? $application['INFO']['language'] : ['ENGLISH'];
		if(!getCookie('LANGUAGE')) {
			$this -> setLanguage($this -> _language[0]);
		}
	}

	public function getLanguages() {
		return  $this -> _language;		
	}		

	public function getLanguageFlag($lang) {
		return baseURL('modules/language/assets/flags/' . $lang . '.png'); 
	}

	public function getDefaultLanguage() {
		return  $this -> _defaultLanguage ? $this -> _defaultLanguage : getCookie('LANGUAGE');		
	}

	public function setLanguage($key) {
		if(in_array($key, $this -> getLanguages()) ) {
			$this -> _defaultLanguage = $key;
			$cookie = [
				'name'   => 'LANGUAGE',
				'value'  => $key,                            
				'expire' => 259200,
      ];
      $this -> _ci -> input -> setCookie($cookie);
		} else {
			throw new Exception('Language key not found - ' . $key);
			die();
		}		
	}

}