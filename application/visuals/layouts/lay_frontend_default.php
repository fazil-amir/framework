<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	
	<link href="https://fonts.googleapis.com/css?family=Nunito+Sans:300,400,600,700,800,900&display=swap" rel="stylesheet">
	<link rel="icon" href="<?php echo baseURL('includes/images/icon.png'); ?>" type="image/png" sizes="32x32">

	<link rel="stylesheet" href="<?php echo baseURL('includes/'); ?>css/open-iconic-bootstrap.min.css">
	<link rel="stylesheet" href="<?php echo baseURL('includes/'); ?>css/animate.css">
	
	<link rel="stylesheet" href="<?php echo baseURL('includes/'); ?>css/owl.carousel.min.css">
	<link rel="stylesheet" href="<?php echo baseURL('includes/'); ?>css/owl.theme.default.min.css">
	<link rel="stylesheet" href="<?php echo baseURL('includes/'); ?>css/magnific-popup.css">

	<link rel="stylesheet" href="<?php echo baseURL('includes/'); ?>css/aos.css">

	<link rel="stylesheet" href="<?php echo baseURL('includes/'); ?>css/ionicons.min.css">

	<link rel="stylesheet" href="<?php echo baseURL('includes/'); ?>css/flaticon.css">
	<link rel="stylesheet" href="<?php echo baseURL('includes/'); ?>css/icomoon.css">
	<link rel="stylesheet" href="<?php echo baseURL('includes/'); ?>css/style.css">
</head>
<body>

<main> 
	<?php include returnElement('elem_navigation'); ?> 
	<?php foreach ($views as $key => $view) { include_once $view; } ?>
	<?php include returnElement('elem_footer'); ?> 
</main>

<script src="<?php echo baseURL('includes/'); ?>js/jquery.min.js"></script>
<script src="<?php echo baseURL('includes/'); ?>js/jquery-migrate-3.0.1.min.js"></script>

<js></js>

<script src="<?php echo baseURL('includes/'); ?>js/popper.min.js"></script>
<script src="<?php echo baseURL('includes/'); ?>js/bootstrap.min.js"></script>
<script src="<?php echo baseURL('includes/'); ?>js/jquery.easing.1.3.js"></script>
<script src="<?php echo baseURL('includes/'); ?>js/jquery.waypoints.min.js"></script>
<script src="<?php echo baseURL('includes/'); ?>js/jquery.stellar.min.js"></script>
<script src="<?php echo baseURL('includes/'); ?>js/owl.carousel.min.js"></script>
<script src="<?php echo baseURL('includes/'); ?>js/jquery.magnific-popup.min.js"></script>
<script src="<?php echo baseURL('includes/'); ?>js/aos.js"></script>
<script src="<?php echo baseURL('includes/'); ?>js/jquery.animateNumber.min.js"></script>
<script src="<?php echo baseURL('includes/'); ?>js/scrollax.min.js"></script>
<script src="<?php echo baseURL('includes/'); ?>js/main.js"></script>

</body>
</html>