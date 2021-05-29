<?php
include 'maps/panel.php';
// Autoload needed modules by the system.
array_push($panel['load'], 'OPERATIONS', 'USER_AUTH', 'LANGUAGE');

/* =====================================
	BLOCK_CMS	
================================================================================================================ */
if(in_array('BLOCK_CMS', $panel['load']) || isset($panel['load']['BLOCK_CMS'])) {
	$panel['modules']['BLOCK_CMS'] 	= [		
		'urlKey'				=> 'block-cms',	
		'moduleDir'			=> 'modules/block_cms/',
		'id'						=> 'nav-link-block-cms',
		'menuCaption'					=> 'Block CMS',
		'subMenuCaption'			=> [
			'Add Category'					=> 'panel/block-cms/category/add',
			'View All Category'			=> 'panel/block-cms/categories',
			'DIVIDER-LINE'					=> 'DIVIDER-LINE',
			'Add New Page'					=> 'panel/block-cms/add',
			'View All Page'					=> 'panel/block-cms/posts',
		],
		'routes' => [
			'panel/block-cms/categories'										=> 'MCtrlBlockCMS/categories',	
			'panel/block-cms/category/add'									=> 'MCtrlBlockCMS/categoryView',	
			'panel/block-cms/category/add/(:any)'						=> 'MCtrlBlockCMS/categoryView/$1',
			'panel/block-cms/category/add-update/(:any)'		=> 'MCtrlBlockCMS/categoryAdd/$1',
			'panel/block-cms/posts'													=> 'MCtrlBlockCMS/posts',     		//'showing all'
			'panel/block-cms/post/(:any)'										=> 'MCtrlBlockCMS/postView/$1',  	  //'showing one item'
			'panel/block-cms/add'														=> 'MCtrlBlockCMS/postView',    	//'new add view entry'
			'panel/block-cms/add/(:any)'										=> 'MCtrlBlockCMS/postAdd/$1',   	//'insert to db'
		]
	];
}

/* =====================================
	WIDGETS	
================================================================================================================ */
if(in_array('WIDGETS', $panel['load']) || isset($panel['load']['WIDGETS'])) {
	$menu = [];
	if(isset($panel['load']['WIDGETS']['IMAGE_SLIDER'])) {
		$menu['Image Slider'] = 'panel/widgets/show-all/IMAGE_SLIDER?addLink=' . 'panel/widgets/image-slider/add&viewLink=panel/widgets/show-all/IMAGE_SLIDER';
	}
	if(isset($panel['load']['WIDGETS']['TESTIMONIAL'])) {
		$menu['Testimonials'] = 'panel/widgets/show-all/TESTIMONIAL?addLink=' . 'panel/widgets/testimonial/add&viewLink=panel/widgets/show-all/TESTIMONIAL';
	}

	if(isset($panel['load']['WIDGETS']['COMMON_UI'])) {
		// $menu['Common UI'] = 'panel/widgets/common-ui/add';
		$menu['Common UI'] = 'panel/widgets/show-all/COMMON_UI?addLink=' . 'panel/widgets/common-ui/add&viewLink=panel/widgets/show-all/COMMON_UI';
	}

	$panel['modules']['WIDGETS'] 	= [		
		'urlKey'				=> 'widgets',	
		'moduleDir'			=> 'modules/widgets/',
		'id'						=> 'nav-link-widgets',
		'menuCaption'					=> 'Widgets',
		'subMenuCaption'			=> $menu,
		'routes' => [
			// Widget common
			'panel/widgets/show-all/(:any)'											  => 'MCtrlWidget/showAllWidgetView/$1',	// Showing all

			// IMAGE_SLIDER
			'panel/widgets/image-slider/add'											=> 'MCtrlImageSlider/sliderAddView',	  // New view
			'panel/widgets/image-slider/add/(:any)'								=> 'MCtrlImageSlider/sliderAddView/$1',	// Update view
			'panel/widgets/image-slider/add-update/(:any)'				=> 'MCtrlImageSlider/sliderAdd/$1',     // Call to ctrl

			// TESTIMONIAL
			'panel/widgets/testimonial/add'											=> 'MCtrlTestimonial/testimonialAddView',	    // New view
			'panel/widgets/testimonial/add/(:any)'							=> 'MCtrlTestimonial/testimonialAddView/$1',	// Update view
			'panel/widgets/testimonial/add-update/(:any)'				=> 'MCtrlTestimonial/testimonialAdd/$1',      // Call to ctrl

			// TESTIMONIAL
			'panel/widgets/common-ui/add'											=> 'MCtrlCommonUI/commonUIAddView',	    // New view
			'panel/widgets/common-ui/add/(:any)'							=> 'MCtrlCommonUI/commonUIAddView/$1',	// Update view
			'panel/widgets/common-ui/add-update/(:any)'				=> 'MCtrlCommonUI/commonUIAdd/$1',      // Call to ctrl
		]
	];
}


/* =====================================
	FORM_SUBMISSIONS	
================================================================================================================ */
if(in_array('FORM_SUBMISSIONS', $panel['load']) || isset($panel['load']['FORM_SUBMISSIONS'])) {
	
	$menu = [];
	foreach($panel['load']['FORM_SUBMISSIONS'] as $item) {
		$menu[$item['caption']] = 'panel/form-submissions/show-all/' . $item['accessorName'];
	}

	$panel['modules']['FORM_SUBMISSIONS'] 	= [		
		'urlKey'				=> 'form-submissions',	
		'moduleDir'			=> 'modules/form_submissions/',
		'id'						=> 'nav-link-form-submissions',
		'menuCaption'					=> 'Form Submissions',
		'subMenuCaption'			=> $menu,
		'routes' => [
			// Widget common
			'bridge/form-submissions/add' => 'MCtrlFormSubmissions/addFormSubmission',
			'panel/form-submissions/show-all/(:any)' => 'MCtrlFormSubmissions/showAllWidgetView/$1',	// Showing all
			'panel/form-submissions/get-submission-data/(:any)/(:any)/(:any)' => 'MCtrlFormSubmissions/getFormSubmissionData/$1/$2/$3',	// Showing all
			'panel/form-submissions/delete-submission' => 'MCtrlFormSubmissions/deleteSubmission',	// Showing all
			'panel/form-submissions/search-submission/(:any)/(:any)' => 'MCtrlFormSubmissions/searchForSubmission/$1/$2',	// Showing all
		]
	];
}


/* =====================================
	LIVE EDIT
================================================================================================================ */
if(in_array('LIVE_EDIT', $panel['load'])) {
	$panel['modules']['LIVE_EDIT'] 	= [	
		'urlKey'				=> 'live-edit',		
		'moduleDir'			=> 'modules/live_edit/',
		'routes'				=> [
			'panel/live-edit/client/save' 				=> 'MCtrlLiveEdit/saveLiveEdit',
			'panel/live-edit/toggle-edit' 				=> 'MCtrlLiveEdit/toggleLiveEdit',
		]
	];
}

/* =====================================
	USER AUTH (LOGIN/LOGOUT)
================================================================================================================ */
$panel['modules']['USER_AUTH'] 	= [	
	'urlKey'				=> 'user-auth',		
	'moduleDir'			=> 'modules/user_auth/',
	'routes'				=> [
		'panel/user-auth/login'	 => 'MCtrlUserAuth/processLogin',
		'panel/user-auth/logout' => 'MCtrlUserAuth/processLogout'
	]
];

/* =====================================
	OPERATIONS
================================================================================================================ */
$panel['modules']['OPERATIONS'] 	= [	
	'urlKey'				=> 'operations',		
	'moduleDir'			=> 'modules/operations/',
	'routes'				=> [
		'panel/operations/upload-image'					=> 'MCtrlOperations/uploadImage',
		'panel/operations/push-toggle/(:any)' 	=> 'MCtrlOperations/pushToggle/$1',
		'panel/operations/push-update/(:any)' 	=> 'MCtrlOperations/pushUpdate/$1',
		'panel/operations/push-delete/(:any)' 	=> 'MCtrlOperations/pushDelete/$1',
	]
];

/* =====================================
	LANGUAGE
================================================================================================================ */
$panel['modules']['LANGUAGE']	= [	
	'urlKey'				=> 'language',		
	'moduleDir'			=> 'modules/language/',
	'routes'				=> [ /* Hard-coded route defined in config/routes (F/E) */ ]
];

?>