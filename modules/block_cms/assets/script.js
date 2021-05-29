$('document').ready(function () {
	var pageName = $('[data-page-name]').data('page-name');
	switch (pageName) {
		case "BLOCK_CMS_CATEGORIES":
		case "BLOCK_CMS_POSTS": {
			$(".form-records").tablesorter();

			new DeleteEntry(".cms-delete-trigger");
			new PushToggle(".cms-featured");
			new PushToggle(".cms-visibility");

			var paging = new MakePagination();
			paging.staticPagination($(".form-records"), 10);

			var edit = new MakeEditable();
			edit.init($(".cms-edit-trigger"));
		}	break;

		case "BLOCK_CMS_ADD_POST_VIEW": {
			$("select.form-control").selectpicker();
			
			var input = new ModernFileInput();
			input.init($("#image-gallery-input"));

			var cms = new BlockCMS();
			cms.initBannerImage();
			cms.initAddBlocks();
			cms.initSortable();
			cms.initRemoveBlock();
			cms.initSubmitPost();
			cms.initDefaultText();
		} break;

		case "BLOCK_CMS_ADD_CATEGORY_VIEW": {
			$("select.form-control").selectpicker();

			var input = new ModernFileInput();
			input.init($("#banner-image"), true, true);

			$("#submit-category").on("click", function () {
				form.init($(this).data("form"), {
					buttonSelector: "#submit-category",
					buttonText: "Please Wait..."
				},
					function (response) {
						if (response.success === 1) {
							if (response.operation == "INSERT") {
								$($("#submit-category").data("form"))
									.attr(
										"action",
										baseURL("panel/block-cms/category/add-update/" + response.data.catID)
									);
							}
							showMessage(response.message, "default");
						} else {
							showMessage(response.message, "error");
						}
					}
				);

				form.validate();
				form.submit();
			});
		} break;
	}
});


var BlockCMS = (function () {

	this.$container = $('#page-data-container');
	this.CM_Instances = [];
	var that = this;

	this.initDefaultText = function () {
		var url = $("[data-source]").data("source");
		if (!url) {
			return false
		}
		$.ajax({
			cache: false,
			url: url,
			dataType: "json",
			success: function (data) {
				data.forEach((item, i) => {
					switch (Object.keys(item)[0]) {
						case "PAGE_BANNER":
							that.setPageHeaderData(item.PAGE_BANNER);
						break;
						case "TEXT":
							var size = [];
							item.TEXT.forEach(col => {
								size.push(Object.entries(col)[0][0].split("-")[2]);
							})
							that.addTextBlock(size.join(","), item.TEXT);
						break;
						case "USER_HTML":
							that.addUserHTML(item.USER_HTML);
						break;
					}
				})
			}
		});
	}

	this.initBannerImage = function () {
		var bannerInput = new ModernFileInput();
		bannerInput.custom($('#intro-banner-image'), function (result) {
			if (result.success) {
				$('#blog-intro-banner').attr('src', result.message);
			} else {
				showMessage(result.message.message, 'error');
			}
		});
	};

	this.initAddBlocks = function () {
		$('.add-blog-item').on('click', function () {
			switch ($(this).data("block-type")) {
				case "JUMBOTRON":
					that.addJumbotron();
					break;

				case "HIGHLIGHTER":
					that.addHighlighter();
					break;

				case "TEXT":
					that.addTextBlock($(this).data("block-size"));
					break;

				case "USER_HTML":
					that.addUserHTML();
					break;
			}
		});
	};

	this.initSortable = function () {
		$(function () {
			$("#page-data-container").sortable({
				handle: '.move-handle',
				axis: 'y',
			});
		});
	}

	this.initRemoveBlock = function () {
		$('body').on('click', '.remove', function () {
			$(this).parents('.block-container').remove();
		})
	};

	this.initSubmitPost = function () {
		
		$('#submit-post').on('click', function (e) {
			var form = new ProcessForm();
			var metaData 			= {};
			var richData 			= [];
			var imageGallery 	= [];

			/* **********************************
				VALIDATE META DATA
			********************************** */
			form.init($(this).data('form'), {
				'buttonSelector': '#submit-post',
				'buttonText': 'Please Wait...'
			});

			if (!form.validate() ) {	
				return false;
			}

			/* **********************************
				GET PAGE DATA
			********************************** */
			var cmInsIndex = 0
			$('.block-container').each(function () {
				var $this = $(this);
				switch ($(this).data('block-type')) {
					case 'TEXT':
						richData.push(that.getTextData($this));
						break;
					case 'PAGE_BANNER':
						richData.push(that.getPageHeaderData($this));
						break;
					case 'USER_HTML':
						richData.push(that.getUserHTML(cmInsIndex++));
						break;
				}
			});

			/* **********************************
				GET IMAGE GALLERY
			********************************** */
			$($(this).data('form')).find('[type="file"]').each(function(){
				$(this).parent().parent().find('div.preview-images img').each(function(image){
					imageGallery.push($(this).attr('src'));
				});	
			});

			/* **********************************
				ADD META DATA
			********************************** */
			metaData = {
				'seoTitle': $('#seo-title').val(),
				'seoURI': $('#seo-uri').val(),
				'seoKeywords': $('#seo-keywords').val(),
				'seoDescription': $('#seo-description').val(),

				'pageTitle': $('#page-title').val(),
				'pageType': $('input[name="page-type"]:checked').val(),
				'shortDescription': $('#shot-description').val(),
				'pageAuthor': $('#page-author').val(),

				'visibility': $('#visibility:checked').val() ? 'on' : 'off',
				'featured': $('#featured:checked').val() ? 'on' : 'off',

				'language': $('#language').val(),
				'categories': $('#category').val(),
			};

			/* **********************************
				SEND TO AJAX
			********************************** */
			that.doAjax({
				method: 'POST',
				URL: $($(this).data('form')).attr('action'),
				formData: [{
					metaData,
					richData,
					imageGallery
				}],
				callback: (response) => {
					if (response.success == 1) {
						showMessage(response.message, 'default');
					} else {
						showMessage(response.message, 'error');
					}
				}
			})
			e.preventDefault();
		});
	}

	this.doAjax = function (params = { method: 'POST', URL: '', formData: '', callback: '' }) {
		$.ajax({
			method: params.method,
			data: { data: params.formData },
			url: params.URL,
			dataType: 'json',
		})
		.done(res => {
			params.callback && params.callback(res);
		})
		.fail(err => {
			console.error(err);
		})
	}


	this.addJumbotron = function (data = '') {
		var html = `
			<div class="container jumbotron" data-block-type="JUMBOTRON" >
				<div class="col-sm-6">
					<input type="text" id="headline" />
					<textarea id="content"></textarea>
				</div>
				<div class="col-sm-6">
					<table class="form-table">
						<tr>
							<td class="input">
								<label class="file">
									Change Banner
									<input type="file" name="intro-banner-image" class="form-control validate" id="intro-banner-image">
								</label>
							</td>
						</tr>
					</table>
				</div>
			</div>
		`;
		that.$container.append(html);
	}

	this.addHighlighter = function (data = '') {
		alert('addHighlighter');
	}

	this.addUserHTML = function (data = '') {
		var id = "user-html-content-" + $(".user-html-content").length + 1;
		var html = `
			<div class="block-container user-html" data-block-type="USER_HTML" >
				<span class="move-handle icon move"></span>
				<span class="remove icon delete"></span>
				<textarea class="user-html-content" id="${id}"></textarea>				
			</div>
		`;

		that.$container.append(html);
		var cm = CodeMirror.fromTextArea(document.getElementById(id), {
      mode: "xml",
      htmlMode: true,
      theme: "lucario",
			lineNumbers: true,
			matchBrackets: true,
			indentUnit: 2,
    });
		cm.setSize(null, 300);
		that.CM_Instances.push(cm);
		if (data) {
			cm.setValue(data)
		}
		setTimeout(function () {
			cm.refresh();
		}, 1000)
	}

	this.addTextBlock = function (size, data = '') {
		var cols = '';
		if (size == 12) {
			var id = that.getID();
			cols += `
				<div class="col-md-12" data-col-size="col-md-12" >
					<textarea id="${id}" class="rich-text-editor" />
				</div>
			`;
			that.bindSummernote(id);
			if (data) {
				var key = Object.keys(data[0])
				that.bindSummernoteContent(id, data[0][key]);
			}
		}
		else {
			size = size.split(',');
			for (var i = 0; i < size.length; i++) {
				var id = that.getID() + '_' + i;
				cols += `
					<div class="${that.getBootstrapCols(size[i])}" data-col-size="${that.getBootstrapCols(size[i])}">
						<textarea id="${id}" class="rich-text-editor" />
					</div>
				`;
				that.bindSummernote(id);
				if (data) {
					var key = Object.keys(data[i])
					that.bindSummernoteContent(id, data[i][key]);
				}
			};
		}

		var html = `
			<div class="block-container text-block" data-block-type="TEXT" >
				<span class="move-handle icon move"></span>
				<span class="remove icon delete"></span>
				<div class="row">${cols}</div>
			</div>
		`;

		that.$container.append(html);

	};


	this.getTextData = function ($element) {
		var temp = [], error = [];
		var $element = $element.find('[data-col-size]');
		for (var i = 0; i < $element.length; i++) {
			temp.push({
				[$element.eq(i).attr('class')]: $element.eq(i).find('.rich-text-editor').summernote('code')
			});
		}
		return {
			'TEXT': temp
		};
	};

	this.getUserHTML = function (idx) {
		return {
			'USER_HTML': that.CM_Instances[idx].getValue()
		}
	}

	this.getPageHeaderData = function ($element) {
		return {
			PAGE_BANNER: {
				'headline': $element.find('#blog-intro-text').val(),
				'subHeadline': $element.find('#blog-sub-text').val(),
				'background': $element.find('#blog-intro-banner').attr('src')
			}
		}
	}

	this.setPageHeaderData = function (data) {
		$("#blog-intro-text").val(data.headline);
		$("#blog-sub-text").val(data.subHeadline);
		$("#blog-intro-banner").attr("src", data.background);
	}


	this.bindSummernote = function (ID) {
		setTimeout(function () {
			$('#' + ID).summernote({
				toolbar: [
					['style', ['format', 'bold', 'italic', 'underline', 'clear']],
					['style', ['style', 'formatH2']],
					['para', ['ul', 'ol', 'paragraph']],
					['Misc', ['undo', 'undo']],
					['insert', ['video', 'picture', 'table']]
				],
				// airMode: true,
				height: 'auto',
				callbacks: {
					onImageUpload: function (image) {

						var fd = new FormData();
						var postID = $('#' + ID).parents('form').attr('action').split("/").pop().toLowerCase().replace(' ', '')
						fd.append("image", image[0]);
						fd.append('directory', 'includes/uploads/cms/posts/' + postID + '/images');
						$.ajax({
							data: fd,
							type: "POST",
							dataType: 'json',
							url: baseURL('panel/operations/upload-image'),
							cache: false,
							contentType: false,
							processData: false,
							success: function (response) {
								$('#' + ID).summernote("insertImage", response.url);
							},
							error: function (data) {
								console.log(data);
							}
						});
					}
				}
			});

			$('.note-editor .dropdown-menu li').each(function () {
				if ($(this).find('a').data('value') == 'pre' ||
					$(this).find('a').data('value') == 'h1' ||
					$(this).find('a').data('value') == 'h4' ||
					$(this).find('a').data('value') == 'h4' ||
					$(this).find('a').data('value') == 'h5' ||
					$(this).find('a').data('value') == 'h6') {
					$(this).remove();
				}
				if ($(this).find('a').data('value') == 'h2') {
					$(this).find('a').html('<p>Heading 1<p>');
				}
				if ($(this).find('a').data('value') == 'h3') {
					$(this).find('a').html('<p>Heading 2<p>');
				}
				if ($(this).find('a').data('value') == 'p') {
					$(this).find('a').html('<p>Paragraph</p>');
				}
				if ($(this).find('a').data('value') == 'blockquote') {
					$(this).find('a').html('<p>Blockquote</p>');
				}
			});
		}, 0);

	}

	this.bindSummernoteContent = function (ID, content) {
		setTimeout(function () {
			$('#' + ID).summernote('code', content)
		}, 1)
	}

	this.getBootstrapCols = function (size) {
		switch (size) {
			case '12': return 'col-sm-12';
			case '11': return 'col-sm-11';
			case '10': return 'col-sm-10';
			case '9': return 'col-sm-9';
			case '8': return 'col-sm-8';
			case '7': return 'col-sm-7';
			case '6': return 'col-sm-6';
			case '5': return 'col-sm-5';
			case '4': return 'col-sm-4';
			case '3': return 'col-sm-3';
			case '2': return 'col-sm-2';
			case '1': return 'col-sm-1';
		}
	};

	this.getID = function () {
		var textID = 'rich-block-count-0';
		$('textarea').each(function (i) {
			textID = 'rich-block-count-' + i;
		});
		return textID;
	}


	this.setErroMsg = function ($this, value) {
		that.process = false;
		var msg = '';
		switch (value.error) {
			case 'EMPTY': msg = 'This field is required'; break;
			case 'MIN': msg = 'Does not meet minimum character length'; break;
			case 'MAX': msg = 'The value you entered was too big'; break;
		}
		if (value.type == 'SUMMERNOTE') {
			value.element.append('<span class="error">' + msg + '</span>');
		} else {
			$this.append('<span class="error">' + msg + '</span>');
		}
	}

	this.unsetErrorMsg = function () {
		this.process = true;
		$('.error').remove();
	}

});
