<!DOCTYPE html>
<html>
<head>	
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="format-detection" content="telephone=no">
	<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="<?php echo baseURL('engine/includes/styles/dashboard-styles.css'); ?>">
	<link rel="icon" type="image/png" href="<?php echo baseURL('engine/includes/images/icon.png'); ?>">
	<META NAME="robots" CONTENT="noindex,nofollow">
</head>
<body>

<!-- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	Dynamic style sheet placeholder
- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -->
<lk></lk>  

<main>
	<div class="overlay"></div>
	<?php includeElement('elem_header'); ?>
	<div>
		<?php includeElement('elem_navigation'); ?>
		<section class="section">
			<div class="section-header">
				<h1><?php echo $data['headline']; ?></h1>
			</div>
			<div class="view-area">			
				<?php foreach ($views as $key => $view) {			
					include_once $view;
				} ?>
			</div>
			<footer class="footer">
				<p>&copy; - Dashboard</p>
				<p>Report Issues/Bugs @ - <a href="fazil.amir@outlook.com" target="_blank">fazil.amir@outlook.com</a></p>
			</footer>
		</section>
	</div>
</main>

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>


<!-- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	Dynamic JS placeholder
- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -->
<js></js>


<!-- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	Main JS
- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -->
<script type="text/javascript" src="<?php echo baseURL('engine/includes/notify/notify.min.js'); ?>"></script>
<script type="text/javascript" src="<?php echo baseURL('engine/includes/popupmodal/popupmodal-min.js'); ?>"></script>
<script type="text/javascript" src="<?php echo baseURL('engine/includes/scripts/modules.js'); ?>"></script>	
<script type="text/javascript" src="<?php echo baseURL('engine/includes/scripts/process-form.js'); ?>"></script>	
<script type="text/javascript" src="<?php echo baseURL('dashboard_assets/scripts/dashboard-interface.min.js'); ?>"></script>

<style>
    .overlay.show {  display: none!important; }
    .page-data-container>.block-container .item-wrapper-main {
        overflow-y: auto;
    }
</style>
</body>
</html>