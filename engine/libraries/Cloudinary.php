<?php
defined('BASEPATH') or exit('No direct script access allowed');

require SYSDIR . '/cloudinary/Cloudinary.php';
require SYSDIR . '/cloudinary/Uploader.php';
require SYSDIR . '/cloudinary/Api.php';

class CI_Cloudinary {
	private $ci;
  public function __construct() {
		$this->ci = &get_instance();
		require 'maps/application.php';
		\Cloudinary::config(array(
			"cloud_name" => $application['INFO']['cloudinary']['cloudName'],
			"api_key" => $application['INFO']['cloudinary']['APIKey'],
			"api_secret" => $application['INFO']['cloudinary']['APISecret'],
		));
	}
	public function uploadBase64($data, $settings = []) {
		return \Cloudinary\Uploader::upload($data, $settings);
	}
}
