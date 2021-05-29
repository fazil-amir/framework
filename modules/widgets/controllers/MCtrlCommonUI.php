<?php				
include 'modules/widgets/controllers/MCtrlWidget.php';

class MCtrlCommonUI extends MCtrlWidget {
  
  public function __construct() {
		parent::__construct();
		$this -> WIDGET_TYPE = 'COMMON_UI';
    $this -> render -> fromModule();
		$this -> _widgetDir = 'modules/widgets/assets/';
    $this -> _assets = $this -> _widgetDir . 'common-ui/';
		$this -> load -> library('../../modules/operations/library/operations');
  }
  
  public function commonUIAddView($widgetID = null) {
    $data = [
			'headline'					=> 'Common UI',
			'widgetType'				=> $this -> WIDGET_TYPE,
			'widgetAccessor'		=> $this -> getAvailableAccessorNames($this -> WIDGET_TYPE),
			'widgetID'				  => $widgetID ? $widgetID : $this -> getWidgetID(),
			'widgetData'				=> $widgetID ? $this -> getWidgetData($widgetID, $this -> WIDGET_TYPE)[0] : []
		];

		$this -> render -> setMeta([
			'title' 		=> 'Widget - Add Common UI',
			'pageID'		=> 'widget_custom_key_value_add_view'
		])		
		-> setActivePage(			
			'nav-link-widgets'
		)
		-> addStyle([
			'https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.2/css/bootstrap-select.min.css',
			baseURL($this -> _assets . 'widget-common-ui.css')
		])
		-> addScript([
			'https://netdna.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.js',
			'https://code.jquery.com/ui/1.12.1/jquery-ui.js',
			'//cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.6.3/js/bootstrap-select.min.js',
			baseURL($this -> _widgetDir . 'widget.min.js'),
			baseURL($this -> _assets . 'widget-common-ui.min.js')
		])
		-> renderView(			
			$data,
			'lay_dashboard_default',
			[	
				'views/m_view_custom_key_value_add'
			]
		);
	}
	
	public function commonUIAdd($widgetID) {
		$content = trim(file_get_contents("php://input"));
		$content = json_decode($content, true);

		$this -> saveWidget(
			$this -> WIDGET_TYPE,  
			$widgetID,
			$content['common'], 
			$content['specific'],
			['icon', 'bg']
		);
	}

}