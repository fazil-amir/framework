<?php				
include 'modules/widgets/controllers/MCtrlWidget.php';

class MCtrlTestimonial extends MCtrlWidget {
  
  public function __construct() {
		parent::__construct();
		$this -> WIDGET_TYPE = 'TESTIMONIAL';
    $this -> render -> fromModule();
		$this -> _widgetDir = 'modules/widgets/assets/';
    $this -> _assets = $this -> _widgetDir . 'testimonial/';
		$this -> load -> library('../../modules/operations/library/operations');
  }
  
  public function testimonialAddView($widgetID = null) {
    $data = [
			'headline'					=> 'Testimonials',
			'widgetType'				=> $this -> WIDGET_TYPE,
			'widgetAccessor'		=> $this -> getAvailableAccessorNames($this -> WIDGET_TYPE),
			'widgetID'				  => $widgetID ? $widgetID : $this -> getWidgetID(),
			'widgetData'				=> $widgetID ? $this -> getWidgetData($widgetID, $this -> WIDGET_TYPE)[0] : []
		];

		$this -> render -> setMeta([
			'title' 		=> 'Widget - Add Testimonial',
			'pageID'		=> 'widget_testimonial_add_view'
		])		
		-> setActivePage(			
			'nav-link-widgets'
		)
		-> addStyle([
			'https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.2/css/bootstrap-select.min.css',
			baseURL($this -> _assets . 'widget-testimonial.css')
		])
		-> addScript([
			'https://netdna.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.js',
			'https://code.jquery.com/ui/1.12.1/jquery-ui.js',
			'//cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.6.3/js/bootstrap-select.min.js',
			baseURL($this -> _widgetDir . 'widget.min.js'),
			baseURL($this -> _assets . 'widget-testimonial.min.js')
		])
		-> renderView(			
			$data,
			'lay_dashboard_default',
			[	
				'views/m_view_testimonial_add'
			]
		);
	}
	
	public function testimonialAdd($widgetID) {
		$content = trim(file_get_contents("php://input"));
		$content = json_decode($content, true);

		$this -> saveWidget(
			$this -> WIDGET_TYPE,  
			$widgetID, 
			$content['common'], 
			$content['specific'],
			['photo']
		);
	}

}