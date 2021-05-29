<?php 

class MCtrlWidget extends CI_Controller {

  public function __construct() {
    parent::__construct();
    $this -> render -> fromModule();
    $this -> _assets = 'modules/widgets/assets/';
    $this -> load -> helper('file');
  }

  public function getWidgetID(){
    return 'WID_ID_' .  date('ymdhis');
  }

  public function getAvailableAccessorNames($widgetType) {
    $widgetInfo = $this -> getWidgetConfig($widgetType);
    return $widgetInfo['accessorName'];
  }

  public function showAllWidgetView($widgetType = '') {
    $oriWidType = $widgetType;

    if(!isset($widgetType)) {
      return null;
    }

    if(isset($_GET['caption'])) {
      $oriWidType = $widgetType;
      $widgetType = ucwords($_GET['caption']);
    }

    $title = 'Widgets - ' . str_replace('_', ' ', strtolower($widgetType));
    $data = [
			'headline'					=> $title,
			'widgetType'				=> $widgetType,
			'widgetData'				=> $this -> getWidgetData(null, $oriWidType)
    ];

		$this -> render -> setMeta([
			'title' 		=> $title,
			'pageID'		=> 'widget_view_all_view'
		])		
		-> setActivePage(			
			'nav-link-widgets'
		)
		-> addStyle([
		])
		-> addScript([
      'https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js',
			baseURL('engine/includes/tables/pagination.js'),
			baseURL('engine/includes/tables/table_sorter.min.js'),
			baseURL($this -> _assets . 'widget.min.js'),
		])
		-> renderView(			
			$data,
			'lay_dashboard_default',
			[	
				'views/m_view_show_all_widget_data'
			]
    );
  }

  public function saveWidget($widgetType, $widgetID, $common, $specific, $assets = []) {
    $old = $this -> getWidgetData($widgetID, $widgetType);
    
    $dir = 'includes/uploads/widgets/' . URLTitle(strtolower($widgetType)) . '/' . URLTitle($widgetID) . '/'; 
    createDirectory($dir);
    $richDataFile = 'rich_data.json';
    $specific = $this -> moveAssetsFromTemp($dir, $specific, $assets);
    createJSON($dir . $richDataFile, json_encode($specific));
    
    if($this -> isAccessorNameAlreadyAdded($common['accessor_name'], $widgetID, $widgetType)) {
      $this -> sendJSON([
        'success' => false,
        'error'   => true,
        'message' => 'The accessor name is already defined'
      ]);
    }

    $tableData = [
			'widget_id' 						=> $widgetID,
			'widget_type' 					=> $widgetType,
      'accessor_name'					=> $common['accessor_name'],
			'language'							=> isset($common['language']) ? $common['language'] : $this -> language -> getDefaultLanguage(),
			'directory'							=> $dir,
			'rich_data_name'				=> $richDataFile,
			'featured'							=> $common['featured'] 	== 'on' ? 1 : 0,
			'visibility' 						=> $common['visibility'] 	== 'on' ? 1 : 0,
      'added_by'							=> $this  -> user_management -> getFullName(),
      'added_on'              => count($old) ? $old[0]['added_on'] : date('Y-m-d H:i:s')
    ];
    $this -> db -> replace('m_widgets', $tableData);
    
    $this -> sendJSON([
      'success' => true,
      'error'   => false,
      'message' => 'Widget data saved'
    ]);
  }

  public function moveAssetsFromTemp($dir, $specific, $assets) {
    foreach($specific as $key1 => $row) {
      foreach($assets as $asset) {
        if($row[$asset] !== '') {
          $fileName = explode('/', $row[$asset]);
          $fileName = end($fileName);
          $fileName = $dir . $fileName;
          copyFile($row[$asset], $fileName);
          $specific[$key1][$asset] = baseURL($fileName);
        } 
      }
    }
    return $specific;
  }

  public function isAccessorNameAlreadyAdded($accessorName, $widgetID, $widgetType) {
    $count = $this  -> db -> select('widget_id, accessor_name') 
                  -> from('m_widgets') 
                  -> where([
                    'trashed'         => 0,
                    'widget_type'     => $widgetType,
                    'widget_id !='    => $widgetID,
                    'accessor_name'   => $accessorName
                  ])
                  -> get() 
                  -> result_array();

    return $count;
  }

  public function getWidgetData($widgetID = false, $widgetType = false) {
    if (isset($widgetID)) {
			$this -> db -> where(['widget_id' => $widgetID]);
    }
    if (isset($widgetType)) {
			$this -> db -> where(['widget_type' => $widgetType]);
    }
    return $this  -> db -> select('*') 
                  -> from('m_widgets') 
                  -> where(['trashed' => 0]) 
                  -> order_by('pr_id', 'DESC') 
                  -> get() 
                  -> result_array();
                 
  }

  public function getWidgetConfig($widgetType) {
    require 'maps/panel.php';
    return $panel['load']['WIDGETS'][$widgetType];
  }

}