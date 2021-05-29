<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class CtrlDashboard extends CI_Controller {
	public function __construct(){		
		parent::__construct();							
	}

	/* =====================================
		DASHBOARD	
	================================================================================================================ */
	public function dashboard() {
		$data = [
			'headline'		=> 'Dashboard'
		];
		$this -> render -> setMeta([
			'title' 		=> 'Welcome to Dashboard',
			'pageID'		=> 'dashboard'
		])		
		-> setActivePage(			
			'nav-link-dashboard'
		)
		-> renderView(			
			$data,
			'lay_dashboard_default',
			[	
				'views/view_dashboard'
			]
		);
	}
}
