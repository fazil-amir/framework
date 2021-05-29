<div class='absolute-header-btn-wrapper'>
	<?php
		$addLink = '';
		$viewLink = '';
		if(isset($_GET['viewLink'])) {
			$viewLink .= '?viewLink=' . $_GET['viewLink'];
		}
		if(isset($_GET['addLink'])) {
			$addLink = '&addLink=' .$_GET['addLink'];
		}
	?>
	<a class='btn btn-info' href='<?php echo baseURL('panel/widgets/show-all/' . $data['widgetType'] . $viewLink . $addLink); ?>'>View All</a>
</div>