<div class='absolute-header-btn-wrapper'>
	<?php 
		$link = 'window.history.go(-1); return false;';
		$caption = 'Go Back';
		if(isset($_GET['addLink'])) {
			$link = $_GET['addLink'];
			$caption = 'Add New';
	}?>
	<a class='btn btn-info' href='<?php echo $link; ?>' onClick='window.history.go(-1); return false;' ><?php echo $caption; ?></a>
</div>