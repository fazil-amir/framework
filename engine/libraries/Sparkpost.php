<?php
require SYSDIR . '/php_mailer/autoload.php';
defined('BASEPATH') OR exit('No direct script access allowed');

class CI_Sparkpost {

	private $hostName;
	private $userName;
	private $password;
	private $port;
	private $SMTPSecure;
	private $SMTPAuth;

	private $mail;

	private function _init(){

		require 'maps/application.php';		

		$this -> mail 					= new PHPMailer(true);

		try{
			if(empty($application['INFO']['sparkpost']['apiKey']) || ! isset($application['INFO']['sparkpost']['apiKey'])) {
				throw new Exception('Sparkpost SMTP api-key is not set');				
			}			
		}
		catch(Exception $e) {
			echo '<pre>';
			print_r($e);
			echo '</pre>';
			die();
		}

		$this -> hostName 				= 'smtp.sparkpostmail.com';
		$this -> userName 				= 'SMTP_Injection';
		$this -> password 				= $application['INFO']['sparkpost']['apiKey'];
		$this -> port 						= 587;
		$this -> SMTPSecure 			= 'tls';
		$this -> SMTPAuth					= true;

		$this -> mail -> SMTPDebug 		= 0;
		$this -> mail -> isSMTP();                                  
		$this -> mail -> Host 			= $this -> hostName;  		
		$this -> mail -> SMTPAuth 		= $this -> SMTPAuth;
		$this -> mail -> Username 		= $this -> userName;
		$this -> mail -> Password 		= $this -> password;
		$this -> mail -> SMTPSecure 	= $this -> SMTPSecure;
		$this -> mail -> Port 			= $this -> port;  
	}	

	public function shootEmail($data){

		$this ->  _init();

		$this -> mail -> setFrom($data['fromEmail'], $data['fromName']);
		
		$this -> mail -> addAddress($data['toEmail'], $data['toName'] ); 

		$this -> mail -> Subject = $data['subject'];
		$this -> mail -> Body    = $data['body'];
		
		if(isset($data['altBody'])){
			$this -> mail -> AltBody = $data['altBody'];
		}else {
			$this -> mail -> AltBody = $data['body'];
		}
		

		if(! $this -> mail -> send() ) {
			return [
				'success' 	=> FALSE,
				'result'	=> $mail -> ErrorInfo
			];
		} else {
			return [
				'success' 	=> TRUE,
				'result'	=> 'SENT'
			];

		}

	}

}