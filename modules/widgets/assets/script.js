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

  getWidgetCommonData() {
    return {
      accessor_name: document.getElementById('accessor-name').value,
      visibility: document.getElementById('visibility').checked ? 'on' : 'off',
      featured: document.getElementById('featured').checked ? 'on' : 'off',
      language: document.getElementById('language').value
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
    .then(() => {
      showMessage('Widget data saved', 'default');
      this.hideOverlay();
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