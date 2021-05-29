<?php
require 'maps/panel.php';

/* ---------------------------	
	BACKGROUND		
------------------------------------------------------------------------------------------------------- */
$colorBackground		= (isset($panelColors['colorBackground']) 	?  $panelColors['colorBackground'] 	: '#fafafa');
$colorEmailBody			= (isset($panelColors['colorEmailBody']) 	?  $panelColors['colorEmailBody'] 	: '#ffffff');
$colorEmailBorder		= (isset($panelColors['colorEmailBorder']) 	?  $panelColors['colorEmailBorder'] : '#f4f4f4');

/* ---------------------------	
	TYPOGRAPHY		
------------------------------------------------------------------------------------------------------- */
$colorPrimary			= (isset($panelColors['colorPrimary']) 		?  $panelColors['colorPrimary'] 	: '#484848');
$colorSecondary		= (isset($panelColors['colorSecondary']) 	?  $panelColors['colorSecondary'] 	: '#8BC34A');
$colorTertiary 		= (isset($panelColors['colorSecondary']) 	?  $panelColors['colorSecondary'] 	: '#4b626d');

/* ---------------------------	
	FONT FAMILY		
------------------------------------------------------------------------------------------------------- */
$fontPrimary			= "'Open Sans', 'Arial', 'sans-serif'";