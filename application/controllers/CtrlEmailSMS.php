<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CtrlEmailSMS extends CI_Controller {
  public function shootEmail(){
    $data['firstName']	= 'Mohammed Fazil Amir';
    $body =  $this -> render -> prepareEmail([
      'layout'	=> 'lay_eml_frontend',
      'body'		=> 'eml_sample',
      'data'		=> $data
    ]);
    $return	= $this -> sparkpost -> shootEmail([
      'fromName'	=> 'Fazil Amir',
      'fromEmail'	=> 'mail@fazilamir.me',
      'toName'	=> 'Fazil Amir',
      'toEmail'	=> 'fazil.amir@outlook.com',
      'replyTo'	=> 'mail@fazilamir.me',
      'subject'	=> 'Sparkpost Email Testing',
      'body'		=> $body,
      'altBody'	=> 'Some testing data for alt body'
    ]);
    echo '<pre>';
    print_r($return);
    echo '</pre>';
  }
  
  public function shootSMS(){
    echo '<pre>';
    print_r(
      $this -> text_local 
        -> initPromotion()
        -> sendSMS(['9964517679','8971117136'], 'This is again a test from php api')
    );
    echo '</pre>';
  }

}
