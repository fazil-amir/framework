<div class="content" id='has-submission-view'>
  <table width="100%" border="1" cellspacing="0" cellpadding="0" class="form-table margin-top-20">				  		
    <tbody>
      <tr>  				
        <td class="td-label"><label for="form-submission-search">Search Here</label></td>  				
        <td class="input">  					
          <input type="text" placeholder="Search Here" id='form-submission-search' class="form-control" >  				
        </td>  			
      </tr>  		  	
    </tbody>
  </table>

  <div id='form-submission-result'>
    <table width="100%" cellspacing="0" class="table table-striped">
      <thead>
        <tr>
          <th>Name</th>
          <th>Email</th>
          <th>Phone</th>
          <th>Delivered On</th>
        </tr>
      </thead>
      <tbody>
        <tr><td>Fazil</td><td>Fazil</td><td>Fazil</td><td>Fazil</td></tr>
        <tr><td>Fazil</td><td>Fazil</td><td>Fazil</td><td>Fazil</td></tr>
        <tr><td>Fazil</td><td>Fazil</td><td>Fazil</td><td>Fazil</td></tr>
        <tr><td>Fazil</td><td>Fazil</td><td>Fazil</td><td>Fazil</td></tr>
        <tr><td>Fazil</td><td>Fazil</td><td>Fazil</td><td>Fazil</td></tr>
        <tr><td>Fazil</td><td>Fazil</td><td>Fazil</td><td>Fazil</td></tr>
      </tbody>
    </table>
  </div>

  <div class='from-submission-page-container' data-accessor-name='<?php echo $data['accessorName']; ?>'>
    <div class="overflow-table">
      <table width="100%" border="1" cellspacing="0" class="table margin-top-20 table-striped table-bordered form-table form-records">
        <thead>
          <tr>
            <!-- <th>ID</th> -->
            <!-- <th>Subject</th> -->
            <th style="height: 55px;">Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Delivered On</th>
            <th>URL</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody id='form-submission-row-container'></tbody>
      </table>
    </div>
    <div id='pagination-container'></div>
    <p class='margin-top-10'>Showing (<span id='count-placeholder'></span>)</p>
  </div> 

  <!-- Modal -->
  <div class="modal fade" id="form-submission-modal" tabindex="-1" role="dialog" aria-labelledby="form-submission-modalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Form Submission Detail</h4>
        </div>
        <div class="modal-body"></div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>

</div>

<div class="content" id='no-submission-view'>
  <h4>There are no submissions here.</h4>
  <img src="<?php echo baseURL('engine/includes/images/misc-icons/005-email.png') ?>"/>
</div>

