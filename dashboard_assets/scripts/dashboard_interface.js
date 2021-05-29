/* ========================
	DOCUMENT READY
====================================================================================================================== */
$(document).ready(function() {
	pageName 	= $('[data-page-name]').data('page-name');
	if(typeof ProcessForm === 'function'){
		// Global form object
		form 	= new ProcessForm();
	}

	// edit 	 			= new MakeEditable();
	// paging   		= new MakePagination();
	// delEntry 		= new DeleteEntry( '.delete-trigger' );
	// push1    		= new PushUpdate( '#featured' );
	// push2     		= new PushUpdate( '#visibility' );
	// $("select.form-control").selectpicker();

	switch (pageName) {
		/* ---------------------------	
			DASHBOARD		
		------------------------------------------------------------------------------------------------------- */
		case 'DASHBOARD': {
			console.log('DASHBOARD');
		}
		break;

		/* ---------------------------	
			SPECIFICATIONS		
		------------------------------------------------------------------------------------------------------- */
		case 'SPECIFICATIONS': {
			edit.init( $('.edit-trigger') ); 
			paging.staticPagination( $('.form-records'), 20);
			$("#specification-search-table").tablesorter();
			$('#submit-button').on('click', function() {
				form.init( $(this).data('form'), {
					'buttonSelector' : '#submit-button',
					'buttonText'	 : 'Inserting...'
				}, function(response){
					if( response.success === 1 ){						
						var updateLink 		= baseURL('panel/specifications/update/' + response.data.pr_id);
						html = `
							<tr id="parent-${response.data.pr_id}" update="${updateLink}" >				
								<td class="search-here" align="center">${response.data.pr_id}</td>
								<td class="search-here" align="center">${response.data.spec_id}</td>
								<td class="search-here editable validate" name="spec_name" minlength="3" required="required">${response.data.spec_name}</td>
								<td class="search-here" align="center" >${response.data.date_added}</td>
								<td class="search-here" align="center" >${response.data.added_by}</td>
								<td align="center">
									[<a href="#" class="edit-trigger" data-form="#parent-${response.data.pr_id}" >EDIT</a>]
								</td>			
							</tr>
						`;					
						$('#specfication-search-table tbody').prepend(html);					
						$("#specfication-search-table").trigger("update");
						$('#listing-count span').text(
							parseInt($('#listing-count span').text()) + 1
						);
						showMessage(response.message, 'default');
					} else {
						showMessage(response.message, 'error');
					}
				});
				form.validate();
				form.submit();
			});
		} break;
	
    default: {
			unknownPage( pageName );
		}
  }
});
