<?php				
include 'modules/widgets/controllers/MCtrlWidget.php';

class MCtrlImageSlider extends MCtrlWidget {
  
  public function __construct() {
		parent::__construct();
		$this -> WIDGET_TYPE = 'IMAGE_SLIDER';
    $this -> render -> fromModule();
    $this -> _widgetDir = 'modules/widgets/assets/';
    $this -> _assets = $this -> _widgetDir . 'image-slider/';
		$this -> load -> library('../../modules/operations/library/operations');
  }
  
  public function sliderAddView($widgetID = null) {
    $data = [
			'headline'					=> 'Image Slider',
			'widgetAccessor'		=> $this -> getAvailableAccessorNames($this -> WIDGET_TYPE),
			'widgetType'				=> $this -> WIDGET_TYPE,
			'widgetID'				  => $widgetID ? $widgetID : $this -> getWidgetID(),
			'widgetData'				=> $widgetID ? $this -> getWidgetData($widgetID, $this -> WIDGET_TYPE)[0] : []
		];
		$this -> render -> setMeta([
			'title' 		=> 'Widget - Add Image Slider',
			'pageID'		=> 'widget_image_slider_add_view'
		])		
		-> setActivePage(			
			'nav-link-widgets'
		)
		-> addStyle([
			'https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.2/css/bootstrap-select.min.css',
			baseURL($this -> _assets . 'widget-image-slider.css')
		])
		-> addScript([
			'https://netdna.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.js',
			'https://code.jquery.com/ui/1.12.1/jquery-ui.js',
			'//cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.6.3/js/bootstrap-select.min.js',
			baseURL($this -> _widgetDir . 'widget.min.js'),
			baseURL($this -> _assets . 'widget-image-slider.min.js')
		])
		-> renderView(			
			$data,
			'lay_dashboard_default',
			[	
				'views/m_view_image_slider_add'
			]
		);
	}
	
	public function sliderAdd($widgetID) {
		$content = trim(file_get_contents("php://input"));
		$content = json_decode($content, true);

		$res = $this -> saveWidget(
			$this -> WIDGET_TYPE,  
			$widgetID, 
			$content['common'], 
			$content['specific'],
			['slide_image']
		);

		$this -> sendJSON($res);
	}

}