/* =====================================	
	PROCESS FORM 	
================================================================================================================ */
ProcessForm = (function(){
	this.fromIdentifier;
	this.ajaxMessages = {
		'formSubmit'	: {
			'success'	: 'Form has been submitted',
			'failed'	: 'Form submission failed'
		},
		'rowDelete'		: {
			'success'	: 'Row has been deleted',
			'failed'	: 'Error while deleting a row'
		},
		'rowUpdate'		: {
			'success'	: 'Row has been updated',
			'failed'	: 'Error while updating a row'
		}
	};
	this.validationMessages = {
		'required'		: 'This field is required',
		'notValid'		: 'Not a valid input',
		'minLength'		: 'That was too less',
		'maxLength'		: 'That was too big input',
		'email'				: 'That was not a valid email'
	};
	this.buttonText 				= 'Please Wait';
	this.oldButtonText 			= '';
	this.validationSelector	= ' .validate';
	this.buttonSelector     = '';
	this.result							= '';
	this.type								= 'POST';
	this.callback       		= '';
	this.pushElement				= '';
	var that 								= this;

	/* ---------------------------	
		RUN VALIDATION		
	------------------------------------------------------------------------------------------------------- */
	this.runValidation = function(){
		that.result 	= true;
		
		var items 		= $(that.fromIdentifier + ' ' + that.validationSelector),
			isTD 		= false,
			F,
			focusGiven 	= true;
			focusTab	= true;
		
		removeMessage(items);
		items.each(function(){				
			F = $(this);
			
			if(F.is('td')) {
				isTD = true;
			}

			if(checkRequired(F) === false) {				
				that.result = false;
				setMessage(F, that.validationMessages.required);
				if(focusGiven){
					focusGiven = false;
					F.focus();
				}
				focusTabOnFailedValidation(F);
			}
			else if(checkMinLength(F) === false) {
				that.result = false;
				setMessage(F, that.validationMessages.minLength);
				if(focusGiven){
					focusGiven = false;
					F.focus();
				}
				focusTabOnFailedValidation(F);
			} 
			else if(checkMaxLength(F) === false) {
				that.result = false;
				setMessage(F, that.validationMessages.maxLength);
				if(focusGiven){
					focusGiven = false;
					F.focus();
				}
				focusTabOnFailedValidation(F);
			} 
			else if(checkValidEmail(F) === false) {
				that.result = false;
				setMessage(F, that.validationMessages.email);
				if(focusGiven){
					focusGiven = false;
					F.focus();
				}
				focusTabOnFailedValidation(F);
			}
		});

		function focusTabOnFailedValidation(F){			
			if(F.closest('div.tab-content').length > 0 && focusTab){
				focusTab = false;
				var clickTab = F.closest('div.content-wrapper').attr('id');				
				$(".nav-item a[href$='" + clickTab + "']").click();
			}
		};

		function checkRequired(F){	
			if(F.attr('required') === 'required'){
				if(isTD) {
					if(F.text().trim() === '') {
						return false;
					} else {
						return true;
					}
				} else {
					if(F.attr('type') === 'file') {						
						if(F.parent().parent().find('div.preview-images').length === 0) {
							return false;
						} else {
							return true;
						}
					} else {
						if(F.val() === '' || F.val() === null || F.length === 0 || !F.val().length) {
							return false;
						} else {
							return true;
						}
					}
					
				}
			}
		};

		function checkMinLength (F){
			if(F.attr('minlength')) {
				if(! isTD ){
					if(F.val().length < F.attr('minlength')){
						return false;
					} else {
						return true;
					}
				} else{
					if(F.text().length < F.attr('minlength')){
						return false;
					} else {
						return true;
					}
				}
			}else {
				return true;
			}
		};

		function checkMaxLength(F){
			if(F.attr('maxlength')) {				
				if(! isTD ){
					if(F.val().length > F.attr('maxlength')){
						return false;
					} else {
						return true;
					}
				} else{
					if(F.text().length > F.attr('maxlength')){
						return false;
					} else {
						return true;
					}
				}
			} else {
				return true;
			}
		};

		function checkValidEmail(F){
			return true;
		};

		function setMessage(F, M){
			if(! isTD){
				F.parent().addClass('error');
				F.parent().append('<div class="err-message">' + M + '</div>');
			} else {
				F.addClass('error');
			}			
		};

		function removeMessage(F){
			if(! isTD){
				F.parent().removeClass('error');
				F.parent().find('.err-message').remove();
			} else {
				F.removeClass('error');
			}
		};

	};

	/* ---------------------------	
		AJAX		
	------------------------------------------------------------------------------------------------------- */
	this.ajax = function(request = ''){
		switch(request) {
			case 'SUBMIT' : 		submit(); 		break;
			case 'UPDATE_ROW' : 	updateRow(); 	break;
			case 'DELETE_ROW' :    	deleteRow(); 	break;
			case 'PUSH_TOGGLE' :   	pushToggle(); 	break;
 		}
		
		/* ---------------------------	
			ROW UPDATE		
		------------------------------------------------------------------------------------------------------- */
		function updateRow() {
			
			var $form 					= $(that.fromIdentifier),
				ajaxURL 				= $form.data('push-update-action'),
				formData 				= new FormData(),
				$T;
				btn 					= $(that.buttonSelector);
				that.oldButtonText		= btn.text()
				attributes 				= [];

			btn.prop('disabled', true)
			   .text(that.buttonText);

			$form.find(that.validationSelector).each(function(){
				$T = $(this);				
				attributes.push({
					[$T.attr('name')]: $T.text()
				});			
			});

			formData.append( 'directory',  $form.data('directory') );
			formData.append( 'where',  	   $form.data('where') );			
			formData.append( 'attributes', JSON.stringify(attributes) );
			
			$.ajax({		
				type 		: 'POST',
				url 		: ajaxURL,
				data 		: formData,
				cache       : false,
				contentType : false,
				processData : false,	
				dataType 	: 'json',							
			})
			.done(function(response){			
				btn.prop('disabled', false)
				   .text(that.oldButtonText);			
				runCallback(response);			
			})
			.fail(function(response){
				btn.prop('disabled', false)
				   .text(that.oldButtonText);			
				console.error('Failed at ajax: On submitting form');		
			});
		
		}
		
		/* ---------------------------	
			SUBMIT		
		------------------------------------------------------------------------------------------------------- */
		function submit(){
			var formData 					= new FormData($('form')[0]),
				btn 								= $(that.buttonSelector)
				that.oldButtonText	= btn.text()
				deleteLink					= $('.delete');
			
			// Images
			$(that.fromIdentifier).find('[type="file"]').each(function(){
				var temp  		= [];
				var images		= {}
				$(this).parent().parent().find('div.preview-images img').each(function(i){
					images[i] = $(this).attr('src');
				});
				temp.push(images);
				formData.append($(this).attr('name'), JSON.stringify(temp));		
			});

			// Multiselect
			if($('select.form-control')){
				$('select.form-control').each(function(){
					if( typeof($(this).val()) === 'object') {					
						formData.append($(this).attr('name'), $(this).val());
					}
				});
			}
				
			//Group values
			if( $('.form-control.group-value') ) {
				var oldKey  = '', newKey 	= '', temp  	= [], final	= {};
				$('.form-control.group-value').each(function(i){				 	
					var $elem = $(this);
					if( $(this).val() !== '' ){
						newKey = $elem.data('group-name');
						oldKey = oldKey ? oldKey : newKey;
						if( newKey === oldKey ){
							// Same keys
							temp.push({
								[$elem.attr('name')] : $elem.val()
							});
						}
						else {
							//Different keys
							final[oldKey] 	= temp;
							temp   			= [];
							temp.push({
								[$elem.attr('name')] : $elem.val()
							});
						}				 		
						oldKey 			= newKey;
					}
				});
				if( Object.keys(temp).length ) {
					final[oldKey] = temp;
				}
				if( Object.keys(final).length ){								
					for( var key in final){
						formData.append(key, JSON.stringify(final[key]) );					
					}
				}
			}

			btn.addClass('still').text(that.buttonText);
			deleteLink.addClass('still');
			$(that.fromIdentifier + ' input,' + that.fromIdentifier + ' textarea,' + that.fromIdentifier + ' select').prop('disabled', true);
			showOverlay();
			$.ajax({		
				type 		: 'POST',
				url 		: $(that.fromIdentifier).attr('action'),
				data 		: formData,
				cache       : false,
				contentType : false,
				processData : false,	
				dataType	: 'json',			
			})
			.done(function(response){			
				btn.removeClass('still').text(that.oldButtonText);
				deleteLink.removeClass('still');
				runCallback(response);	
				$(that.fromIdentifier + ' input,' + that.fromIdentifier + ' textarea,' + that.fromIdentifier + ' select').prop('disabled', false);
				hideOverlay();
				
				if( response.operation != 'UPDATE' ){
					$('.readable-only').text('');
					$(that.fromIdentifier).append('<input type="reset" value="reset" style="display:none" />');
				
					if($('.redactor').length > 0){
						$('.redactor').redactor('code.set', ''); 
					}

					if($('.preview-images').length > 0) {
						$('.preview-images').remove();
					}

					if($('.bootstrap-select').length > 0) {
						var preVal = $('select.form-control').val();
					}					

					$(that.fromIdentifier + ' [type="reset"]').click().remove();

					if( $('.bootstrap-select').length > 0 ) {
						$('select.form-control').selectpicker('val', preVal);
					}
				}
			})
			.fail(function( response ){
				btn.removeClass('still').text(that.oldButtonText);
				hideOverlay();
				$(that.fromIdentifier + ' input,' + that.fromIdentifier + ' textarea,' + that.fromIdentifier + ' select').prop('disabled', false);
				console.error('Failed at ajax: On submitting form');
				runCallback(response);

			});

		};

		/* ---------------------------	
			DELETE ROW		
		------------------------------------------------------------------------------------------------------- */
		function deleteRow(){
			var $form 						= $(that.fromIdentifier),
				ajaxURL 						= $form.data('push-delete-action')
				btn 								= $(that.buttonSelector);
				that.oldButtonText	= btn.text();
				formData 						= new FormData();

			formData.append('force', 	   $form.data('force'));
			formData.append('directory', $form.data('directory'));
			formData.append('where', 	 	 $form.data('where'));

			formData.append('p-directory', 	 	 $form.data('p-directory'));
			formData.append('p-where', 	 $form.data('p-where'));
			formData.append('p-attr', 	 	 		 $form.data('p-attr'));
			formData.append('p-attr-value', 	 $form.data('p-attr-value'));

			$.ajax({		
				type 		: 'POST',
				url 		: ajaxURL,
				data 		: formData,
				cache       : false,
				contentType : false,
				processData : false,
				dataType	: 'json',							
			})
			.done(function(response){			
				btn.prop('disabled', false)
				  .text(that.oldButtonText);			
				runCallback(response);			
			})
			.fail(function(){
				btn.prop('disabled', false)
				  .text(that.oldButtonText);			
				console.error('Failed at ajax: On deleting row');		
			});
		}

		/* ---------------------------	
			PUSH UPDATE		
		------------------------------------------------------------------------------------------------------- */
		function pushToggle() {
			var $form 					= $(that.fromIdentifier),
				ajaxURL 				= $form.data('push-toggle-action'),
				formData 				= new FormData();

			formData.append('attribute', $form.find(that.pushElement).data('toggle-attribute'));
			formData.append('new-value', $form.find(that.pushElement).data('toggle-value'));

			formData.append('directory', $form.data('directory'));
			formData.append('where', 	 $form.data('where'));

			$.ajax({		
				type 		: 'POST',
				url 		: ajaxURL,
				data 		: formData,
				cache       : false,
				contentType : false,
				processData : false,
				dataType	: 'json',		
			})
			.done(function(response){						
				runCallback(response);			
			})
			.fail(function(){			
				console.error('Failed at ajax: On push update');		
			});

		}

		/* ---------------------------	
			SHOW OVERLAY		
		------------------------------------------------------------------------------------------------------- */				
		function showOverlay() {
			$('.overlay').addClass('show');
		}

		/* ---------------------------	
			HIDE OVERLAY		
		------------------------------------------------------------------------------------------------------- */	
		function hideOverlay() {
			$('.overlay').removeClass('show');			
		}

		/* ---------------------------	
			RUN CALLBACK	
		------------------------------------------------------------------------------------------------------- */		
		function runCallback(response){
			if( that.callback ) {				
				that.callback(response);
			}
		}

	}

	/* ---------------------------	
		PUBLIC SCOPE		
	------------------------------------------------------------------------------------------------------- */
	return {
		/* ---------------------------	
			INIT	
		------------------------------------------------------------------------------------------------------- */
		
		init : function(fromIdentifier, settings = {
			'validationMessages'	: '',
			'ajaxMessages'			: '',
			'buttonText' 			: '',
			'type' 					: '',
			'buttonSelector'		: ''	
		}, callback = ''){

			$.extend(that.ajaxMessages, settings.ajaxMessages);
			$.extend(that.validationMessages, settings.validationMessages);

			that.buttonText 	= settings.buttonText
			that.type 			= settings.type
			that.buttonSelector = settings.buttonSelector;
			that.callback 		= callback;

			if(fromIdentifier === ''){
				console.error('Form which has to be validated and processed not defined');
				return false;
			} else {
				that.fromIdentifier = fromIdentifier;
			}

			if(that.buttonSelector === ''){
				console.error('Triggering button is not specified');	
				return false;
			}
		},

		/* ---------------------------	
			VALIDATE		
		------------------------------------------------------------------------------------------------------- */		
		validate: function(){
			that.runValidation();
			if(that.result) {
				return true;
			} else {
				return false;
			}
		},

		/* ---------------------------	
			SUBMIT		
		------------------------------------------------------------------------------------------------------- */
		submit : function(){
			if(that.result === true){				
				that.ajax('SUBMIT');
			}
		},

		/* ---------------------------	
			UPDATE ROW		
		------------------------------------------------------------------------------------------------------- */
		updateRow: function(){
			if(that.result === true){				
				that.ajax('UPDATE_ROW');
			}
		},

		/* ---------------------------	
			DELETE ROW		
		------------------------------------------------------------------------------------------------------- */
		deleteRow: function(){
			that.ajax('DELETE_ROW');
		},

		/* ---------------------------	
			PUSH UPDATE		
		------------------------------------------------------------------------------------------------------- */		
		pushToggle: function(pushElement){
			that.pushElement = pushElement;
			that.ajax('PUSH_TOGGLE');
		}
	};
});
const form 	= new ProcessForm();


