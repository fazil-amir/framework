const LiveEdit = (function(){
	this.$editKey = $('[data-live-edit-id]')

	this.$startBtn;
	this.$saveBtn;
	this.$wrapper;
	this.$resetBtn;

	var that = this;

	this.init = function(){
		this.renderElements();
		this.startEditing();
	};

	this.setSuccessMessage = function(){
		var $messageWrapper = $('<div />', {
			class: 'message-wrapper',
			html: 'Page data saved'
		}).appendTo( this.$wrapper );

		setTimeout( function(){			
			$messageWrapper.remove();
		}, 4000)
	}

	this.startEditing = function () {
		console.log('Editing started')
		this.$editKey.attr('contenteditable', true);
		this.$editKey.off("click");

		this.$editKey.on('click', function(e){
			e.preventDefault();
		});

		this.$editKey.on('keydown', function(e) {
			e.target.setAttribute('touched', true);
			if (e.keyCode === 13) {			
			  document.execCommand('insertHTML', false, '<br><br>');
				return false;
			}
		});

		this.$startBtn.hide();
		this.$saveBtn.show();
		this.$resetBtn.show();
	};

	this.saveEditing = function () {
		this.$saveBtn.attr('disabled', 'disabled');
		console.log('Saving data');
		var formData = new FormData();
		formData.append('page-name', $('main').data('page-name') );
		var data = [];
		this.$editKey.each( function(){
			if ($(this).attr('touched')) {
				data.push({
					[$(this).data('live-edit-id')]: $(this).html()
				})
			}
		});
		formData.append('data', JSON.stringify( data ) )
		$.ajax({
			method: 'POST',
			url: baseURL('panel/live-edit/client/save'),
			data 		: formData,
			cache       : false,
			contentType : false,
			processData : false,	
			dataType	: 'json',
		})
		.done(function(){
			that.$editKey.removeAttr('contenteditable');
			that.$editKey.off('click');
			that.$startBtn.show();
			that.$saveBtn.hide();
			that.$resetBtn.hide();
			that.$saveBtn.removeAttr('disabled');
			that.setSuccessMessage();
		});		
	};

	this.renderElements = function (){
		var $startBtn = $('<button />',{
			html : 'Start Editing',
			class: 'button start',
		})
		.on('click', function(){			
			that.startEditing();
		});

		var $saveBtn = $('<button />', {
			html : 'Save Editing',
			class: 'button save',
		})
		.on('click', function(){
			that.saveEditing();
		});

		var $resetBtn = $('<button />', {
			html : 'Reset',
			class: 'button reset',
		})
		.on('click', function(){
			that.resetEditing();
		});

		var $wrapper = $('<div />', {			
			class : 'live-edit-wrapper',
		}).append( 
			$('<div />', {
				class: 'button-wrapper'
			}).append($startBtn, $saveBtn, $resetBtn)
		)
			
		$('body')
			.append($wrapper)
			.css({
				paddingBottom: $wrapper.outerHeight()
			});

		this.$startBtn 	= $startBtn;
		this.$saveBtn 	= $saveBtn;
		this.$wrapper 	= $wrapper;
		this.$resetBtn 	= $resetBtn;

	}

	this.resetEditing = function(){
		window.location = window.location.href;
		this.$startBtn.show();
		this.$saveBtn.hide();
		this.$resetBtn.hide();
	}

	this.init();
	return;
});

new LiveEdit();