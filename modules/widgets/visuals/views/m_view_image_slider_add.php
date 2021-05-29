<?php include_once ('modules/widgets/visuals/elements/m_elem_header_view_all_button.php'); ?>

<div class="tabular-section">
	<ul class="nav nav-tabs">
		<li class="nav-item">
			<a class="nav-link active" href="#meta-info">Meta Info</a>
		</li>
		<li class="nav-item"> 
			<a class="nav-link" href="#slider-data">Slider Data</a>
		</li>		
	</ul>

  <form 
		id="widget-submit" 
		method="post" 
		action="<?php echo baseURL('panel/widgets/image-slider/add-update/') . $data['widgetID'];  ?>" 
		data-source="<?php echo count($data['widgetData']) > 0 ? baseURL($data['widgetData']['directory'] . $data['widgetData']['rich_data_name']) : ''; ?>" >
		
    <div class="tab-content">

      <div class="content-wrapper active" id="meta-info">
        <?php include_once ('modules/widgets/visuals/elements/m_elem_meta_common.php'); ?>
      </div>

      <div class="content-wrapper" id="slider-data">	
				<div class='slider-input-container'>
					<div id='slider-slides' class='slider-slides'></div>
					<div class='btn-wrapper'>
						<a class='btn btn-info btn-lg' id='add-slide-btn'>Add Slide +</a>
					</div>
				</div>
			</div>

    </div>

  </form>

	<?php include_once ('modules/widgets/visuals/elements/m_elem_submit_button.php'); ?>

</div>