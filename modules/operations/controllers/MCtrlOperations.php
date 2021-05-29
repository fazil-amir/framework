<?php
class MCtrlOperations extends CI_Controller {
	/* =====================================
		PUSH TOGGLE	
	================================================================================================================ */
	public function pushToggle( $ID = '' ) {
		$this -> db -> where([$this -> input -> post('where') =>  $ID]);
		$this -> db -> update($this -> input -> post('directory'), [
			$this -> input -> post('attribute') => $this -> input -> post('new-value')
		]);
		$this -> sendJSON([
			'operation' => 'PUSH_UPDATE',
			'message'	=> ucwords(strtolower($this -> input -> post('attribute')) ) . ' is updated',
			'success'	=> 1,
			'data'		=> []		
		]);
	}

	/* =====================================
		PUSH UPDATE	
	================================================================================================================ */
	public function pushUpdate( $ID = '' ) {
		foreach (json_decode($this -> input -> post('attributes'), true) as $k1 => $rows) {	
			foreach ($rows as $k2 => $row) {
				$data[$k2] = $row;  
			}
		}
		$this -> db -> where([$this -> input -> post('where') =>  $ID]);
		$this -> db -> update($this -> input -> post('directory'), $data );
		$this -> sendJSON([
			'operation' => 'ROW_UPDATE',
			'message'	=> 'Row is updated',
			'success'	=> 1,
			'data'		=> []		
		]);
	}

	/* =====================================
		PUSH DELETE	
	================================================================================================================ */
	public function pushDelete($ID = '') {
		$this -> db -> where([$this -> input -> post('where') =>  $ID]);
		$this -> db -> update($this -> input -> post('directory'), ['trashed' => 1]);

		$pDirectory = $this -> input -> post('p-directory');
		$pWhere 		= $this -> input -> post('p-where');
		$pAttr 			= $this -> input -> post('p-attr');
		$pValue 		= $this -> input -> post('p-attr-value');

		if ($pDirectory !== 'undefined') {
			$pValue = explode(',', $pValue);
			foreach($pValue as $w){
				$this -> updatePostCount(
					$pDirectory,
					$pWhere,
					[$pAttr => $w]
				);
			}
		}

		$this -> sendJSON([
			'operation' => 'ROW_DELETE',
			'message'	=> 'Row deleted successfully',
			'success'	=> 1,
			'data'		=> []		
		]);
	}

	/* =====================================
		UPLOAD IMAGE	
	================================================================================================================ */
	public function uploadImage() {
		$this -> load -> helper('file');
		$dir = $this -> input -> post('directory') ? $this -> input -> post('directory') : 'includes/uploads/';
		createDirectory($dir);
		$image = uploadFile('image', $dir);
		if($image['success'] === true) {
			$this -> sendJSON([
				'operation' => 'IMAGE_UPLOAD',
				'message'		=> 'Image uploaded successfully',
				'success'		=> true,
				'fileName'	=> $image['message'],
				'url'				=> baseURL($dir . '/' . $image['message'])
			]);
		} else {
			$this -> sendJSON([
				'operation' => 'IMAGE_UPLOAD',
				'message'		=> $image['message'],
				'success'		=> $image['success']	
			]);
		}
	}

	/* =====================================
		UPDATE POST COUNT	
	================================================================================================================ */
	public function updatePostCount($tableName, $attr, $where = [], $operation = 'DEC') {
		$r = $this -> db  -> select($attr)
									-> from($tableName)
									-> where($where)
									-> get()
									-> result_array();
		if (count($r)) {
			$count = $r[0][$attr];
			if($operation === 'INC') {
				$count++;
			} else {
				$count = $count === 0 ? 0 : --$count;
			}
			$this -> db -> set($attr, $count) -> where($where) -> update($tableName);
		}
	}

}	