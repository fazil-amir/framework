<?php
/* Set current server settings with corresponding host */
$temp 								= $application;
$application					= [];
$application['INFO'] 	= $temp['INFO'];
if ($application['INFO']['disabledApp']) {
	echo '<strong><center>Something went wrong</center></strong>';	
	die();
} else {
	// Localhost / Dev env
	if (
		strpos($_SERVER['HTTP_HOST'], 'localhost') !== false || 
		strpos($_SERVER['HTTP_HOST'], '127.0.0.1') !== false
	) {
		$application['NOW'] 	= $temp['DEV'];
	}
	
	// Prod env
	else if (
		strpos($_SERVER['HTTP_HOST'], 'prod') !== false
	) {
		$application['NOW'] = $temp['PROD'];
	}
	
	// Live testing env
	else if (
		strpos($_SERVER['HTTP_HOST'], 'fazilamir.me') !== false ||
		strpos($_SERVER['HTTP_HOST'], 'cody-framework') !== false
	) {
		$application['NOW'] 	= $temp['TEST'];
	}
	
	// Not found
	else {
		echo '<strong><center>Unknown Host: ' . $_SERVER['HTTP_HOST'] . '</center></strong>';		
		die();
	}
}
