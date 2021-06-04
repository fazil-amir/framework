<?php				
class MCtrlBlockCMS extends CI_Controller {
	
	private $_bannerImage;
	private $_assets;

	public function __construct() {
		parent::__construct();
		$this -> render -> fromModule();
		$this -> _bannerImage = baseURL('modules/block_cms/assets/intro_banner.jpg');	
		$this -> _assets = 'modules/block_cms/assets/';
		$this -> load -> library('../../modules/operations/library/operations');
		$this -> updateCategoryCount();
	}

	// /* =====================================
	// 	POSTS	
	// ================================================================================================================ */
	public function posts(){
		$data = [
			'headline'			=> 'CMS Pages',
			'page'					=> $this -> getPage(),
		];
		$this -> render -> setMeta([
			'title' 		=> 'Your Posts',
			'pageID'		=> 'block_cms_posts'
		])		
		-> setActivePage(			
			'nav-link-block-cms'
		)
		-> addStyle([
			'https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.2/css/bootstrap-select.min.css',
		])
		-> addScript([
			'https://netdna.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.js',
			'//cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.6.3/js/bootstrap-select.min.js',
			'https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js',
			baseURL('engine/includes/tables/pagination.js'),
			baseURL('engine/includes/tables/table_sorter.min.js'),
			baseURL($this -> _assets . 'block-cms.min.js'),			
		])
		-> renderView(			
			$data,
			'lay_dashboard_default',
			[	
				'views/m_view_block_cms_posts'
			]
		);
	}

	// /* =====================================
	// 	POST ADD/UPDATE VIEW	
	// ================================================================================================================ */
	public function postView($postID = ''){
		$data = [
			'headline'					=> 'CMS',
			'defaultBanner' 		=> $this -> _bannerImage, 
			'pageID'						=> $postID ? $postID : 'POST_ID_' .  date('ymdhis'),
			'categories'				=> $this -> getCategory(),
			'page'							=> $postID ? $this -> getPage($postID)[0] : [],
			'pageType'					=> $this -> _getAccessorName()
		];
		
		$this -> render -> setMeta([
			'title' 		=> 'CMS Pages',
			'pageID'		=> 'block_cms_add_post_view'
		])		
		-> setActivePage(			
			'nav-link-block-cms'
		)
		-> addStyle([
			'//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css',
			baseURL('engine/includes/codemirror/codemirror.css'),
			baseURL('engine/includes/codemirror/theme.css'),
			'https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.8/summernote.css',
			'https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.2/css/bootstrap-select.min.css',
			baseURL($this -> _assets . 'block-cms.css'),
		])
		-> addScript([
			'https://netdna.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.js',
			'https://code.jquery.com/ui/1.12.1/jquery-ui.js',
			'https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.8/summernote.js',
			'//cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.6.3/js/bootstrap-select.min.js',
			baseURL('engine/includes/codemirror/codemirror.js'),
			baseURL('engine/includes/codemirror/htmlmixed.js'),
			baseURL('engine/includes/codemirror/xml.js'),
			baseURL('engine/includes/codemirror/css.js'),
			baseURL('engine/includes/codemirror/autorefresh.js'),
			baseURL($this -> _assets . 'block-cms.min.js'),
		])
		-> renderView(			
			$data,
			'lay_dashboard_default',
			[	
				'views/m_view_block_cms'
			]
		);

	}

	// /* =====================================
	// 	POST ADD/UPDATE TO DB	
	// ================================================================================================================ */
	public function postAdd($postID) {
		$data 				= $this -> input -> post()['data'][0];
		$oldPost  		= $this -> getPage($postID);			
		$operation 		= count($oldPost) >= 1 ? 'UPDATE' : 'INSERT';
		$this -> load -> helper('file');

		if($this -> _isPostURLAvailable($postID, URLTitle($data['metaData']['seoURI']))) {
			echo json_encode([
				'operation'	 	=> $operation,
				'message'	 		=> 'SEO URI already exists. Please Try something else', 
				'success' 	 	=> false,
			]);
			die();
		}

		$dir 			= 'uploads/block_cms/posts/' . URLTitle($postID) . '/'; 
		$richTextJSON = 'rich_data.json';
		$imageGalleryDir = $dir . 'gallery';
		createDirectory($dir);
		createDirectory($imageGalleryDir);

		// Banner
		$bannerImage 	= '';
		$bannerImage 	= $data['richData'][0]['PAGE_BANNER']['background'];
		$fileName = explode('/', $bannerImage);
		$fileName = end($fileName);
		if(strpos($fileName, 'intro_banner') !== 0) {
			copyFile($bannerImage, $dir.'/'.$fileName);
			$bannerImage = baseURL($dir . '/' . $fileName);
		} else {
			$bannerImage = $data['richData'][0]['PAGE_BANNER']['background'];
		}

		// Gallery
		$galleryImages = [];
		if (isset($data['imageGallery'])){
			foreach($data['imageGallery'] as $imageURL) {
				$galleryImg = explode('/', $imageURL);
				$galleryImg = end($galleryImg);
				copyFile($imageURL, $imageGalleryDir.'/'.$galleryImg);
				array_push($galleryImages, baseURL($imageGalleryDir . '/' . $galleryImg));
			}
		}
		
		// Create RichText JSON data with new image url in page banner.
		$data['richData'][0]['PAGE_BANNER']['background'] = $bannerImage;
		createJSON($dir . $richTextJSON, json_encode($data['richData']));

		$categories = isset($data['metaData']['categories']) 	? implode(',', $data['metaData']['categories']) : "Others";
		$authors 		= isset($data['metaData']['pageAuthor']) ? implode(',', $data['metaData']['pageAuthor']) : "Admin";

		$tableData = [
			'page_id' 							=> $postID,
			'page_type'							=> $data['metaData']['pageType'],
			'title'									=> $data['metaData']['pageTitle'],
			'caption'									=> $data['metaData']['pageCaption'],
			'short_description'			=> $data['metaData']['shortDescription'],
			'categories'						=> $categories,
			'language'							=> isset($data['metaData']['language']) ? $data['metaData']['language'] : $this -> language -> getDefaultLanguage(),
			'author'								=> $authors,
			'directory'							=> $dir,
			'rich_data_name'				=> $richTextJSON,
			'gallery_images'				=> json_encode($galleryImages),
			'seo_title'							=> $data['metaData']['seoTitle'],
			'seo_keywords'					=> $data['metaData']['seoKeywords'],
			'seo_description'				=> $data['metaData']['seoDescription'],
			'seo_uri'								=> URLTitle($data['metaData']['seoURI']),
			'featured'							=> $data['metaData']['featured'] 	== 'on' ? 1 : 0,
			'visibility' 						=> $data['metaData']['visibility'] 	== 'on' ? 1 : 0,
			'added_by'							=> $this  -> user_management -> getFullName(),
			'added_on'							=> date('Y-m-d H:i:s'),
			'last_modified'					=> $operation == 'UPDATE' ? $oldPost[0]['last_modified'] : date('Y-m-d H:i:s'),
		];
		$this -> db -> replace('m_block_cms_post', $tableData);
		$this -> updateCategoryCount();

		echo json_encode([
			'operation'	 	=> $operation,
			'message'	 		=> $operation == 'INSERT' ? 'CMS content added successfully' : 'CMS content updated successfully', 
			'data' 		 		=> [
				'postID'		=> 'POST_ID_' . date('ymdhis')
			],
			'success' 	 	=> 1,
		]);
	}

	// /* =====================================
	// 	GET POSTS	
	// ================================================================================================================ */
	public function getPage($postID = null, $featured = null, $visibility = null) {
		if (isset($postID)) {
			$this -> db -> where(['page_id' => $postID]);
		}
		if (isset($featured)) {
			$this -> db -> where(['featured' => $featured]);
		}
		if (isset($visibility)) {
			$this -> db -> where(['visibility' => $visibility]);
		}
		$result = $this -> db -> select('*') 
								 -> from('m_block_cms_post') 
								 -> where(['trashed' => 0]) 
								 -> order_by('pr_id', 'DESC') 
								 -> get() 
								 -> result_array();
		
		foreach($result as $key => $currentPost) {
			$htmlData = $currentPost['directory'] . $currentPost['rich_data_name'];
			$result[$key]['page_data'] = json_decode(file_get_contents($htmlData), true);
				$categories	 			= explode(',', $currentPost['categories']);
				$combinedCategory = [];
				foreach($categories	as $key2 => $currentCat) {
					$combinedCategory[$key2] = $this -> getCategory($currentCat)[0];
				}
				$result[$key]['categories'] = $combinedCategory;
		}

		return $result;

	}

	// /* =====================================
	// 	CATEGORIES	
	// ================================================================================================================ */
	public function categories(){
		$data = [
			'headline'			=> 'Listed Categories',
			'categories'		=> $this -> getCategory(),
		];
		$this -> render -> setMeta([
			'title' 		=> 'Listed Categories',
			'pageID'		=> 'block_cms_categories'
		])		
		-> setActivePage(			
			'nav-link-block-cms'
		)
		-> addStyle([
			'https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.2/css/bootstrap-select.min.css',
		])
		-> addScript([
			'https://netdna.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.js',
			'//cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.6.3/js/bootstrap-select.min.js',
			'https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js',
			baseURL('engine/includes/tables/pagination.js'),
			baseURL('engine/includes/tables/table_sorter.min.js'),
			baseURL($this -> _assets . 'block-cms.min.js'),			
		])
		-> renderView(			
			$data,
			'lay_dashboard_default',
			[	
				'/views/m_view_block_cms_categories'
			]
		);
	}

	// /* =====================================
	// 	CATEGORY ADD VIEW	
	// ================================================================================================================ */
	public function categoryView($catID = ''){
		$data = [
			'headline'				=> $catID ? 'Update CMS Category' : 'Add CMS Category',
			'defaultBanner' 	=> baseURL($this -> _bannerImage), 
			'catID'						=> $catID ? $catID : 'CAT_ID_' .  date('ymdhis'),
			'category'				=> $catID ? $this -> getCategory($catID, true)[0] : null,
		];
		
		$this -> render -> setMeta([
			'title' 		=> $catID ? 'Update CMS Category' : 'Add CMS Category',
			'pageID'		=> 'block_cms_add_category_view'
		])		
		-> setActivePage(			
			'nav-link-block-cms'
		)
		-> addStyle([
			'https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.2/css/bootstrap-select.min.css',
		])
		-> addScript([
			'https://netdna.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.js',
			'//cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.6.3/js/bootstrap-select.min.js',
			baseURL($this -> _assets . 'block-cms.min.js'),
			
		])
		-> renderView(			
			$data,
			'lay_dashboard_default',
			[	
				'views/m_view_block_cms_category'
			]
		);
	}

	// /* =====================================
	// 	CATEGORY ADD TO DB	
	// ================================================================================================================ */
	public function categoryAdd($catID = '') {
		$operation 	= (count($this -> getCategory($catID) ) > 0) ? 'UPDATE' : 'INSERT';
		if($this -> _isCategoryURLAvailable($catID, URLTitle($this -> input -> post('seo-uri')))) {
			echo json_encode([
				'operation'	 	=> $operation,
				'message'	 		=> 'SEO URI already exists. Please Try something else', 
				'success' 	 	=> false,
			]);
			die();
		}
		
		$this -> load -> helper('file');
		$tableName = 'm_block_cms_categories';


		$dir = 'uploads/block_cms/categories/' . URLTitle($catID); 
		createDirectory($dir);
		$bannerImage = json_decode($this -> input -> post('banner-image'), true)[0][0];
		$fileName = explode('/', $bannerImage);
		$fileName = end($fileName);
		copyFile($bannerImage, $dir.'/'.$fileName);
		
		$bannerImage = baseURL($dir . '/' . $fileName);

		$attributes = [
			'cat_id' 						=> $catID,
			'cat_name' 					=> $this -> input -> post('category-name'),
			'language' 					=> $this -> input -> post('language') ? $this -> input -> post('language') : $this -> language -> getDefaultLanguage(),
			'banner_image'			=> $bannerImage,
			'headline' 					=> $this -> input -> post('headline'),
			'child_count' 			=> $this -> input -> post('child_count') || 0,
			'seo_title'					=> $this -> input -> post('seo-title'),
			'seo_keyword' 			=> $this -> input -> post('seo-keywords'),
			'seo_description' 	=> $this -> input -> post('seo-description'),
			'seo_uri' 					=> URLTitle($this -> input -> post('seo-uri')),
			'featured'					=> $this -> input -> post('featured') 	== 'on' ? 1 : 0,
			'visibility' 				=> $this -> input -> post('visibility') 	== 'on' ? 1 : 0,
			'added_on' 					=> date('Y-m-d H:i:s'),
			'added_by' 					=> $this -> user_management -> getFullName(),
			'trashed' 					=> 0,
		];

		$res =  $this -> db -> replace($tableName, $attributes);
		
		if ($res) {
			$data = [
				'data' 		=> [
					'catID'	=> 'CAT_ID_' . date('ymdhis')
				],
				'message' 	=> $operation === 'INSERT' ? 'CMS category added successfully' : 'CMS category updated successfully',
				'operation'	=> $operation,
				'success'	=> 1,				
			];
		} else {
			$data = [
				'data' 		=> [
					'catID'	=> 'CAT_ID_' . date('ymdhis')
				],
				'message' 	=> $operation === 'INSERT' ? 'Something went wrong while inserting the category' : 'Something went wrong while updating the category',
				'operation'	=> $operation,
				'success'	=> 0,
			];
		}
		echo json_encode($data);
	}

	// /* =====================================
	// 	GET CATEGORIES	
	// ================================================================================================================ */
	public function getCategory($catID = '', $full = false) {
		if($catID) {
			$this -> db -> where(['cat_id' => $catID]);
		}
		if ($full){
			$select = '*';
		} else {
			$select = 'pr_id, cat_id, cat_name, child_count, headline, language, featured, visibility, added_by, added_on';
		}
		return $this -> db  -> select($select)
								   -> from('m_block_cms_categories')
								   -> where(['trashed' => 0])
								   -> order_by('pr_id', 'DESC')
								   -> get()
		               -> result_array();
	}

	private function updateCategoryCount() {
		$this -> operations -> updateParentCountByString(
			'm_block_cms_categories',
			'cat_id', // main key
			'child_count', // holds count
			'm_block_cms_post', 
			'categories'
		);
	}

	public function defaults($attrs = '') {
		if ($attrs) {
			if (isset($attrs['IMAGES'])) {
				if (isset($attrs['IMAGES']['INTRO_BANNER'])) {
					$this -> _bannerImage = $attrs['IMAGES']['INTRO_BANNER'];
				}
			}
		}
	}

	private function _getAccessorName() {
		require 'maps/panel.php';
		if(isset($panel['load']['BLOCK_CMS']['accessorName'])) {
			if(count($panel['load']['BLOCK_CMS']['accessorName'])) {
				return $panel['load']['BLOCK_CMS']['accessorName'];
			}
		}
		return ['STATIC_PAGE', 'BLOG_POST', 'DYNAMIC_PAGE', 'OTHER_PAGE'];
	}
	
	private function _isPostURLAvailable($pageID, $seoURL) {
    $count = $this  -> db -> select('page_id, seo_uri') 
                  -> from('m_block_cms_post') 
                  -> where([
                    'trashed'     => 0,
                    'page_id !='     => $pageID,
                    'seo_uri'  => $seoURL
                  ])
                  -> get() 
									-> result_array();
		return count($count);
	}

	private function _isCategoryURLAvailable($catID, $seoURL) {
    $count = $this  -> db -> select('cat_id, seo_uri') 
                  -> from('m_block_cms_categories') 
                  -> where([
                    'trashed'     => 0,
                    'cat_id !='   => $catID,
                    'seo_uri' 		=> $seoURL
                  ])
                  -> get() 
									-> result_array();
		return count($count);
	}

}