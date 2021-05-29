<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
class CI_Widgets {
	
	private $_ci;

	function __construct() {
		$this -> _ci =& get_instance();
	}

	public function getWidget($accessorName = null, $widgetType = null, $visibility = true) {
    if (isset($accessorName)) {
			$this -> _ci -> db -> where(['accessor_name' => $accessorName]);
    }
		
		if (isset($widgetType)) {
			$this -> _ci -> db -> where(['widget_type' => $widgetType]);
		}

		if ($visibility) {
			$this -> _ci -> db -> where(['visibility' => 1]);
		}

		$language = $this -> _ci -> language -> getDefaultLanguage();
		if (isset($language)) {
			$this -> _ci -> db -> where(['language' => $language]);
		}

    $widgets = $this  -> _ci -> db -> select('*') 
                  -> from('m_widgets') 
                  -> where(['trashed' => 0]) 
                  -> order_by('pr_id', 'DESC') 
                  -> get()
                  -> result_array();

		for($i = 0; $i < count($widgets); $i++) {
			$widget = $widgets[$i];
			$directory = $widget['directory'] . $widget['rich_data_name'];
			$richDataFile = fopen($directory, "r") or die("Unable to open file!");
			$widgets[$i]['richData'] = fread($richDataFile,filesize($directory));
			fclose($richDataFile);
		}
		if (!count($widgets)) {
			return [];
		} else {
			return count($widgets) > 1 ? $widgets : $widgets[0];					
		}
  }

}