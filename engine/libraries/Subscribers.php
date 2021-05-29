
<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class CI_Subscribers {
	
	private $ci;

	function __construct() {

		$this -> ci =& get_instance();
	
	}

	public function addToList( $attributes = [] ) {

		$tableName = 'subscriber_master';

		$this -> ci -> db -> insert($tableName, $attributes);
		
		return $this -> ci -> db -> insert_id();

	}



	public function addToGroup( $attributes = [] ) {


		$tableName = 'subscriber_user_group';

		$this -> ci -> db -> insert($tableName, $attributes);
		
		return $this -> ci -> db -> insert_id();

	}



	public function getList() {

		return $this -> ci -> db -> select('*') 
								 -> from('subscriber_master sm')
								 -> join('subscriber_user_group sg', 'sg.subscriber_id = sm.subscriber_id')
								 -> where('sm.trashed', 0)
								 -> get()
								 -> result_array();

	}



	public function searchSubscriber($string) {
		
		return $this -> ci -> db -> select('*') 
									-> from('subscriber_master sm')
									-> join('subscriber_user_group sg', 'sg.subscriber_id = sm.subscriber_id')
									-> where('sm.trashed', 0)
									-> like('sm.f_name', $string, 'before')
									-> or_like('sm.l_name', $string)
									-> or_like('sm.phone', $string)
									-> or_like('sm.email', $string)
									-> get()
									-> result_array();

	}




	public function deleteSubscriber($subID){

		return $this -> ci -> db -> where('subscriber_id', $subID) -> update('subscriber_master', ['trashed' => 1]);

	}


	public function updateSubscriber($attributes, $subID){

		return $this -> ci -> db -> where('subscriber_id', $subID) 	
								 -> update('subscriber_master', [
								 		'f_name' 	=> ucwords($attributes['f_name']),
								 		'l_name' 	=> ucwords($attributes['l_name']),
								 		'phone' 	=> $attributes['phone'],
								 		'email' 	=> $attributes['email'],
								 	]);

	}

	public function startCampaign($attributes = []){

		$return = $this -> ci -> db -> insert('subscribers_campaign', $attributes);

		if( $return ) {
			$campaignID = $this -> ci -> db -> insert_id();
		} else {
			return FALSE;
		}

		$data = $this -> ci -> db -> select('sm.subscriber_id, sm.flag')
								  -> where(['sm.trashed' => '0', 'sm.flag !=' => '-1'])
								  -> join('subscriber_user_group as su', 'su.subscriber_id = sm.subscriber_id')
								  -> from('subscriber_master as sm')
								  -> where(['su.group' 	=> $attributes['user_group'] ])
								  -> where(['su.status' => $attributes['user_status'] ])
								  -> get()
								  -> result_array();

		$campaignData = [];

		foreach ($data as $key => $value) {
			
			$campaignData[$key]['subscriber_id'] 	= $value['subscriber_id'];
			$campaignData[$key]['subscriber_flag'] 	= $value['flag'];
			$campaignData[$key]['campaign_id'] 		= $campaignID;
		
		}

		$this -> ci -> db -> insert_batch('subscribers_campaign_process', $campaignData);

		
		 return true;

	}




	public function getCampaigns( $ID = '' ){

		if($ID) {
			$this -> ci -> db -> where('campaign_id', $ID);
		}

		$campaigns = $this -> ci -> db -> select('*')
								 -> from('subscribers_campaign')
								 -> where('trashed', '0')
								 -> order_by('campaign_id', 'DESC')
								 -> get()
								 -> result_array();

		return $campaigns;

	}

	public function deleteCampaign($ID) {

		if($this -> ci -> db -> where(['campaign_id' => $ID]) -> update('subscribers_campaign', ['trashed' => 1])){
			return true;
		} else {
			return false;
		}

	}


}