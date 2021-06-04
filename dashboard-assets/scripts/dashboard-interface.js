/* ========================
	DOCUMENT READY
====================================================================================================================== */
$(document).ready(function() {
	const pageName 	= $('[data-page-name]').data('page-name');

	switch (pageName) {
		/* ---------------------------	
			DASHBOARD		
		------------------------------------------------------------------------------------------------------- */
		case 'DASHBOARD': {
			console.log('DASHBOARD');
		}
		break;

    default: {
			unknownPage(pageName);
		}
  }
});
