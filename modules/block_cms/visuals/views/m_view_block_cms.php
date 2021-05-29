<?php 
require 'maps/panel.php'; 
$galleryEnabled = true;
if(isset($panel['load']['BLOCK_CMS'])) {
	$settings = is_array($panel['load']['BLOCK_CMS']) ? $panel['load']['BLOCK_CMS'] : false;
	$galleryEnabled = isset($settings['showGallery']) ? $settings['showGallery'] : false;
}
?>
<div class="tabular-section">
	<ul class="nav nav-tabs">
		<li class="nav-item">
			<a class="nav-link active" href="#meta-info">Meta Info</a>
		</li>
		<li class="nav-item"> 
			<a class="nav-link" href="#page-banner">Page Banner</a>
		</li>
		<li class="nav-item"> 
			<a class="nav-link" href="#page-data">Page Data</a>
		</li>		
		<?php if ($galleryEnabled) { ?>
			<li class="nav-item"> 
				<a class="nav-link" href="#image-gallery">Image Gallery</a>
			</li>		
		<?php } ?>
	</ul>

	<form 
		id="form-add-post" 
		method="post" 
		action="<?php echo baseURL('panel/block-cms/add/') . $data['pageID'];  ?>" 
		data-source="<?php echo count($data['page']) > 0 ? baseURL($data['page']['directory'] . $data['page']['rich_data_name']) : ''; ?>" >
		<div class="tab-content">
			<div class="content-wrapper active" id="meta-info">		
				<table width="100%" border="1" cellspacing="0" cellpadding="0" class="form-table">				
					<tr>
						<th colspan="2" class="custom-header">General Info</th>
					</tr>
					
					<!-- PAGE TYPE -->
					<div class="form-group">
						<tr>
							<td class="td-label"><label for="page-type">Page Type</label></td>
							<td class="input">
								<?php foreach($data['pageType'] as $page) { ?>
									<input 
										<?php 
											if (count($data['page']) > 0) {
												if($data['page']['page_type'] === $page) {
													echo 'checked="checked"';
												}
											} else if($page === $data['pageType'][0]) {
												echo 'checked="checked"';
											}
										?>
										type="radio" 
										id="page-type-<?php echo $page; ?>"
										name="page-type" 
										value="<?php echo $page; ?>" /> 						
									<label class="radio-btn" for="page-type-<?php echo $page; ?>" ><?php echo ucwords(strtolower(str_replace('_', ' ', $page))); ?></label>
								<?php } ?>
							</td>
						</tr>
					</div>

					<!-- TITLE  -->
					<div class="form-group">
						<tr>
							<td class="td-label"><label for="page-title">Page Title:</label></td>
							<td class="input">
								<input type="text" required="required" minlength="5" maxlength="100" class="form-control validate" id="page-title" value="<?php echo count($data['page']) > 0 ? $data['page']['title'] : ''; ?>">
							</td>
						</tr>
					</div>

					<!-- TITLE  -->
					<div class="form-group">
						<tr>
							<td class="td-label"><label for="page-caption">Page Caption:</label></td>
							<td class="input">
								<input type="text" required="required" minlength="5" maxlength="100" class="form-control validate" id="page-caption" value="<?php echo count($data['page']) > 0 ? $data['page']['caption'] : ''; ?>">
							</td>
						</tr>
					</div>

					<!-- CATEGORY  -->
					<div class="form-group">
						<tr>
							<td class="td-label"><label for="category">Category:</label></td>
							<td class="input">
							<select class="form-control validate" id="category" multiple required="required">								
								<?php foreach($data['categories'] as $key => $category) { ?> 
									<?php $selectedCategories = []; ?>
									<?php if(count($data['page']) > 0) {
										foreach($data['page']['categories'] as $cat) {
											$selectedCategories[] = $cat['cat_id'];
										}
									} ?>
									<option 
										<?php echo in_array($category['cat_id'], $selectedCategories) ? 'selected="selected"' : '' ?>
										value="<?php echo $category['cat_id']; ?>">
										<?php echo $category['cat_name']; ?>
									</option>
								<?php } ?>
							</select>
							</td>
						</tr>
					</div>

					<!-- DESC  -->
					<div class="form-group">
						<tr>
							<td class="td-label"><label for="shot-description">Short Description:</label></td>
							<td class="input">
								<textarea class="form-control validate" required="required" minlength="50" maxlength="500" id="shot-description"><?php echo count($data['page']) > 0 ? $data['page']['short_description'] : '' ?></textarea>
							</td>
						</tr>
					</div>

					<!-- AUTHOR  -->
					<div class="form-group">
						<tr>
							<td class="td-label"><label for="page-author">Page Author:</label></td>
							<td class="input">
								<select class="form-control validate" id="page-author" multiple required="required">		
									<?php 
										if (count($data['page']) > 0) {
											$temp = explode(',', $data['page']['author']);
											?>
												<option value="ADMIN" <?php echo in_array('ADMIN', $temp) ? 'selected="selected"' : '' ?>><?php echo 'Admin'; ?></option>
											<?php
										} else {
											?>
												<option value="ADMIN"><?php echo 'Admin'; ?></option>
											<?php
										}
									?>						
								</select>
							</td>
						</tr>
					</div>

					<!-- VISIBILITY  -->
					<div class="form-group">
						<tr>
							<td class="td-label"><label for="visibility">Visibility:</label></td>
							<td class="input">
								<label class="switch">
									<input type="checkbox" id="visibility" 
										<?php 
											if(count($data['page']) > 0) {
												if($data['page']['visibility'] == 1) {
													echo 'checked="checked"';
												}
											} else {
												echo 'checked="checked"';
											}
										?>
									>
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
									<input type="checkbox" id="featured"
										<?php 
										if (count($data['page']) > 0) {
											if($data['page']['featured'] == 1) {
												echo 'checked="checked"';
											}
										}
									?>
									>
									<div class="slider"></div>
								</label>
							</td>
						</tr>
					</div>
					

					<?php if (count($this -> language -> getLanguages()) > 1) { ?>
						<div class="form-group">
							<tr>
								<th colspan="2" class="custom-header">Select Language:</th>
							</tr>
						</div>
						<!-- LANGUAGE  -->
						<div class="form-group">
							<tr>
								<td class="td-label"><label for="language">Languages Available</label></td>
								
								<td class="input">
									<select class="form-control" id="language">
										<?php foreach( $this -> language -> getLanguages() as $key => $language){ ?>
											<option value="<?php echo $language; ?>"><?php echo strtolower($language); ?></option>
										<?php } ?>
									</select>
								</td>
								
							</tr>
						</div>
					<?php } ?>
						

					<tr>
						<th colspan="2" class="custom-header">SEO Info</th>
					</tr>

					<!-- SEO TITLE  -->
					<div class="form-group">
						<tr>
							<td class="td-label"><label for="seo-title">SEO Title:</label></td>
							<td class="input">
								<input type="text" required="required" minlength="5" maxlength="100" class="form-control validate" id="seo-title" value="<?php echo count($data['page']) > 0 ? $data['page']['seo_title'] : '' ?>">
							</td>
						</tr>
					</div>
					<!-- SEO URI  -->
					<div class="form-group">
						<tr>
							<td class="td-label"><label for="seo-uri">SEO URI:</label></td>
							<td class="input">
								<input type="text" required="required" minlength="5" maxlength="100" class="form-control validate" id="seo-uri" value="<?php echo count($data['page']) > 0 ? $data['page']['seo_uri'] : '' ?>">
							</td>
						</tr>
					</div>

					<!-- KEYWORDS  -->
					<div class="form-group">
						<tr>
							<td class="td-label"><label for="seo-keywords">Page Keyword:</label></td>
							<td class="input">
								<input type="text" required="required" minlength="10" maxlength="200" class="form-control validate" id="seo-keywords" value="<?php echo count($data['page']) > 0 ? $data['page']['seo_keywords'] : '' ?>">
							</td>
						</tr>
					</div>

					<!-- SEO DESC  -->
					<div class="form-group">
						<tr>
							<td class="td-label"><label for="seo-description">SEO Description:</label></td>
							<td class="input">
								<textarea class="form-control validate" required="required" minlength="50" maxlength="200" id="seo-description"><?php echo count($data['page']) > 0 ? $data['page']['seo_description'] : '' ?></textarea>
							</td>
						</tr>
					</div>
				
				</table>
			</div>

			<div class="content-wrapper" id="page-banner">
				<?php include_once ('modules/block_cms/visuals/elements/m_elem_intro_banner.php'); ?>
			</div>

			<div class="content-wrapper" id="page-data">
				<?php include_once ('modules/block_cms/visuals/elements/m_elem_block_adding_btn.php'); ?>
				<div id="page-data-container" class="page-data-container"></div>
			</div>
			
			<?php if ($galleryEnabled) { ?>
				<div class="content-wrapper" id="image-gallery">
					<table width="100%" border="1" cellspacing="0" cellpadding="0" class="form-table">
						<tr>
							<td class="input">						
								<label class="file">
									Image Gallery
									<input accept='images' type="file" required="required" class="form-control" multiple name="image-gallery-input" id="image-gallery-input">
								</label>
								<?php 
									if($data['page']) {	
										$images = json_decode($data['page']['gallery_images']);
										foreach($images as $image) {
											?>										
												<div class="preview-images">
													<img src="<?php echo $image ?>" />
													<span class="icon delete"></span>
												</div>
											<?php	
										}																						
									}
								?>
							</td>
						</tr>
					</table>
				</div>
			<?php } ?>
		</div>
	</form>

	<div class='call-to-action'>
		<a id="submit-post" data-form="#form-add-post" class="btn btn-primary btn-lg">Submit</a>
	</div>

</div>
