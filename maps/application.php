<?php
/* App Meta */
$application['INFO'] 	= [
	'appName'			=>	'Cody Framework',
	'email'				=> [
		'adminEmail'			=> 'admin@fazilamir.me',
	],
	'language'			=> [
		'ENGLISH', 'ARABIC'
	],
	'disabledApp'				=> FALSE
];

/* Dev Settings*/
$application['DEV'] 	= [
	'appDir'			=> '/framework/',
	'rootDir'			=> $_SERVER['DOCUMENT_ROOT']  . '/framework/',
	'database'			=> [
		'host'				=> 'localhost',
		'database'		=> 'fazil4rz_cody_framework',
		'user'				=> 'root',
		'password'		=> '',
	]
];

/* Testing Settings */
$application['TEST'] 	= [
	'appDir'			=> 'https://www.cody-framework.fazilamir.me/',
	'rootDir'			=> $_SERVER['DOCUMENT_ROOT'] . '/',
	'database'			=> [
		'host'					=> 'localhost',
		'database'			=> 'fazil4rz_cody_framework',
		'user'					=> 'fazil4rz_cody',
		'password'			=> 'cody123',
	],
];

/* Prod Settings */
$application['PROD'] 	= [];

/* Staging Settings */
$application['STAG'] 	= [];

require 'servers.php';

?>