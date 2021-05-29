<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CtrlFrontend extends CI_Controller {
	
	public function homeView() {
		$data = [];
		$this -> render -> setMeta([
			'title' 					=> 'Welcome to Super FM',
			'keywords' 				=> 'keywords, keywords, keywords, ',
			'description' 		=> 'Description goes here',
			'pageID'					=> 'home'
		]) 
		-> setActivePage(			
			'nav-link-home'
		) 
		-> renderView(
			$data,
			'lay_frontend_default',
			[	
				'views/view_home',
			]
		);
	}
	
	public function showBlockCMSPageView($catName = '', $pageURL) {
		$pageData = $this -> block_cms -> getFullPage($pageURL);
		if(!count($pageData)) {
			redirect('page-not-found');
		}
		$bannerData = [
			'backgroundImg' => $pageData['page_data'][0]['PAGE_BANNER']['background'],
			'headline'			=> $pageData['page_data'][0]['PAGE_BANNER']['headline'],
			'subHeadline'		=> $pageData['page_data'][0]['PAGE_BANNER']['subHeadline'],
		];
		$data = [
			'pageData'    => $pageData,
			'bannerData'	=> $bannerData
		];

		$this -> render -> setMeta([
			'title' 					=> $pageData['seo_title'],
			'keywords' 				=> $pageData['seo_keywords'],
			'description' 		=> $pageData['seo_description'],
			'pageID'					=> 'show-service-page'
		])
		-> renderView(
			$data,
			'lay_frontend_default',
			[	
				'elements/elem_common_page_banner',
				'views/view_block_cms_page',
			]
		);
	}

	public function aboutUsView() {
		$bannerData = [
			'backgroundImg' => baseURL('includes/images/about.jpg'),
			'headline'			=> 'About Us',
			'subHeadline'		=> 'Don\'t worry, you are in the best hands',
		];
		$data = [
			'bannerData'	=> $bannerData
		];

		$this -> render -> setMeta([
			'title' 					=> 'About - Super FM',
			'keywords' 				=> 'super fm, best facility management service in UAE, best cleaning company in UAE, cleaning service uae, abu dhabi cleaning company',
			'description' 		=> 'page description',
			'pageID'					=> 'about-us-page'
		])
		-> renderView(
			$data,
			'lay_frontend_default',
			[	
				'elements/elem_common_page_banner',
				'views/view_about_us',
			]
		);
	}

	public function contactUsView() {
		$bannerData = [
			'backgroundImg' => baseURL('includes/images/about.jpg'),
			'headline'			=> 'Contact Us',
			'subHeadline'		=> 'Don\'t worry, you are in the best hands',
		];
		$data = [
			'bannerData'	=> $bannerData
		];

		$this -> render -> setMeta([
			'title' 					=> 'Contact Us - Super FM',
			'keywords' 				=> 'super fm, best facility management service in UAE, best cleaning company in UAE, cleaning service uae, abu dhabi cleaning company',
			'description' 		=> 'page description',
			'pageID'					=> 'contact-us-page'
		])
		-> renderView(
			$data,
			'lay_frontend_default',
			[	
				'elements/elem_common_page_banner',
				'views/view_contact_us',
			]
		);
	}

	public function pageNotFoundView() {
		$data = [];
		$this -> render -> setMeta([
			'title' 					=> 'Page Not Found',
			'pageID'					=> 'contact-us-page'
		])
		-> renderView(
			$data,
			'lay_frontend_default',
			[	
				'views/view_page_not_found',
			]
		);
	}

}
