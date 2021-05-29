<?php
$route['home'] = 'CtrlFrontend/homeView';
$route['about-us'] = 'CtrlFrontend/aboutUsView';
$route['contact-us'] = 'CtrlFrontend/contactUsView';
$route['page-not-found'] = 'CtrlFrontend/pageNotFoundView';

// Services
$route['service/(:any)/(:any)']	 = 'CtrlFrontend/showBlockCMSPageView/$1/$2';
$route['page/(:any)']	 = 'CtrlFrontend/showBlockCMSPageView/$1/$1';

