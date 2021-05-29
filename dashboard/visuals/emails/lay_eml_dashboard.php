<?php include 'elements/_required.php'; 	?>
<?php include 'elements/_styles.php'; 		?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
 <head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <title>Demystifying Email Design</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
	<style type="text/css">

		@import url("https://fonts.googleapis.com/css?family=Open+Sans:400,600");

		.table tr td{
			border-top: 1px solid  <?php echo $colorEmailBorder; ?>;
		}

		.table tr:nth-child(2) td,
		.table tr:last-child td {
			border: none !important;
		}

		@media(max-width: 768px){
			#container {
				width: 90% !important;
			}
		}

		@media(max-width: 660px){
			#header img{
				width: 160px !important;
				display: block !important;
				margin: auto !important;
			}
			#container {
				width: 98% !important;
			}
			#content{
				padding: 5px !important;
			}

			.button{
				width: 100% !important;
			}
		}

	</style>
</head>
<body style="margin: 0; padding: 0">

<table width="100%" align="center" style="background-color:<?php echo $colorBackground; ?>" border="0" cellpadding="0" cellspacing="0">
<tr>
<td>	

	

<table id="container" width="660px" align="center" cellpadding="0" cellspacing="0" border="0">
<tr>
<td>


<!-- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	HEADER
- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -->

<table id="header" width="100%" bgcolor="#fafafa" cellspacing="0" cellpadding="10" style="">
	<tr>
		<td height="100px">
			<a target="_blank" href="<?php echo baseURL(); ?>" style="display: inline-block;">
				<img style="height: 60px; display: inline-block;" src="<?php echo baseURL('engine/includes/images/default_logo.png'); ?>" style="display: inline-block;">
			</a>
		</td>
	</tr>
</table>




<!-- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	CONTENT
- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -->

<table id="content" width="100%" bgcolor="#ffffff" cellspacing="0" cellpadding="10" style="<?php echo $content; ?>">
	<tr>
		<td valign="top">
			
		<?php include $data['body']; ?>

		</td>
	</tr>
</table>





<!-- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	FOOTER
- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -->

<table id="footer" width="100%" bgcolor="#fafafa" cellspacing="0" cellpadding="10" style=" padding: 20px">
	<tr>
		<td height="50px">
			
		</td>
	</tr>
</table>





</td>
</tr>
</table>

</td>
</tr>
</table>
</body>

</html>