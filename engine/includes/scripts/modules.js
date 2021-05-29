function showMessage(text = '', type = '') {
	$.notify(text, {
		className: type,
		autoHide: true,
		autoHideDelay: 8000,
		globalPosition: 'bottom right'
	});
} 

function toggleLoading(flag = true) {
	if (flag) {
		$('.overlay').addClass('show');
	} else {
		$('.overlay').removeClass('show');
	}
} 

/* =====================================
	SUB MENU	
================================================================================================================ */
var SubMenu = (function($element) {
	$element.click(function() {
		$element.find('ul').removeClass('active');
		$(this).find('ul').addClass('active');
	})
	if ($('.' + $element.attr('class') + ' > a').hasClass('active')) {
		$('.' + $element.attr('class') + ' > a.active').next('ul').addClass('active');
	}
})($('.sub-menu'));

/* =====================================
	MAKE EDITABLE	
================================================================================================================ */
var MakeEditable = (function() {
	return {
		init: function($linkAnchor){
			var $parentElement;
			var T;
			$(document).on('click', '.' + $linkAnchor.attr('class') , function() {
				$T 			   = $(this);
				$parentElement = $( $T.data('form') );
				form.init( $T.data('form'), {
					'buttonSelector' : $linkAnchor.attr('class'),
					'buttonText'	 : 'Updating...'
				}, function(response){
					if( response.success === 1 ){						
						showMessage(response.message , 'default');
					} else {
						showMessage(response.message, 'error');
					}
				});

				if( $parentElement.find('td.editable').hasClass('edit-now') ) {
					if(form.validate()){
						$parentElement
							.find('td.editable')
							.removeClass('edit-now')
							.removeClass('error')
							.removeAttr('contentEditable');
						$T.text('EDIT');
						form.updateRow();
					}	
				} else {
					$T.text('UPDATE');
					$parentElement
						.find('td.editable')
						.addClass('edit-now')
						.attr('contentEditable', true)
						.focus();
				}
			});
		}
	}
});

/* =====================================
	DELETE ROW	
================================================================================================================ */
var DeleteEntry = (function(linkAnchor) {
	this.$linkAnchor = $(linkAnchor);
	var that = this;
	$(document).on('click', '.' + this.$linkAnchor.attr('class'), function() {
		if ($(this).data('count-child')) {
			var message = $(this).data('count-error-message') || 'Cannot delete this as a child exists'
			showMessage(message, 'error');
		} else {
			popup.confirm({
				content: 'Confirm Delete?',
				backdrop_close: false,
			}, (param) => {
				if(param.proceed) {
					that.removeElement($(this));
				}
			});
		}
	});

	this.removeElement = function(F) {
		form.init(F.data('form'), {
			'buttonSelector' : that.$linkAnchor.attr('class'),
			'buttonText'	 : 'Deleting...'
		}, function(response){
			if(response.success == 1){						
				showMessage(response.message , 'default');
				$(F.data('form')).remove();
			} else {
				showMessage(response.message, 'error');
			}
		});	
		form.deleteRow();		
	}
});

/* =====================================
	SEARCH ITEMS	
================================================================================================================ */
var Searchable = (function($inputField, searchable) {
	(function() {
		var that;
		$inputField.on('keyup', function(){
			var $P = $(this), $C;
			searchable.find('tbody tr').show();
			searchable.find('tbody tr').each(function(){
				$C = $(this).find('.search-here');
				if ( $C.text().toLowerCase().indexOf( $P.val().toLowerCase() ) === -1 ){					
					$C.parents('tr').hide();
				}
				else{
					$C.parents('tr').show();
				}
			});
			if ($P.val() === '') {
				$('.paging-nav a:nth-child(2)').click();
			}
		});
	})();
});
$(document).ready( function(){
	$('[data-searchable-input]').each( function(i) {
		new Searchable( $(this) , $('[data-searchable-table]').eq(i) );
	})
});

/* =====================================
	MAKE PAGINATION	
================================================================================================================ */
var MakePagination = (function() {
	this.staticPagination = function($table, limit = 10) {
		$table.paging({
			limit: limit
		});
		$('.paging-nav a:nth-child(2)').click();
		var nums = $('#specs-count').clone()
		$('.paging-nav').append(nums);
	}
});

/* =====================================
	PUSH TOGGLE	
================================================================================================================ */
var PushToggle = (function(element){
	var T, V, F, A, TB;
	$(document).on('change', element, function(){
		T = $(this);
		switch( T.attr('type') ) {
			case 'select' : 
				T.data('toggle-value', T.val())
			break;

			case 'checkbox' :
				if( T.prop('checked') == true ) {
					T.data('toggle-value', '1')
				} else {
					T.data('toggle-value', '0')
				}
			break;
		}

		form.init( T.data('form'), {
			'buttonSelector' : T.attr('id'),
			'buttonText'	 : 'Updating...'
		}, function(response){
			if( response.success === 1 ){						
				showMessage(response.message , 'default');
			} else {
				showMessage(response.message, 'error');
			}
		});
		form.pushToggle('#' + T.attr('id'));
	});
});

/* =====================================
	Modern File Input
================================================================================================================ */
var ModernFileInput = (function(){
	this.fileInput;
	this.allowedImgExts = ['jpg', 'png', 'gif', 'jpeg'];
	this.allowedImgSize = 2 //MB
	this.allowedDocExts = ['pdf', 'doc', 'docx'];
	this.allowedDocSize = 4 //MB
	this.coverImage 		= false;
	this.removeOld			= false;
	this.errors 				= [];
	this.errorIndexes 	= [];
	this.custom					= false;
	var that 						= this;

	this.readURL = function(input, removeOld, coverImage) {
		for(var i = 0; i < input.files.length; i++){
			if (input.files && input.files[i]) {
				var reader = new FileReader();
				reader.onload = function (e) {
					if(removeOld){
						that.fileInput.closest('td.input').find('.preview-images').remove();
					}
					var img = $('<img />').attr('src', e.target.result);
					if (coverImage) {
						coverImage = 'cover-image';
					} else {
						coverImage = '';
					}
					that.fileInput.closest('td.input').append(that.buildTemplate(img, coverImage))
				}
				reader.readAsDataURL(input.files[i]);
			}
		}
	};

	this.getBase64 = function(input){
		var result = [];
		for(var i = 0; i < input.files.length; i++){
			if (input.files && input.files[i]) {
				var reader = new FileReader();
				reader.onload = function (e) {
					result.push( e.target.result );
				}
				reader.readAsDataURL(input.files[i]);
			}
		}
		return result;
	}

	this.generateImage = function(image){
		var coverImageClass = that.coverImage ? 'cover-image' : '';
		var X = $('<span>', { 'class' : 'icon delete' })
		var T = $('<div />', { class: 'preview-images ' +  coverImageClass }).append(image).append(X);
		return T;
	}

	this.generateImageWrapper = function (image) {
		if (image.success) {
			this.removeOldContent();
			that.fileInput.closest('td.input').append(
				that.generateImage(
					$('<img />').attr('src', image.message)
				)
			)
		}
		if(image.success === false && !that.coverImage && !that.removeOld) {
			showMessage(`File no. ${image.message.index + 1}: ${image.message.message}`, 'error')
		} else {
			showMessage(image.message.message, 'error');
		}
	}

	this.removeOldContent = function() {
		if(that.removeOld){
			that.fileInput.closest('td.input').find('.preview-images').remove();
		}
	}

	this.resetValue = function(){
		$(document).on('click', '.preview-images .delete', function(){
			
			$(this).closest('div.preview-images').remove();	
					if(that.fileInput.parent().parent().find('div.preview-images').length === 0){
						that.fileInput.val('');
					}
		});
	}

	this.validate = function(input, rules, size) {
		that.errors = [];
		for(var i = 0; i < input.files.length; i++){
			if (input.files && input.files[i]) {
				var file = input.files[i];
				var currExt = file.name.substring(file.name.lastIndexOf('.') + 1).toLowerCase()
				if(!rules.includes(currExt)) {
					that.errorIndexes.push(i);
					that.errors.push({
						index: i,
						message: `Please upload file having (${rules.join(', ')}) extensions`
					});
				} else if((file.size / 1024 / 1024) > size) {
					that.errorIndexes.push(i);
					that.errors.push({
						index: i,
						message: `The file you're trying to upload exceeded the threshold limit of ${size}MB`
					});
				}
			}
		}
	}

	this.doUpload = function(input, callback) {
		for(var i = 0; i < input.files.length; i++){
			var hasErrs = that.errors.filter(err => err.index === i);
			if (hasErrs.length) {
				callback({
					success: false,
					message: hasErrs[0]
				});
			}
			else if (input.files && input.files[i]) {
				var fd = new FormData();
				fd.append("image", input.files[i]);
				fd.append('directory', 'includes/uploads/temp');
				$.ajax({
					data: fd,
					type: "POST",
					dataType: 'json',
					url: baseURL('panel/operations/upload-image'),
					cache: false,
					contentType: false,
					processData: false,
					success: function (response) {
						callback({
							success: true,
							message: response.url
						})
					},
					error: function (data) {
						console.error(data);
					}
				})
			}
		}

	}

	this.init = function(callback = null) {
		if(that.fileInput === '') {
			console.error('File select is not specified.');
			return false;
		}		
		that.fileInput.change(function(){
			if (this.accept === 'images') {
				that.validate(this, that.allowedImgExts, that.allowedImgSize);
			}
			if (this.accept === 'documents') {
				that.validate(this, that.allowedDocExts, that.allowedDocSize);
			}
			that.doUpload(this, function(response){
				if (!that.custom) {
					that.generateImageWrapper(response);
				} else {
					callback(response);
				}
			});
		});
		that.resetValue();
	}

	return {
		init: function(fileInput = '', removeOld = false, coverImage = false) {	
			that.coverImage = coverImage;
			that.removeOld 	= removeOld;
			that.fileInput	= fileInput;
			that.init();
		},
		custom: function (fileInput = '', callback) {
			that.fileInput = fileInput;		
			that.custom = true;
			that.init(callback)
		}
	}
});

/* =====================================
	TABULAR SECTION	
================================================================================================================ */
var TabularSection = (function($element) {
	var showContent;
	$element.find('.nav-link').on('click', function(e){
		$element.find('.nav-link').removeClass('active');
		$(this).addClass('active');
		showContent = $(this).attr('href');
		$element.find('.content-wrapper').removeClass('active');
		$element.find(showContent).addClass('active');
		e.preventDefault();
	});
});

$(document).ready(function(){
	if($('.tabular-section').length >= 1){
		TabularSection($('.tabular-section'));
	}
});

/* =====================================
	timeAgo	
================================================================================================================ */
$(document).ready(function(){
	// https://muffinman.io/javascript-time-ago-function/
	if($('.time-ago')){
		$('.time-ago').each(function() {
			$(this).html(timeAgo(new Date($(this).data('time-ago'))))
		});
	}
});

function timeAgo(dateParam) {
	if (!dateParam) { return null; }
	
	let PM_AM;
	const get12HourFormat = hr => {
		let res = '';
		if (hr >= 12) {
			PM_AM = 'PM';
			res = hr - 12
		} else {
			res = hr;
			PM_AM = 'AM';
		}
		return res === 0 ? 12 : res;
	}

	const getFormattedDate = (date, preFormatDate = false, hideYear = false) => {
		const MONTH_NAMES = [
			'January', 'February', 'March', 'April', 'May', 'June', 'July',
			'August', 'September', 'October', 'November', 'December'
		];
		const day 	= date.getDate();
		const month = MONTH_NAMES[date.getMonth()];
		const year 	= date.getFullYear();
		let hours = get12HourFormat(date.getHours());
		let minutes = date.getMinutes();

		if (minutes < 10) {
			minutes = `0${ minutes }`;
		}

		if (hours < 10) {
			hours = `0${ hours }`;
		}

		if (preFormatDate) {
			return `${preFormatDate} at ${hours} : ${minutes} - ${PM_AM}`;
		}

		if (hideYear) {
			return `${day}, ${month} at ${hours} : ${minutes} - ${PM_AM}`;
		}

		return `${day}, ${month} ${year}, at ${hours} : ${minutes} - ${PM_AM}`;
	}

	const date = typeof dateParam === 'object' ? dateParam : new Date(dateParam);
  const DAY_IN_MS = 86400000;
  const today = new Date();
  const yesterday = new Date(today - DAY_IN_MS);
  const seconds = Math.round((today - date) / 1000);
  const minutes = Math.round(seconds / 60);
  const isToday = today.toDateString() === date.toDateString();
  const isYesterday = yesterday.toDateString() === date.toDateString();
  const isThisYear = today.getFullYear() === date.getFullYear();

  if (seconds < 5) {
    return 'now';
  } else if (seconds < 60) {
    return `${ seconds } seconds ago`;
  } else if (seconds < 90) {
    return 'about a minute ago';
  } else if (minutes < 60) {
    return `${ minutes } minutes ago`;
  } else if (isToday) {
    return getFormattedDate(date, 'Today');
  } else if (isYesterday) {
    return getFormattedDate(date, 'Yesterday');
  } else if (isThisYear) {
    return getFormattedDate(date, false);
  }
  return getFormattedDate(date);
}


/* ---------------------------	
	toggle-live-edit		
------------------------------------------------------------------------------------------------------- */
$(document).ready(function(){
	if($('#toggle-live-edit')){
		$('#toggle-live-edit').on('click', function() {
			$.ajax({
				url: baseURL('panel/live-edit/toggle-edit'),
				dataType: 'json',
			})
			.done(function(response) {
				if(response.data.edit) {
					$('#toggle-live-edit')
						.html('Disable Live Edit')
						.addClass('active')	
					showMessage(response.message, 'default')
				} else {
					$('#toggle-live-edit')
						.removeClass('active')
						.html('Enable Live Edit')
					showMessage(response.message, 'alert')
				}
			})
		});
	}
});

/* ---------------------------	
	UNKNOWN PAGE		
------------------------------------------------------------------------------------------------------- */
function unknownPage( pageName ){
	console.log(pageName);
}

