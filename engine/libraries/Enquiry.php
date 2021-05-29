
<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class CI_Enquiry {
	
	private $_ci;

	function __construct() {

		$this -> _ci =& get_instance();
	
	}


	public function addToEnquiry( $data ) {

		$this -> _ci -> db -> insert('enquiry_master', $data );

		return $this -> _ci -> db -> insert_id();
		
	}	


	public function getEnquiry( $category, $full = false, $ID = '' ) {

		if( $full ) {
			$select = 'enquiry_id, full_name, email, added_on, flag, CAST(comments AS CHAR(45)) as comments';
		} else {
			$select = '*';
		}

		return $this -> _ci  -> db -> select($select) 
							 -> from('enquiry_master')
							 -> where('category', $category)
							 -> order_by('added_on DESC')
							 -> get()
							 -> result_array();
		
	}

}