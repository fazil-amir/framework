<div class="tabular-section">
	<ul class="nav nav-tabs">
		<li class="nav-item">
			<a class="nav-link active" href="#page-data">Page Data</a>
		</li>
		<li class="nav-item"> 
			<a class="nav-link" href="#post-banner-image">Banner Image</a>
		</li>
		<li class="nav-item"> 
			<a class="nav-link" href="#seo-data">SEO Data</a>
		</li>		
		<?php if(isset($data['category'])) { ?>
		<li class="nav-item"> 
			<a class="nav-link" href="#meta-data">Meta Data</a>
		</li>		
		<?php } ?>
	</ul>

	<form id="form-add-category" method="post" action="<?php echo baseURL('panel/block-cms/category/add-update/') . $data['catID'];  ?>">
		<div class="tab-content">
			
			<div class="content-wrapper active" id="page-data">		
				<table width="100%" border="1" cellspacing="0" cellpadding="0" class="form-table">				
					
					<tr>
						<th colspan="2" class="custom-header">Page Information</th>
					</tr>
					
					<!-- TITLE  -->
					<div class="form-group">
						<tr>
							<td class="td-label"><label for="category-name">Category Name:</label></td>
							<td class="input">
								<input value="<?php echo $data['category'] ? $data['category']['cat_name'] : '' ?>" type="text" required="required" minlength="5" maxlength="100" class="form-control validate" name="category-name" id="category-name">
							</td>
						</tr>
					</div>

					<!-- HEADLINE  -->
					<div class="form-group">
						<tr>
							<td class="td-label"><label for="headline">Headline:</label></td>
							<td class="input">
								<input value="<?php echo $data['category'] ? $data['category']['headline'] : '' ?>" type="text" required="required" minlength="5" maxlength="100" class="form-control validate" name="headline" id="headline">
							</td>
						</tr>
					</div>

					<!-- VISIBILITY  -->
					<div class="form-group">
						<tr>
							<td class="td-label"><label for="visibility">Visibility:</label></td>
							<td class="input">
								<label class="switch">
									<input type="checkbox" id="visibility" name="visibility" 
										<?php 
											if( $data['category'] && $data['category']['visibility'] == '1') {												
												echo ' checked="checked" '; 												
											}
										?>
									/>
									<div class="slider"></div>
								</label>
							</td>
						</tr>
					</div>

					<!-- FEATURED  -->
					<div class="form-group">
						<tr>
							<td class="td-label"><label for="featured">Featured:</label></td>
							<td class="input">
								<label class="switch">
									<input type="checkbox" name="featured" id="featured"
										<?php 
											if( $data['category'] && $data['category']['featured'] == '1') {												
												echo ' checked="checked" '; 												
											}
										?>
									/>
									<div class="slider"></div>
								</label>
							</td>
						</tr>
					</div>
					
					<?php if (count($this -> language -> getLanguages()) > 1) { ?>
						<!-- LANGUAGE  -->
						<div class="form-group">
							<tr>
								<th colspan="2" class="custom-header">Select Language:</th>
							</tr>
						</div>
						<div class="form-group">
							<tr>
								<td class="td-label"><label for="language">Language</label></td>
								<td class="input">
									<select class="form-control" id="language" name="language">
										<?php foreach($this -> language -> getLanguages() as $key => $language){ ?>
											<option 
												value="<?php echo $language; ?>"
												<?php 
													if( $data['category'] && $data['category']['language'] == $language ) {												
														echo ' selected="selected" '; 												
													}
												?>
												>
												<?php echo strtolower($language); ?>
											</option>
										<?php } ?>
									</select>
								</td>
							</tr>
						</div>
					<?php } ?>
				</table>
			</div>

			<div class="content-wrapper" id="post-banner-image">
				<table width="100%" border="1" cellspacing="0" cellpadding="0" class="form-table">
					<tr>
						<td class="input">						
							<label class="file">
								Banner Image
								<input accept='images' type="file" required="required" class="validate form-control" name="banner-image" id="banner-image">
							</label>
							<?php 
								if($data['category']) {												
									?>										
										<div class="preview-images cover-image">
											<img src="<?php echo $data['category']['banner_image'] ?>" />
											<span class="icon delete"></span>
										</div>
									<?php												
								}
							?>
						</td>
					</tr>
				</table>
			</div>

			<div class="content-wrapper" id="seo-data">
				<table width="100%" border="1" cellspacing="0" cellpadding="0" class="form-table">
					<tbody>
						
						<tr>
							<th colspan="2" class="custom-header">SEO Info</th>
						</tr>

						<!-- SEO TITLE  -->
						<div class="form-group">
							<tr>
								<td class="td-label"><label for="seo-title">SEO Title:</label></td>
								<td class="input">
									<input value="<?php echo $data['category'] ? $data['category']['seo_title'] : '' ?>" type="text" required="required" minlength="5" maxlength="100" class="form-control validate" name="seo-title" id="seo-title">
								</td>
							</tr>
						</div>



						<!-- SEO URI  -->
						<div class="form-group">
							<tr>
								<td class="td-label"><label for="seo-uri">SEO URI:</label></td>
								<td class="input">
									<input value="<?php echo $data['category'] ? $data['category']['seo_uri'] : '' ?>" type="text" required="required" minlength="5" maxlength="100" class="form-control validate" name="seo-uri" id="seo-uri">
								</td>
							</tr>
						</div>



						<!-- KEYWORDS  -->
						<div class="form-group">
							<tr>
								<td class="td-label"><label for="seo-keywords">Page Keyword:</label></td>
								<td class="input">
									<input value="<?php echo $data['category'] ? $data['category']['seo_keyword'] : '' ?>" type="text" required="required" minlength="10" maxlength="200" class="form-control validate" name="seo-keywords" id="seo-keywords">
								</td>
							</tr>
						</div>


						<!-- SEO DESC  -->
						<div class="form-group">
							<tr>
								<td class="td-label"><label for="seo-description">SEO Description:</label></td>
								<td class="input">
									<textarea class="form-control validate" required="required" minlength="30" maxlength="200" name="seo-description" id="seo-description"><?php echo $data['category'] ? $data['category']['seo_description'] : '' ?></textarea>
								</td>
							</tr>
						</div>
					</tbody>
				</table>
			</div>
			
			<?php if(isset($data['category'])) { ?>
				<div class="content-wrapper" id="meta-data">
					<table width="100%" border="1" cellspacing="0" cellpadding="0" class="form-table">

						<!-- Post Count  -->
						<div class="form-group">
							<tr>
								<td class="td-label"><label for="meta-post-count">Post Count</label></td>
								<td class="input readable-only">
									<?php echo $data['category']['child_count']; ?>
									<input 
										value="<?php echo $data['category']['child_count']; ?>" 
										type="hidden" 
										name="child_count">
								</td>
							</tr>
						</div>
					</table>
				</div>
			<?php } ?>

		</div>
	</form>

	<div class="call-to-action">		
		<a id="submit-category" data-form="#form-add-category" class="btn btn-primary"><?php echo $data['category'] ? 'Update Category' : 'Add New Category' ?></a>
	</div>
</div>