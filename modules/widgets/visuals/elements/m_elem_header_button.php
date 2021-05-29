<div class='absolute-header-btn-wrapper'>
	<?php 
		$backLink = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' 
			? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
	?>
	<a class='btn btn-info' href='<?php echo baseURL('panel/widgets/show-all/' . $data['widgetType'] . '?addLink=' . $backLink); ?>'>View All</a>
</div>