<div class="content">
	<div class="tabular-section">
		
		<!--  show language selection tabular view only when there are morethan 1 language -->
		<?php if(count( $this -> language -> getLanguages()) > 1 ) { ?>
			<ul class="nav nav-tabs">
				<?php foreach( $this -> language -> getLanguages() as $key => $language) { ?>
					<li class="nav-item">
						<a class="nav-link <?php echo $key == 0 ? 'active' : ''; ?>" href="#page-<?php echo $key; ?>">
							<img style="background: white; padding: 0px; height: 20px; width: 20px; object-fit: contain; border-radius: 100%;" src="<?php echo $this-> language -> getLanguageFlag( $language ); ?>">
							<?php echo $language; ?>					
						</a>
					</li>
				<?php } ?>
			</ul>
		<?php } ?>
		
		<div class="<?php echo count( $this -> language -> getLanguages()) > 1 ? 'tab-content' : '' ?>">

			<?php foreach( $this -> language -> getLanguages() as $key => $language) { ?>		

				<div class="content-wrapper <?php echo $key == 0 ? 'active' : ''; ?>" id="page-<?php echo $key; ?>">
					
					<table width="100%" border="1" cellspacing="0" cellpadding="0" class="form-table margin-bottom-20 margin-top-10">				  		
						<tbody>
							<tr>  				
								<td class="td-label"><label for="category-search">Search Here</label></td>  				
								<td class="input">  					
									<input type="text" placeholder="Search Here" class="form-control" data-searchable-input="cms-category-input-<?php echo $key; ?>" >  				
								</td>  			
							</tr>  		  	
						</tbody>
					</table>
					
					<div class="overflow-table">
						<table width="100%" border="1" cellspacing="0" class="table table-bordered form-table form-records" data-searchable-table="cms-category-table-<?php echo $key; ?>" >				
			
							<thead>
								<tr>
									<th>CAT ID</th>
									<th>Category Name</th>
									<th>Headline</th>
									<th>Featured</th>
									<th>Visibility</th>
									<th>Added By</th>
									<th>Total Posts</th>
									<th>Action</th>
								</tr>
							</thead>

							<tbody>

								<?php $i = 0; foreach( $data['categories'] as $key => $category ) { ?>						
									
									<?php 
										if($category['language'] != $language) {
											continue;
										} else {
											$count[$language] = ++$i;
										}
									?>

									<tr id="<?php echo 'parent-' .  $category['cat_id']; ?>" 
										
										data-push-update-action="<?php echo baseURL('panel/operations/push-update/' . $category['cat_id']); ?>" 
										data-push-toggle-action="<?php echo baseURL('panel/operations/push-toggle/' . $category['cat_id']); ?>" 
										data-push-delete-action="<?php echo baseURL('panel/operations/push-delete/' . $category['cat_id']); ?>" 

										data-where="cat_id" 
										data-directory="m_block_cms_categories" 
										/>
										
										<td class="search-here" style="width: 180px;"><?php echo $category['cat_id']; ?></td>							
										<td class="search-here editable validate" name="cat_name" minlength="3" maxlength="100" required="required" ><?php echo $category['cat_name']; ?></td>
										<td class="search-here editable validate" name="headline" minlength="3" maxlength="100" required="required"><?php echo $category['headline']; ?></td>							
										<td class="search-here" style="padding: 0; width: 50px;">
											<label class="switch" style="left: 0; transform: scale(0.5);">  						
												<input  type="checkbox" 
														class="cms-featured"
														id="cms-featured-<?php echo $category['cat_id']; ?>" 
														data-form="<?php echo '#parent-' .  $category['cat_id']; ?>" 
														data-toggle-attribute="featured" 
														name="featured" <?php echo $category['featured'] == '1' ? 'checked="checked"' : ''; ?> 
													/>  						
												<div class="slider"></div>  					
											</label>
										</td>

										<td class="search-here" style="padding: 0; width: 50px;">
											<label class="switch" style="left: 0; transform: scale(0.5);">  						
												<input  type="checkbox" 
														class="cms-visibility" 
														id="cms-visibility-<?php echo $category['cat_id']; ?>" 													 
														data-form="<?php echo '#parent-' .  $category['cat_id']; ?>" 													
														data-toggle-attribute="visibility" 
														name="visibility" <?php echo $category['visibility'] == '1' ? 'checked="checked"' : ''; ?> 
													/>  						
												<div class="slider"></div>  					
											</label>
										</td>

										<td class="search-here" style="width: 150px;"><?php echo $category['added_by']; ?></td>
										<td style="width: 120px;"><?php echo $category['child_count']; ?></td>
										
										<td align="center" style="width: 200px;">
											[<a href="#" class="cms-edit-trigger" data-form="<?php echo '#parent-' .  $category['cat_id']; ?>" >EDIT</a>]
											[<a href="<?php echo baseURL('panel/block-cms/category/add/' . $category['cat_id']); ?>" >MORE</a>]
											[<a href="#" data-count-error-message="Cannot delete this category as posts exist" data-count-child="<?php echo $category['child_count'];?>" id="cms-delete-trigger-<?php echo $category['cat_id']; ?>" class="cms-delete-trigger" data-form="<?php echo '#parent-' .  $category['cat_id']; ?>">DELETE</a>]
										</td>

									</tr>

								<?php } ?>			

							</tbody>

						</table>
					</div>
					
					<h5 class="listing-count" id="listing-count">Total listing of categories: <span><?php echo isset($count[$language]) ? $count[$language] : 0; ?></span></h5>

				</div>

			<?php } ?>

		</div>
	</div>
</div>