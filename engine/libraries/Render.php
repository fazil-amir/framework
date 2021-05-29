<?php
defined('BASEPATH') OR exit('No direct script access allowed');
include SYSDIR . '/simple_html_dom/simple_html_dom.php';

class CI_Render {
	
	private $title;
	private $keywords;
	private $description;

	private $scripts;
	private $setScriptOnHead;
	private $links;

	private $pageID;

	private $activePageNavClass;
	
	private $_isPanel;

	private $_isModule = false;

	private $_ci;

	public function __construct() {		
		$this -> _ci = &get_instance();
		$this -> _isPanel = strpos($_SERVER['REQUEST_URI'], 'panel') ? true : false; 
	}

	public function setMeta($attributes){
		if(isset($attributes['title'])) {
			$this -> title 			= '<title>' . $attributes["title"] . '</title>';
		}
		if(isset($attributes['keywords'])) {
			$this -> keywords 		= '<meta name="keywords" content="' . $attributes['keywords'] . '">';
		}
		if(isset($attributes['description'])){
			$this -> description 	= '<meta name="description" content="' . $attributes['description'] . '">';
		}
		if(isset($attributes['pageID'])) {
			$this -> pageID 		= $attributes["pageID"];
		}
		return $this;
	}

	public function setActivePage($activePageNavID) {
		$this -> activePageNavID = $activePageNavID;
		return $this;
	}

	public function addScript($scripts, $onHead = FALSE){
		$this -> scripts = $scripts;
		if($onHead) {
			$this -> setScriptOnHead = TRUE;
		} else {
			$this -> setScriptOnHead = FALSE;
		}
		return $this;
	}

	public function addStyle($links){
		$this -> links = $links;
		return $this;
	}

	public function fromModule() {
		$this -> _isModule = true;
		return $this;
	}

	public function renderView($viewData, $loadLayout, $loadElements = []) {
		$data = [			
			'views'		=> [],
			'data'		=> $viewData
		];
		$this -> ci = & get_instance();
		if(count($loadElements)) {
			foreach($loadElements as $key => $views) {			
				array_push($data['views'], VIEWPATH . $loadElements[$key] . '.php');
			}
		}

		if ($this -> _isModule) {
			$view = $this -> ci -> load -> view('../../../dashboard/visuals/layouts/' . $loadLayout, $data, TRUE);
		} else {
			$view = $this -> ci -> load -> view('layouts/' . $loadLayout , $data, TRUE);
		}
	
		$DOM = new simple_html_dom($view);
		$DOM -> load($view);
		$this -> _setMeta($DOM);
		$this -> _appendJSBaseURL($DOM);
		if(isset($this -> activePageNavID)){			
			$this -> _setActivePage( $DOM );
		}
		if(isset($this -> scripts)) {
			$this -> _setScripts( $DOM );
		}
		if(isset($this -> links)) {
			$this -> _setStyles( $DOM );
		}
		// Is frontend and admin starts editing
		if( $this -> _isPanel == false && $this -> _ci -> session -> hasSession('live-edit') ) {
			$this -> _initLiveEdit($DOM);
		} 

		// check of session and set active or remove active
		if( $this -> _isPanel && $this -> _checkFeature('LIVE_EDIT') ) {
			if($this -> _ci -> session -> hasSession('live-edit')){				
				$elem = $DOM -> find('[id=toggle-live-edit]', 0);
				$elem -> class .= ' active ';		
				$elem -> innertext = 'Disable Live Edit';		
			}
		}
		
		$this -> _renderLiveEdit($DOM);
		
		$DOM -> save();
		echo $DOM;
		return $this;

	}

	private function _appendJSBaseURL( &$DOM ){
		require 'maps/application.php';
		$script = '	<script>			
						function baseURL(uri) {
							if(uri === "") {
								return "' . $application['NOW']['appDir'] .'";								
							} else {
								return "' . $application['NOW']['appDir'] .'" + uri;								
							}
						}
					</script>';
		$DOM -> find('head', 0) -> innertext	= $DOM -> find('head', 0) -> innertext . $script;
	}

	private function _setActivePage( &$DOM ){
		$elem;
		$elem = $DOM -> find('[id=' . $this -> activePageNavID . ']', 0);
		if($elem){		
			$elem -> class ='active';		
		}
	}

	private function _setMeta(&$DOM){
		$DOM -> find('head', 0) -> innertext  = $DOM -> find('head', 0) -> innertext . $this -> title . $this -> keywords . $this -> description;
		$DOM -> find('main', 0) -> id 					= 'document';
		$DOM -> find('main', 0) -> class 				= 'document ' . $this -> pageID;
		$DOM -> find('main', 0) -> {'data-page-name'} 	= strtoupper($this -> pageID);
		$DOM -> save();
	}

	private function _setStyles( &$DOM ){
		$appendLinks = '';
		foreach($this -> links as $key => $link) {				
			$appendLinks 		.= '<link rel="stylesheet" href="' . $link . '" type="text/css"  />';			
		}
		$DOM -> find('head', 0) -> innertext .= $appendLinks;
		$DOM -> save();
	}

	private function _setScripts( &$DOM ){
		$appendScript = '';
		foreach ($this -> scripts as $key => $script) {
			$appendScript 		.= '<script src="' . $script . '"></script>';
		}
		if( $this -> setScriptOnHead === TRUE){
			$content = $DOM -> find('head', 0) -> innertext;
			$DOM -> find('head', 0) -> innertext = $content . $appendScript;		
		} else {
			$DOM -> find('js', 0) -> innertext = $appendScript;		
		}
		$DOM -> save();
	}

	private function _initLiveEdit( &$DOM ) {
		$DOM -> find('main', 0) -> {'data-live-edit'} = 'true';
		$style = '<link href="' . baseURL("modules/live_edit/assets/live-edit.css") . '" rel="stylesheet" type="text/css"/>';
		$DOM -> find('head', 0) -> innertext .= $style;
		$script = '<script src="' . baseURL("modules/live_edit/assets/live-edit.min.js") . '" ></script>';
		$DOM -> find('js', 0) -> innertext .= $script;
		$DOM -> save();
	}

	private function _renderLiveEdit( &$DOM ) {
		if($this -> _checkFeature('LIVE_EDIT')) {
			$this -> _ci -> load -> library('../../modules/language/library/Language');
			$language = $this -> _ci -> language -> getDefaultLanguage();
			$rows   = $this -> _ci -> db -> select('element_id, element_data')
										-> where([ 'language' => $language])
										-> from('m_live_edit')
										-> order_by('added_on', 'ASC')
										-> get()
										-> result_array();
			$elems = [];
			foreach($DOM -> find('[data-live-edit-id]') as $e) {			
				$e -> getAllAttributes('data-live-edit-id');			
				$elems[] = $e -> attr;
			}		
			foreach ($rows as $key1 => $row) {
				foreach ($elems as $key2 => $elem) {
					$temp = str_replace('[' . $language. ']:', '', $row['element_id']);
					if( $elem['data-live-edit-id'] == $temp ) {
						$DOM -> find('[data-live-edit-id=' . $temp . ']', 0) -> innertext = $row['element_data'];
					}
				}
			}
		}
	}

	private function _checkFeature($feature) {
		include('maps/panel.php');
		return in_array($feature, $panel['load']);
	}

	public function prepareEmail($email, $dashboard = TRUE){
		$data['data']			= $email['data'];
		$data['data']['body'] 	= $email['body'] . '.php';
		if(strstr($_SERVER['REQUEST_URI'], 'panel')) {
			if($dashboard){
				$path 					= 'emails/' . $email['layout'];
			} else {
				$path 					= '../../engine/includes/emails/' . $email['layout'];
			}		
		} else {
			$path 					= 'emails/' . $email['layout'];
		}
		return $this -> _ci -> load -> view($path, $data, TRUE);
	}

}

?>