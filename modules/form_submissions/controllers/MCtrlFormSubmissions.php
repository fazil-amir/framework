<?php
class MCtrlFormSubmissions extends CI_Controller {
  public function __construct() {
    parent::__construct();
    $this -> render -> fromModule();
    $this -> _assets = 'modules/form_submissions/assets/';
		$this -> load -> helper('file');
		$this -> count = 1;
		// for($i = 0; $i < 1000; $i++){
		// 	$this -> addFormSubmission();
		// }
		// echo $this -> getRowCount('CONTACT_US');
  }

	public function getSubmissionID(){
    return 'SUB_ID_' . $this -> count++ .'_' . date('ymdhis');
	}
	
	public function showAllWidgetView($accessorName){	
		$title = 'Form Submissions - ' . URLTitle($accessorName);

		$data = [
			'accessorName'	=> $accessorName,
			'headline' => $title
		];

		$this -> render -> setMeta([
			'title' 		=> $title,
			'pageID'		=> 'form_submission_view_all_view'
		])
		-> setActivePage(
			'nav-link-form-submissions'
		)
		-> addStyle([
			baseURL('engine/includes/pagination/pagination.css'),
			baseURL($this -> _assets . 'form-submissions.css')
			])
			-> addScript([
			'https://stackpath.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js',
			baseURL('engine/includes/pagination/pagination.min.js'),
			baseURL($this -> _assets . 'form-submissions.min.js')
		])
		-> renderView(			
			$data,
			'lay_dashboard_default',
			[	
				'views/m_view_show_all_common'
			]
		);
		
	}

	public function getFormSubmissionData($accessorName = 'CONTACT_US', $star = 1, $end = 20) {
		$count = $this -> getRowCount($accessorName);

		$rows = $this -> db -> select('*') 
									-> from('m_form_submissions')
									-> limit($end, $star) 
									-> where([
										'trashed'         => 0,
										'accessor_name'   => $accessorName
									])
									-> order_by('pr_id', 'DESC')
									-> get() 
									-> result_array();

		$this -> sendJSON([
			'success'		=> true,
			'error'			=> false,
			'message'		=> '',
			'data' 			=> $rows,
			'currCount'	=> count($rows),
			'allCount'	=> $count
		]);
	}

	public function getRowCount($accessorName) {
		return $this  -> db -> select('pr_id') 
				-> from('m_form_submissions') 
				-> where([
					'trashed'         => 0,
					'accessor_name'   => $accessorName
				])
				-> get() 
				-> num_rows();
	}

	public function getClientLocation($ip = 'UNKNOWN') {
		if($ip === 'UNKNOWN') {
			return $ip;
		}
		return $ip;
	}

	public function getClientIP() {
		$ipaddress = '';
		if (isset($_SERVER['HTTP_CLIENT_IP']))
			$ipaddress = $_SERVER['HTTP_CLIENT_IP'];
		else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
			$ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
		else if(isset($_SERVER['HTTP_X_FORWARDED']))
			$ipaddress = $_SERVER['HTTP_X_FORWARDED'];
		else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
			$ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
		else if(isset($_SERVER['HTTP_FORWARDED']))
			$ipaddress = $_SERVER['HTTP_FORWARDED'];
		else if(isset($_SERVER['REMOTE_ADDR']))
			$ipaddress = $_SERVER['REMOTE_ADDR'];
		else
			$ipaddress = 'UNKNOWN';
		return $ipaddress;
	}

	public function addFormSubmission() {
		$subID 					= $this -> getSubmissionID();
		$accessorName 	= $this -> input -> post('accessorName');
		$subject 				= $this -> input -> post('subject');
		$fullName 			= $this -> input -> post('fullName');
		$email 					= $this -> input -> post('email');
		$phone 					= $this -> input -> post('phone');
		$pageURL 				= $this -> input -> post('pageURL');
		$location 			= $this -> getClientLocation($this -> getClientIP());
		$idAddress 			= $this -> getClientIP();
		$subData				= $this -> input -> post('subData');
		
		$tableData = [
			'sub_id' 						=> $subID,
			'accessor_name' 		=> $accessorName,
			'subject'						=> $subject,
			'fullname'					=> $fullName,
			'email'							=> $email,
			'phone'							=> $phone,
			'page_url'					=> $pageURL,
			'location'					=> $location,
			'id_address'				=> $idAddress,
			'sub_data'					=> $subData,
		];
		$this -> db -> insert('m_form_submissions', $tableData);
    $this -> sendJSON([
			'success'		=> true,
			'error'			=> false,
			'message'		=> 'Message sent',
		]);
	}

	public function deleteSubmission() {
		$subID = trim(file_get_contents("php://input"));
		$subID = json_decode($subID, true);

		$this -> db -> where(['sub_id' =>  $subID['subID']]);
		$this -> db -> update('m_form_submissions', ['trashed' => 1]);
		$this -> sendJSON([
			'success'		=> true,
			'error'			=> false,
			'message'		=> 'Row deleted successfully',
		]);
	}


	public function searchForSubmission($accessorName, $term) {
		$term = utf8_decode(urldecode($term));
		$data = $this -> db -> select('*')
												-> from('m_form_submissions')
												-> where(['trashed' => 0, 'accessor_name' => $accessorName])
												-> like("subject", $term, 'both')
												-> or_like("fullname", $term, 'both')
												-> or_like("email", $term, 'both')
												-> or_like("phone", $term, 'both')
												-> or_like("page_url", $term, 'both')
												-> or_like("sub_id", $term, 'both')
												-> or_like("sub_data", $term, 'both')
												-> get()
												-> result_array();
		$this -> sendJSON($data);
	}

}


// m_view_show_all_common