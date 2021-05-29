<?php include_once ('modules/widgets/visuals/elements/m_elem_header_add_new_button.php'); ?>

<div class="content">
	<div class="tabular-section">
		
		<!--  show language selection tabular view only when there are morethan 1 language -->
		<?php if(count($this -> language -> getLanguages()) > 1) { ?>
			<ul class="nav nav-tabs">
				<?php foreach($this -> language -> getLanguages() as $key => $language) { ?>
					<li class="nav-item">
						<a class="nav-link <?php echo $key == 0 ? 'active' : ''; ?>" href="#page-<?php echo $key; ?>">
							<img style="background: white; padding: 0px; height: 20px; width: 20px; object-fit: contain; border-radius: 100%;" src="<?php echo $this-> language -> getLanguageFlag( $language ); ?>">
							<?php echo $language; ?>					
						</a>
					</li>
				<?php } ?>
			</ul>
		<?php } ?>
		
		<div class="<?php echo count($this -> language -> getLanguages()) > 1 ? 'tab-content' : '' ?>">

			<?php foreach($this -> language -> getLanguages() as $key => $language) { ?>		

				<div class="content-wrapper <?php echo $key == 0 ? 'active' : ''; ?>" id="page-<?php echo $key; ?>">
					
					<table width="100%" border="1" cellspacing="0" cellpadding="0" class="form-table margin-bottom-20 margin-top-10">				  		
						<tbody>
							<tr>  				
								<td class="td-label"><label for="category-search">Search Here</label></td>  				
								<td class="input">  					
                  <input 
                    data-searchable-input="cms-category-input-<?php echo $key; ?>" 
                    type="text" placeholder="Search Here" 
                    class="form-control">  				
								</td>  			
							</tr>  		  	
						</tbody>
					</table>
					
					<div class="overflow-table">
            <table 
              data-searchable-table="cms-category-table-<?php echo $key; ?>" 
              width="100%" 
              border="1" 
              cellspacing="0" 
              class="table table-bordered form-table form-records">				
			
							<thead>
								<tr>
									<th>WID ID</th>
									<th>Accessor Name</th>
									<th>Added By</th>
									<th>Added On</th>
									<th>Last Modified</th>
									<th>Featured</th>
									<th>Visibility</th>
									<th>Action</th>
								</tr>
							</thead>

							<tbody>

								<?php $i = 0; foreach($data['widgetData'] as $key => $widget) { ?>						
									
									<?php 
										if($widget['language'] != $language) {
											continue;
										} else {
											$count[$language] = ++$i;
										}
									?>

									<tr id="<?php echo 'parent-' .  $widget['widget_id']; ?>" 
										
										data-push-update-action="<?php echo baseURL('panel/operations/push-update/' . $widget['widget_id']); ?>" 
										data-push-toggle-action="<?php echo baseURL('panel/operations/push-toggle/' . $widget['widget_id']); ?>" 
										data-push-delete-action="<?php echo baseURL('panel/operations/push-delete/' . $widget['widget_id']); ?>" 

										data-where="widget_id" 
										data-directory="m_widgets" 
										/>
										
										<td style="min-width: 180px;" class="search-here"><?php echo $widget['widget_id']; ?></td>								
										<td style="min-width: 180px;" class="search-here"><?php echo $widget['accessor_name']; ?></td>							
										<td style="min-width: 180px;" class="search-here"><?php echo $widget['added_by']; ?></td>							
										<td style="min-width: 180px;" class="search-here"><?php echo $widget['added_on']; ?></td>							
										<td style="min-width: 180px;" class="search-here"><?php echo $widget['last_modified']; ?></td>							
                    
                    <td class="search-here" style="padding: 0; min-width: 50px;">
											<label class="switch" style="left: 0; transform: scale(0.5);">  						
                        <input
                          id="widget-featured-<?php echo $widget['widget_id']; ?>" 	 
                          class="widget-featured"
                          type="checkbox" 
                          data-form="<?php echo '#parent-' .  $widget['widget_id']; ?>" 
                          data-toggle-attribute="featured" 
                          name="featured" <?php echo $widget['featured'] == '1' ? 'checked="checked"' : ''; ?> 
												/>  						
												<div class="slider"></div>  					
											</label>
										</td>

										<td class="search-here" style="padding: 0; min-width: 50px;">
											<label class="switch" style="left: 0; transform: scale(0.5);">  						
                        <input 
                          id="widget-visibility-<?php echo $widget['widget_id']; ?>"
                          class="widget-visibility" 											 
                          type="checkbox" 
                          data-form="<?php echo '#parent-' .  $widget['widget_id']; ?>" 													
                          data-toggle-attribute="visibility" 
                          name="visibility" <?php echo $widget['visibility'] == '1' ? 'checked="checked"' : ''; ?> 
													/>  						
												<div class="slider"></div>  					
											</label>
										</td>
										
										<td align="center" style="min-width: 200px;">
											<a class="widget-more-trigger" href="<?php echo baseURL('panel/widgets/' . URLTitle($widget['widget_type']) . '/add/' . $widget['widget_id']); ?>" >FULL WIDGET</a>
											<a class="widget-delete-trigger" href="#" id="widget-delete-trigger-<?php echo $widget['widget_id']; ?>"  data-form="<?php echo '#parent-' .  $widget['widget_id']; ?>">DELETE</a>
										</td>

									</tr>

								<?php } ?>			

							</tbody>

						</table>
					</div>
					
					<h5 class="listing-count" id="listing-count">Total: <span><?php echo isset($count[$language]) ? $count[$language] : 0; ?></span></h5>

				</div>

			<?php } ?>

		</div>
	</div>
</div>