<?php
require SYSDIR . '/text_local/textlocal.class.php';
class CI_Text_local {
	private $SMS;
	private $senderID;

	public function initPromotion(){
		require 'maps/application.php';		
		$this -> SMS 		= new Textlocal($application['INFO']['textLocal']['PROMOTION']['username'], $application['INFO']['textLocal']['PROMOTION']['APIKey']);
		$this -> senderID 	= $application['INFO']['textLocal']['PROMOTION']['senderID'];
		return $this;
	}

	public function initTransaction(){
		require 'maps/application.php';		
		$this -> SMS = new Textlocal($application['INFO']['textLocal']['TRANSACTION']['username'], $application['INFO']['textLocal']['TRANSACTION']['APIKey']);
		$this -> senderID 	= $application['INFO']['textLocal']['TRANSACTION']['senderID'];
		return $this;
	}

	public function sendSMS($numbers, $message){
		try {
			$result = $this -> SMS -> sendSms($numbers, $message, $this -> senderID);
			return [
				'success'	=> TRUE,
				'result'	=> $result
			];
		} catch (Exception $e) {
			return [
				'success' 	=> FALSE,
				'result' 	=> $e -> getMessage()
			];
		}
	}

}

?>