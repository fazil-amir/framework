<div class='absolute-header-btn-wrapper'>
	<?php
		$link = '';
		$addLink = '';
		$viewLink = '';
		if(isset($_GET['addLink'])) {
			$link = baseURL($_GET['addLink']);
			$addLink = '?addLink=' .$_GET['addLink'];
		}
		if(isset($_GET['viewLink'])) {
			$viewLink .= '&viewLink=' . $_GET['viewLink'];
		}
	?>
	<a class='btn btn-info' href='<?php echo $link . $addLink . $viewLink; ?>'>Add New</a>
</div>