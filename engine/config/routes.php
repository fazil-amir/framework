<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
$route['language/change/(:any)'] 	= 'MCtrlLanguage/changeLanguage/$1';

if (
	strpos($_SERVER['REQUEST_URI'], 'panel') ||
	strpos($_SERVER['REQUEST_URI'], 'bridge')
	) {
	$route['default_controller'] = 'CtrlDashboard';
	include 'modules/routes.php';
	foreach ($panel['load'] as $key => $moduleName) {	
		$moduleName = is_array($moduleName) ? $key : $moduleName;	
		foreach($panel['modules'][$moduleName]['routes'] as $key => $routeValue) {	
			$route[$key] = $routeValue;
		}
	}
} else {
	$route['default_controller'] = 'CtrlFrontend/homeView';
	include 'maps/routes.php';
	$route['(:any)'] = 'CtrlFrontend/homeView';
}

// echo '<pre>';
// print_r($route);
// echo '</pre>';