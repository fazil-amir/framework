$('document').ready(function () {
	const testimonial = new Testimonial();
	$("select.form-control").selectpicker();
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
      testimonial.submit();
    } else {
			testimonial.handleError()
		}
  });
});

class Testimonial extends Widget {
	constructor() {
		super();
		this.testimonialCounter = 1;
		this.templateLocation = baseURL('modules/widgets/assets/testimonial/widget-testimonial-tmpl.html');
		this.testimonialContainer = document.getElementById('testimonials');
		this.testimonialElements = document.getElementsByClassName('testimonial-item');
		this.collapseHandle	= document.getElementsByClassName('collapse-handle');

		this.preloadTestimonials();
		this.handleWidgetItemAddClick(this.renderTestimonial, this.testimonialElements);
		this.initSortable();
	}

	preloadTestimonials = () => {
		this.getRichDataParsed().then(preData => {
			if(preData) {
				preData.map(value => { 
					this.renderTestimonial(value) 
				});
				this.collapseOnlyLast(this.testimonialElements);
			} else {
				this.renderTestimonial();
			}
		});
	}

	renderTestimonial = (value = null) => {
		this.fetchTemplate(this.templateLocation).then(tmp => {
			const testimonialPhotoID = `testimonial-photo-${this.testimonialCounter}`;
			const deleteID = `testimonial-delete-${this.testimonialCounter}`;
			const collapseID = `testimonial-collapse-${this.testimonialCounter}`;

			// Assign dynamic ids
			tmp = this.findAndReplace(tmp, 'TESTIMONIAL_COUNT', this.testimonialCounter);
			tmp = this.findAndReplace(tmp, 'TESTIMONIAL_IMG_ID', testimonialPhotoID);
			tmp = this.findAndReplace(tmp, 'TESTIMONIAL_DELETE_ID', deleteID);
			tmp = this.findAndReplace(tmp, 'TESTIMONIAL_COLLAPSE_ID', collapseID);

			// Inject values
			const fullName = value && value.full_name ? value.full_name : ''
			tmp = this.findAndReplace(tmp, 'TESTIMONIAL_FULL_NAME', fullName);

			const designation = value && value.designation ? value.designation : ''
			tmp = this.findAndReplace(tmp, 'TESTIMONIAL_DESIGNATION', designation);

			const company = value && value.company ? value.company : ''
			tmp = this.findAndReplace(tmp, 'TESTIMONIAL_COMPANY', company);

			const location = value && value.location ? value.location : ''
			tmp = this.findAndReplace(tmp, 'TESTIMONIAL_LOCATION', location);

      const message = value && value.message ? value.message : ''
			tmp = this.findAndReplace(tmp, 'TESTIMONIAL_MESSAGE', message);

			const facebook = value && value.facebook ? value.facebook : ''
			tmp = this.findAndReplace(tmp, 'TESTIMONIAL_FACEBOOK', facebook);

			const linkedIn = value && value.linkedin ? value.linkedin : ''
			tmp = this.findAndReplace(tmp, 'TESTIMONIAL_LINKEDIN', linkedIn);

			const twitter = value && value.twitter ? value.twitter : ''
			tmp = this.findAndReplace(tmp, 'TESTIMONIAL_TWITTER', twitter);

			const website = value && value.website ? value.website : ''
			tmp = this.findAndReplace(tmp, 'TESTIMONIAL_WEBSITE', website);

			const slideImage = value && value.photo ? value.photo : ''
			tmp = this.findAndReplace(tmp, 'TESTIMONIAL_IMAGE', this.getImageTemplate(slideImage));

			// add to dom
			this.testimonialContainer.insertAdjacentHTML('beforeend', tmp);

			// Init slider slide image
			this.initPhoto(testimonialPhotoID);
			this.handleWidgetItemDelete(deleteID, this.testimonialElements);
			this.handleContentCollapse(collapseID, value);
			this.testimonialCounter++;
		});
	}

	initSortable = () => {
		$("#testimonials").sortable({
			handle: 'span.move-handle',
			axis: 'y',
			update: () => this.updateCount(this.testimonialElements)
		});
	}

	getImageTemplate = (src = '') => {
		if(!src) return '';
		return `<div class="preview-images"><img src="${src}"><span class="icon delete"></span></div>`
	}

	getSliderData = () => {
		const data = [];
		for(let i = 0; i < this.testimonialElements.length; i++){
			const input = this.testimonialElements[i].getElementsByTagName('input');
			const textarea = this.testimonialElements[i].getElementsByTagName('textarea');
			const img = this.testimonialElements[i].querySelector('.preview-images img');

			data.push({
				full_name: input[0].value,
				designation: input[1].value,
				company: input[2].value,
				location: input[3].value,
				facebook: input[4].value,
				linkedin: input[5].value,
				twitter: input[6].value,
				website: input[7].value,
				message: textarea[0].value,
				photo: img.getAttribute('src')
			});
		}
		return data;
	}

	handleError() {
		this.collapseErrorContent(this.testimonialElements);
	}

	submit = () => {
		this.saveWidget(this.getSliderData());
	}

}