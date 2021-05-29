<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
class CI_Block_cms {
	
	private $_ci;
	private $_catTableName;
	private $_postTableName;
	private $lang;

	function __construct() {
		$this -> _ci =& get_instance();
		$this -> _catTableName = 'm_block_cms_categories';
		$this -> _postTableName = 'm_block_cms_post';
		$this -> lang = $this -> _ci -> language -> getDefaultLanguage();
  }
  
  function getNavigation($pageType = null) {
		$result = [];
		foreach($pages = $this -> getPartialPage($pageType) as $key1 => $page) {
			foreach(explode(',', $page['categories']) as $key2 => $catID) {
				$result[$catID] = $this -> _getCategory($catID);
				$result[$catID]['pages'] = $this -> _getFilteredPostsByCatID($catID, $pages);
			}	
		}
		return $result;
	}

  public function getFullPage($pageURI = '', $featured = 0) {
		if($featured) {
			$this -> _ci -> db -> where([
				'featured' => $featured,
			]);
		}

		$this -> _ci -> db -> where([
			'language'	=> $this -> lang,
			'seo_uri' => $pageURI,
			'trashed' => 0,
			'visibility' => 1,
		]);

		$result = $this -> _ci -> db -> select('*') 
								 -> from($this -> _postTableName) 
								 -> order_by('pr_id', 'DESC') 
								 -> get() 
								 -> result_array();
		
		foreach($result as $key => $currentPost) {
			$htmlData = $currentPost['directory'] . $currentPost['rich_data_name'];
			$result[$key]['page_data'] = json_decode(file_get_contents($htmlData), true);
			$categories	 			= explode(',', $currentPost['categories']);
			$combinedCategory = [];
			foreach($categories	as $key2 => $currentCat) {
				$combinedCategory[$key2] = $this -> _getCategory($currentCat);
			}
			$result[$key]['categories'] = $combinedCategory;
		}
		return count($result) === 1 ? $result[0] : $result;
	}

	public function getPartialPage($pageType = null) {
		$result = [];
		if(isset($pageType)) {
			$this -> _ci -> db -> where(['page_type' => $pageType]);
		}
		$pages = $this -> _ci -> db -> select('page_id, page_type, title, caption, short_description, categories, author, seo_uri') 
			-> from($this -> _postTableName)
			-> where([
				'language'			=> $this -> lang,
				'trashed' 			=> 0,
				'visibility' 		=> 1,
			])
			-> order_by('pr_id', 'DESC')
			-> get()
			-> result_array();
		
		foreach($pages as $key => $page) {
			$result[$key] = $page;
			$result[$key]['category'] = $this -> _getCategory(
				explode(',', $page['categories'])[0]
			);
		}
		return $result;
	}
	
	private function _getCategory($catID) {
		$result =  $this -> _ci -> db -> select('cat_name, seo_uri, banner_image, child_count') 
			-> from($this -> _catTableName) 
			-> where([
				'language'			=> $this -> lang,
				'cat_id' 			=> $catID
			]) 
			-> get() 
			-> result_array();
		
			if (count($result) === 1) {
				return $result[0];
			}
			return $result;
	}

	private function _getFilteredPostsByCatID($catID, $posts) {
		$res = [];
		foreach($posts as $post) {
			foreach(explode(',', $post['categories']) as $ccatID) {
				if($catID == $ccatID) {
					$res[] = $post;
				}
			}	
		}
		return $res;
	}
	
}