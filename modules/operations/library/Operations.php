<?php 
class CI_Operations {
  private $_ci;

	function __construct() {
		$this -> _ci =& get_instance();	
  }
  
  public function updateParentCountByString(
    $pTableName, 
    $pkeyColumnName, 
    $countColumnName, 
    $cTableName, 
    $cColumnName, 
    $operation = '+'
  ) {

    $children  = $this -> _ci -> db -> select($cColumnName) -> from($cTableName) -> get() -> result_array();
      
    $temp1 = [];
    foreach($children as $key => $child) {
      $temp1[] = explode(',', $child[$cColumnName]);
    }

    $temp2= [];
    foreach($temp1 as $key => $arr) {
      foreach($arr as $key2) {
        if (!isset($temp2[$key2])) {
          $temp2[$key2] = 1;
        } else {
          $temp2[$key2] = $temp2[$key2] + 1;
        }
      }
    }
    
    $this -> _ci -> db -> set($countColumnName, 0) -> update($pTableName);
    foreach($temp2 as $keyColumn => $count) {
      $this -> _ci -> db 
            -> set($countColumnName, $count) 
            -> where([$pkeyColumnName => $keyColumn]) 
            -> update($pTableName);
    }

  }
}