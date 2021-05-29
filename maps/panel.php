<?php
/* =====================================
	MODULES:
	Here you'll tell what module do you want to load, and the same will have routes defined below.
	You'll specify pre-existing modules or project specific modules
	AVAILABLE MODULE: [ BLOCK_CMS, WIDGETS ]	
================================================================================================================ */

$panel['load'] = [	
	// User defined module. The details routes to be defined below in this page.
	'DASHBOARD', 
	
	// Existing module, route is defined inside modules/routes.php.
	'BLOCK_CMS' => [
		'showGallery' => false,
		'accessorName' => [
		  //  'BLOG_ARTICLE',
			'PRODUCT_PAGE',
			'GENERIC_PAGE',
			'UNCATEGORIZED'
		]
	],

// 	'WIDGETS' => [
// 		'IMAGE_SLIDER' => [
// 			'accessorName' => [
// 				'home page slider'
// 			]
// 		],
// 		'TESTIMONIAL' => [
// 			'accessorName' => [
// 				'common testimonial'
// 			]
// 		],
// 		'COMMON_UI' => [
// 			'accessorName' => [ 
// 				'Clientele',
// 				'Skill Meter'
// 			]
// 		]
// 	],

	'FORM_SUBMISSIONS'	=> [
		[
			'caption' => 'Contact Us',
			'accessorName' => 'CONTACT_US'
		],
		[
			'caption' => 'Enquiries',
			'accessorName' => 'ENQUIRY'
		],
	],

	'LIVE_EDIT'
];

/* =====================================
	Routes
================================================================================================================ */
$panel['modules']['DASHBOARD']	= [	
	/* ---------------------------	
		DASHBOARD		
	------------------------------------------------------------------------------------------------------- */
	'id'						=> 'nav-link-dashboard',
	'menuCaption'				=> 'Dashboard',	
	'routes'					=> [
		'panel'					=> 'CtrlDashboard/dashboard'
	]
];

/* =====================================
	MAIL COLORS	
================================================================================================================ */
$panelColors	= [
	'colorPrimary'		=> ' #484848 ',
	'colorSecondary'	=> ' #8BC34A ',
	'colorTertiary'		=> ' #4b626d ',

	'colorBackground'	=> ' #fafafa ',
	'colorEmailBody'	=> ' #ffffff ',
	'colorEmailBorder'	=> ' #f4f4f4 '
];
