<?php
include('maps/application.php');

if (!function_exists('includeElement')) {
	function includeElement($elementName = '') {
		include getElement($elementName);
	}
}

if (!function_exists('returnElement')) {
	function returnElement($elementName = '') {
		return getElement($elementName);
	}
}

function printDie( $data ) {
	echo '<pre>';
	print_r($data);
	echo '</pre>';
	die();
}

function getElement($elementName) {
	include('maps/application.php');
	$app = 'application/';
	if (strpos($_SERVER['REQUEST_URI'], 'panel')) {
		$app = 'dashboard/';
	}
	return $application['NOW']['rootDir'] . $app . 'visuals/elements/' .  $elementName . '.php';
}


?>