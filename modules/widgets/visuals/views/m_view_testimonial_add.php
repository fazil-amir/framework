<?php include_once ('modules/widgets/visuals/elements/m_elem_header_view_all_button.php'); ?>

<div class="tabular-section">
	<ul class="nav nav-tabs">
		<li class="nav-item">
			<a class="nav-link active" href="#meta-info">Meta Info</a>
		</li>
		<li class="nav-item"> 
			<a class="nav-link" href="#testimonial-data">Testimonial Data</a>
		</li>		
	</ul>

  <form 
		id="widget-submit" 
		method="post" 
		action="<?php echo baseURL('panel/widgets/testimonial/add-update/') . $data['widgetID'];  ?>" 
		data-source="<?php echo count($data['widgetData']) > 0 ? baseURL($data['widgetData']['directory'] . $data['widgetData']['rich_data_name']) : ''; ?>" >
		
    <div class="tab-content">

      <div class="content-wrapper active" id="meta-info">
        <?php include_once ('modules/widgets/visuals/elements/m_elem_meta_common.php'); ?>
      </div>

      <div class="content-wrapper" id="testimonial-data">	
				<div class='testimonial-input-container'>
					<div id='testimonials' class='testimonial-items'></div>
					<div class='btn-wrapper'>
						<a class='btn btn-info btn-lg' id='add-btn'>Add Testimonial +</a>
					</div>
				</div>
			</div>

    </div>

  </form>

	<?php include_once ('modules/widgets/visuals/elements/m_elem_submit_button.php'); ?>

</div>