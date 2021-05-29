<?php
/* =====================================
	LIVE EDIT	
================================================================================================================ */
class MCtrlLiveEdit extends CI_Controller {
	public function toggleLiveEdit() {
		// Turn off
		if( $this -> session -> hasSession('live-edit') ) {
			$this -> session -> unsetSession('live-edit');
			$data = [
				'success' 	=> 1,
				'data'	 	=> [
					'edit' 	=> false
				],
				'operation'	=> '',
				'message'	=> 'Live edit is turned off.',
			];
		} 
		// Turn on
		else {
			$this -> session -> setSession('live-edit', TRUE);
			$data = [
				'success' 	=> 1,
				'data'	 	=> [
					'edit' 	=> true
				],
				'operation'	=> '',
				'message'	=> 'Live edit is turned on. Redirecting to homepage',
			];
		}	
		echo json_encode($data);
	}

	public function saveLiveEdit() {		
		$dated 		 = date('Y-m-d H:i:s');
		$input 		 = $this -> input -> post();
		$items 		 = json_decode($input['data'], true);
		$language  = $this -> language -> getDefaultLanguage();
		$addedBy	 = $this -> user_management -> getFullName();
		$data 		 = [];
		foreach ($items as $key => $item) {
			foreach ($item as $k => $i) {
				$data = [
					'page_name' 		=> $input['page-name'],
					'element_id'		=> '[' . $language . ']:' .$k,
					'language'			=> $language,
					'element_data'	=> $i,
					'added_by'			=> $addedBy,
					'added_on'			=> $dated,
				];	
				$this -> db -> replace('m_live_edit', $data);
			}
		}
		echo json_encode(1);
	}
}