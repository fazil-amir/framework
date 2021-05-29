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
								<td class="td-label"><label for="post-search">Search Here</label></td>  				
								<td class="input">  					
									<input type="text" placeholder="Search Here" class="form-control" data-searchable-input="cms-post-input-<?php echo $key; ?>" >  				
								</td>  			
							</tr>  		  	
						</tbody>
          </table>
          
          <div class="overflow-table">
            <table width="100%" border="1" cellspacing="0" class="table table-bordered form-table form-records" data-searchable-table="cms-post-table-<?php echo $key; ?>" >				
              <thead>
                <tr>
                  <th>Page ID</th>
                  <th>Type</th>
                  <th>Title</th>
                  <th>Caption</th>
                  <th>Category Name(s)</th>
                  <th>Featured</th>
                  <th>Visibility</th>
                  <th>Author(S)</th>
                  <th>Action</th>
                </tr>
              </thead>

              <tbody>
                <?php $i = 0; foreach($data['page'] as $key => $page) { ?>						
                  <?php 
                    if($page['language'] != $language) {
                      continue;
                    } else {
                      $count[$language] = ++$i;
                    }
                    $catIDs = [];
                    $catNames = [];
                    foreach($page['categories'] as $cat) {
                     $catIDs[] = $cat['cat_id'];
                     $catNames[] = $cat['cat_name'];
                    }
                  ?>

                  <tr id="<?php echo 'parent-' .  $page['page_id']; ?>" 
                    data-push-update-action="<?php echo baseURL('panel/operations/push-update/' . $page['page_id']); ?>" 
                    data-push-toggle-action="<?php echo baseURL('panel/operations/push-toggle/' . $page['page_id']); ?>" 
                    data-push-delete-action="<?php echo baseURL('panel/operations/push-delete/' . $page['page_id']); ?>" 
                    
                    data-p-directory="m_block_cms_categories"
                    data-p-where="child_count"
                    data-p-attr="cat_id"
                    data-p-attr-value="<?php echo implode(', ', $catIDs) ?>"

                    data-where="page_id" 
                    data-directory="m_block_cms_post" />
                    
                    <td class="search-here"><?php echo $page['page_id']; ?></td>							
                    
                    <td class="search-here"><?php echo ucwords(strtolower(str_replace('_', ' ', $page['page_type']))); ?></td>
                    
                    
                    <td class="search-here"><?php echo $page['title']; ?></td>							
                    <td class="search-here"><?php echo $page['caption']; ?></td>							
                    <td class="search-here"><?php echo implode(', ', $catNames) ?></td>
                    
                    <td class="search-here" style="padding: 0; width: 50px;">
                      <label class="switch" style="left: 0; transform: scale(0.5);">  						
                        <input  type="checkbox" 
                            class="cms-featured"
                            id="cms-featured-<?php echo $page['page_id']; ?>" 
                            data-form="<?php echo '#parent-' .  $page['page_id']; ?>" 
                            data-toggle-attribute="featured" 
                            name="featured" <?php echo $page['featured'] == '1' ? 'checked="checked"' : ''; ?> 
                          />  						
                        <div class="slider"></div>  					
                      </label>
                    </td>

                    <td class="search-here" style="padding: 0; width: 50px;">
                      <label class="switch" style="left: 0; transform: scale(0.5);">  						
                        <input  type="checkbox" 
                            class="cms-visibility" 
                            id="cms-visibility-<?php echo $page['page_id']; ?>" 													 
                            data-form="<?php echo '#parent-' .  $page['page_id']; ?>" 													
                            data-toggle-attribute="visibility" 
                            name="visibility" <?php echo $page['visibility'] == '1' ? 'checked="checked"' : ''; ?> 
                          />  						
                        <div class="slider"></div>  					
                      </label>
                    </td>

                    <td class="search-here" ><?php echo $page['author']; ?></td>
                    
                    <td align="center" style="min-width: 200px;">
                      <a class="cms-more-trigger" href="<?php echo baseURL('panel/block-cms/post/' . $page['page_id']); ?>" >FULL PAGE</a>
                      <a class="cms-delete-trigger" href="#" id="cms-delete-trigger-<?php echo $page['page_id']; ?>" data-form="<?php echo '#parent-' .  $page['page_id']; ?>">DELETE</a>
                    </td>

                  </tr>

                <?php } ?>			
              </tbody>
            </table>
          </div>
					<h5 class="listing-count" id="listing-count">Total pages of post(s): <span><?php echo isset($count[$language]) ? $count[$language] : 0; ?></span></h5>
				</div>
			<?php } ?>
		</div>
	</div>
</div>