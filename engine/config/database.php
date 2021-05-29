<?php
defined('BASEPATH') OR exit('No direct script access allowed');

include('maps/application.php');

$active_group 		= 'default';
$query_builder 		= TRUE;

$db['default'] = [
	'dsn'	=> '',
	'hostname' => $application['NOW']['database']['host'],
	'username' => $application['NOW']['database']['user'],
	'password' => $application['NOW']['database']['password'],
	'database' => $application['NOW']['database']['database'],
	'dbdriver' => 'mysqli',
	'dbprefix' => '',
	'pconnect' => FALSE,
	'db_debug' => (ENVIRONMENT !== 'production'),
	'cache_on' => FALSE,
	'cachedir' => '',
	'char_set' => 'utf8',
	'dbcollat' => 'utf8_general_ci',
	'swap_pre' => '',
	'encrypt' => FALSE,
	'compress' => FALSE,
	'stricton' => FALSE,
	'failover' => array(),
	'save_queries' => TRUE
];
