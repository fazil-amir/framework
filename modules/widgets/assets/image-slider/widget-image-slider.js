$('document').ready(function () {
  var pageName = $('[data-page-name]').data('page-name');
	$("select.form-control").selectpicker();
	
	switch (pageName) {
		case "WIDGET_IMAGE_SLIDER_ADD_VIEW": {
			const slider = new ImageSlider();
			$("#submit-widget").on("click", function () {
				form.init($(this).data("form"), {
					buttonSelector: "#submit-widget",
					buttonText: "Please Wait..."
				},
					function (response) {
						if (response.success === 1) {
							showMessage(response.message, "default");
						} else {
							showMessage(response.message, "error");
						}
					}
				);
				if (form.validate()) {
					slider.submit();
				}
			});

		} break;
	}
});

class ImageSlider extends Widget {
	constructor() {
		super();
		this.slideCounter = 1;
		this.templateLocation = baseURL('modules/widgets/assets/image-slider/widget-image-slider-tmpl.html');
		this.sliderContainer  = document.getElementById('slider-slides');
		this.slideElements    = document.getElementsByClassName('slide');
		this.addSlideBtn			= document.getElementById('add-slide-btn');
		this.collapseHandle		= document.getElementsByClassName('collapse-handle');

		this.preloadSlides();
		this.handleAddSlideClick();
		this.initSortable();
		this.collapseOnlyLast();
	}

	preloadSlides = () => {
		this.getRichDataParsed().then(preData => {
			if(preData) {
				preData.map(value => { this.renderSlide(value) });
			} else {
				this.renderSlide();
			}
		});
	}

	handleAddSlideClick = () => {
		this.addSlideBtn.addEventListener('click', () => this.renderSlide());
	}

	initSliderImage = (slideID) => {
		const sliderImage = new ModernFileInput();
		sliderImage.init($(`#${slideID}`), true, true);
	}

	findAndReplace = (tmp, f, r) => {
		const value = `{{${f}}}`;
		return tmp.replace(value, r).replace(value, r)
	}

	renderSlide = (value = null) => {
		this.fetchTemplate().then(tmp => {
			const slideID = `slider-slide-image-${this.slideCounter}`;
			const deleteID = `slider-delete-${this.slideCounter}`;
			const collapseID = `slider-collapse-${this.slideCounter}`;

			// Assign dynamic ids
			tmp = this.findAndReplace(tmp, 'SLIDE_COUNT', this.slideCounter);
			tmp = this.findAndReplace(tmp, 'SLIDER_IMG_ID', slideID);
			tmp = this.findAndReplace(tmp, 'SLIDE_DELETE_ID', deleteID);
			tmp = this.findAndReplace(tmp, 'SLIDE_COLLAPSE_ID', collapseID);
			tmp = this.findAndReplace(tmp, 'SAME_PAGE_RADIO_ID', `target-radio-same-${this.slideCounter}`);
			tmp = this.findAndReplace(tmp, 'NEW_PAGE_RADIO_ID', `target-radio-new-${this.slideCounter}`);
			tmp = this.findAndReplace(tmp, 'TARGET_RADIO', `target-radio-${this.slideCounter}`);

			// Inject values
			const headline = value && value.headline ? value.headline : ''
			tmp = this.findAndReplace(tmp, 'SLIDER_HEADLINE', headline);

			const caption = value && value.caption ? value.caption : ''
			tmp = this.findAndReplace(tmp, 'SLIDER_CAPTION', caption);

			const btnLink = value && value.btn_link ? value.btn_link : ''
			tmp = this.findAndReplace(tmp, 'SLIDER_BTN_LINK', btnLink);

			const btnCaption = value && value.btn_caption ? value.btn_caption : ''
			tmp = this.findAndReplace(tmp, 'SLIDER_BTN_CAPTION', btnCaption);
			
	
			const target = value && value.target ? value.target : ''
			if (target === 'new') {
				tmp = this.findAndReplace(tmp, 'SLIDER_TARGET_SAME_PAGE', '');
				tmp = this.findAndReplace(tmp, 'SLIDER_TARGET_NEW_PAGE', 'checked="checked"');
			} else {
				tmp = this.findAndReplace(tmp, 'SLIDER_TARGET_SAME_PAGE', 'checked="checked"');
				tmp = this.findAndReplace(tmp, 'SLIDER_TARGET_NEW_PAGE', '');
			}

			const slideImage = value && value.slide_image ? value.slide_image : ''
			tmp = this.findAndReplace(tmp, 'SLIDER_IMAGE', this.getImageTemplate(slideImage));

			// add to dom
			this.sliderContainer.insertAdjacentHTML('beforeend', tmp);

			// Init slider slide image
			this.initSliderImage(slideID);
			this.handleSlideDelete(deleteID);
			this.handleSlideCollapse(collapseID, value);
			this.slideCounter++;
		});
	}

	fetchTemplate = () => {
		return fetch(this.templateLocation, {
			headers: {
				'Cache-Control': 'no-cache'
			}
		})
			.then(response => response.text())
			.then(text => {
				return Promise.resolve(text)
			})
	}

	handleSlideDelete = (elem = '') => {
		if (document.getElementById(elem)) {
			document.getElementById(elem).addEventListener('click', (e) => {
				popup.confirm({
					content: 'Are you sure?',
					backdrop_close: false,
				}, (param) => {
					if(param.proceed) {
						e.target.parentNode.remove()
					}
				});
			});
		}
	}

	handleSlideCollapse(e = '', collapse = false) {
		setTimeout(() => {
			const elem = document.getElementById(e);
			if (elem) {
				if (collapse){
					elem.parentNode.classList.add('toggle-collapse');
				}
				elem.addEventListener('click', (e) => {
					e.target.parentNode.classList.toggle('toggle-collapse');
				});
			}
		}, 100)
	}

	initSortable = () => {
		$("#slider-slides").sortable({
			handle: 'span.move-handle',
			axis: 'y',
		});
	}

	collapseOnlyLast() {
		setTimeout(() => {
			for(let i = 0; i < this.slideElements.length; i++) {
				const slide = this.slideElements[i];
				if(i !== this.slideElements.length - 1) {
					slide.classList.toggle('toggle-collapse')
				}
			}
		}, 100)
	}

	getImageTemplate = (src = '') => {
		if(!src) return '';
		return `<div class="preview-images cover-image"><img src="${src}"><span class="icon delete"></span></div>`
	}

	getSliderData = () => {
		const data = [];
		for(let i = 0; i < this.slideElements.length; i++){
			const input = this.slideElements[i].getElementsByTagName('input');
			const img = this.slideElements[i].querySelector('.preview-images img');
			data.push({
				headline: input[0].value,
				caption: input[1].value,
				btn_link: input[2].value,
				btn_caption: input[3].value,
				target: input[4].checked ? input[4].value : input[5].value,
				slide_image: img.getAttribute('src'),
			});
		}
		return data;
	}

	submit = () => {
		this.saveWidget(this.getSliderData());
	}

}