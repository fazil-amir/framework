$('document').ready(function () {
  var pageName = $('[data-page-name]').data('page-name');
  switch (pageName) {
		case "WIDGET_VIEW_ALL_VIEW": {
      const wid = new Widget();
      wid.initPagination();
      wid.initTableSortable();
      wid.initPushToggle();
    }
  }
})


class Widget {
  constructor() {
    this.form = document.getElementById('widget-submit');
    this.content = document.getElementById('widget-content-container');
    this.addBtn = document.getElementById('add-btn');
  }
  
  initPagination() {
    const paging = new MakePagination();
    paging.staticPagination($(".form-records"), 10);
  }

  initTableSortable() {
    $(".form-records").tablesorter();
  }

  initPushToggle() {
    new DeleteEntry(".widget-delete-trigger");
		new PushToggle(".widget-featured");
		new PushToggle(".widget-visibility");
  }


  // Will be used by child class

  getWidgetCommonData() {
    return {
      accessor_name: document.getElementById('accessor-name').value,
      visibility: document.getElementById('visibility').checked ? 'on' : 'off',
      featured: document.getElementById('featured').checked ? 'on' : 'off',
      language: document.getElementById('language') ? document.getElementById('language').value : undefined
    }
  }

  saveWidget(data) {
    this.showOverlay();
    const apiURL = this.form.getAttribute('action');
    const widgetData = {
      specific: data,
      common: this.getWidgetCommonData()
    }
    fetch(apiURL, {
      method: "POST",
      headers: {
        'Accept': 'application/json',
      },
      body: JSON.stringify(widgetData)
    })
    .then(res => res.json())
    .then(res => {
      this.hideOverlay();
      if(res.error) {
        showMessage(res.message, "error");
      } else {
        showMessage(res.message, 'default');
      }
    }).catch(err => {
      console.error(`[WIDGET ERROR] : ${err}`)
      this.hideOverlay();
    })
  }
				
  showOverlay() {
    $('.overlay').addClass('show');
  }
  
  hideOverlay() {
    $('.overlay').removeClass('show');
  }

  findAndReplace = (tmp, f, r) => {
		const value = `{{${f}}}`;
		return tmp.replace(value, r).replace(value, r)
  }
  
  updateCount = (domElem) => {
		for(let i = 0; i < domElem.length; i++) {
			const elem = domElem[i];
			elem.querySelector('.custom-header span').innerHTML = i + 1
		}
  }
  
  initPhoto = (testimonialID, removeOld = true, coverImage = false) => {
		const photo = new ModernFileInput();
		photo.init($(`#${testimonialID}`), removeOld, coverImage);
		return photo;
	}

  fetchTemplate = (templateLocation) => {
		return fetch(templateLocation, {
			headers: {
				'Cache-Control': 'no-cache'
			}
		})
			.then(response => response.text())
			.then(text => {
				return Promise.resolve(text)
			})
  }

  handleWidgetItemAddClick = (render = () => {}, parentDom) => {
		this.addBtn.addEventListener('click', () => {
      render();
      setTimeout(() => {
        this.updateCount(parentDom)
      }, 100);
    });
  }
  
  handleWidgetItemDelete = (elem = '', parentDom) => {
		if (document.getElementById(elem)) {
			document.getElementById(elem).addEventListener('click', (e) => {
				popup.confirm({
					content: 'Are you sure?',
					backdrop_close: false,
				}, (param) => {
					if(param.proceed) {
            e.target.parentNode.remove()
            this.updateCount(parentDom)
					}
				});
			});
		}
  }
  
  handleContentCollapse(e = '', collapse = false) {
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
  
  collapseOnlyLast(domElem) {
		setTimeout(() => {
      domElem[domElem.length - 1].classList.toggle('toggle-collapse');
		}, 400)
	}
  
  collapseErrorContent = (domElem) => {
    for (let i = 0; i < domElem.length; i++) {
      const elem = domElem[i].querySelector('.err-message');
      if(elem) {
        domElem[i].classList.remove('toggle-collapse')
      }
    }
  }

  getRichDataParsed() {
    const url = this.form.getAttribute('data-source');
    if (url) {
      return fetch(url, {
        headers: {
          'Cache-Control': 'no-cache'
        }
      })
        .then(response => response.json())
        .then(text => {
          return Promise.resolve(text)
        })
    }
    return Promise.resolve(false)
  }

}