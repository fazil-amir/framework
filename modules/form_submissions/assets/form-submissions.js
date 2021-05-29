class FormSubmissions {
  constructor() {
    this.trTmplLoc = baseURL('modules/form_submissions/assets/form-submissions-tr-tmpl.html');
    this.modalTmplLoc = baseURL('modules/form_submissions/assets/form-submission-modal-body-tmpl.html');

    this.apiURL = baseURL('panel/form-submissions/get-submission-data');
    this.deleteURL = baseURL('panel/form-submissions/delete-submission');
    this.searchURL = baseURL('panel/form-submissions/search-submission');

    this.trContainer = document.getElementById('form-submission-row-container');
    this.modalBody = document.querySelector('#form-submission-modal .modal-body');
    this.searchResultContainer = document.querySelector('#form-submission-result');
    this.searchInput = document.querySelector('#form-submission-search');
    this.counterSpan = document.querySelector('#count-placeholder');
    
    this.currAccessor = document.body.querySelector('[data-accessor-name]').dataset.accessorName;
    
    this.rowData = [];
    
    this.trTmpl = null;
    this.modalBodyTmpl = null;

    this.page = 1;
    this.size = 13;
    
    this.init();
  }

  // INIT CALLS
  init() {
    this.handelSearch();
    this.fetchTrTemplates().then(() => {
      // Load initial data upon page load
      this.getSubmissionData('0').then(({ data = [], allCount }) => {
        data.forEach((_data) => {
          this.mapDataAndRenderRow(_data);
        });
        this.initPagination(allCount);
      });
    });
  }

  mapDataAndRenderRow(data) {
    if(data){
      let tmpl = this.trTmpl;

      const rowID = `row-id-${data.sub_id}`
      tmpl = this.findAndReplace(tmpl, 'ROW_ID', rowID);

      tmpl = this.findAndReplace(tmpl, 'SUB_ID', data.sub_id);
      tmpl = this.findAndReplace(tmpl, 'SUBJECT', data.subject);
      tmpl = this.findAndReplace(tmpl, 'NAME', data.fullname);
      tmpl = this.findAndReplace(tmpl, 'EMAIL', data.email);
      tmpl = this.findAndReplace(tmpl, 'PHONE', data.phone);
      tmpl = this.findAndReplace(tmpl, 'DATE', this.getFormatedDate(data.delivered_on));
      tmpl = this.findAndReplace(tmpl, 'LINK', this.getPageURL(data.page_url));
      this.renderTrRow(tmpl);
      this.handleTrRowClick(rowID);
    }
  }

  getPageURL(link = '/') {
    return `<a href='${link}' target='_blank'>Click Here</a>`
  }

  renderTrRow(tmpl) {
    this.trContainer.insertAdjacentHTML('beforeend', tmpl);
  }

  fetchTrTemplates() {
    window.toggleLoading();
    const rowsTmplPromise = fetch(this.trTmplLoc, {
      headers: {  'Cache-Control': 'no-cache' }
    })
    .then(response => response.text())
    .then(text => {
      this.trTmpl = text;
      return true;
    });
    
    const modalTmplPromise = fetch(this.modalTmplLoc, {
      headers: {  'Cache-Control': 'no-cache' }
    })
    .then(response => response.text())
    .then(text => {
      this.modalBodyTmpl = text;
      return true;
    });

    return Promise.all([rowsTmplPromise, modalTmplPromise]).then(function(values) {
      window.toggleLoading(false);
    });
  }
  
  getSubmissionData(newPage = null) {
    const p = newPage !== null ? newPage : this.page;
    window.toggleLoading();
    const URL = `${this.apiURL}/${this.currAccessor}/${p}/${this.size}`;
    return fetch(URL)
      .then(res => res.json())
      .then(res => {
        if(res.success) {
          this.trContainer.innerHTML = '';
          this.renderSubmissionCounter({
            total: res.allCount,
            showing: res.currCount
          });
          this.rowData = res.data;
          if (res.allCount === 0) {
            this.showNoSubmissionView();
          } else {
            this.showHasSubmissionView();
          }
          return Promise.resolve(res);
        }
        else {
          console.error(res);
          showMessage('Something went wrong');
        }
      }).catch(err => {
        console.error(err);
        showMessage('Something went wrong');
        return Promise.reject(false);
      }).finally(() => {
        window.toggleLoading(false);
      })
  }

  // FULL DETAIL MODAL AND DELETE ACTIONS 
  handleTrRowClick(elem, dataset = this.rowData) {
    setTimeout(() => {
      const row = document.getElementById(elem);
      const subID = row.getAttribute('data-sub-id');
      if (row){
        row.addEventListener('click', (e) => {
          if (!e.target.classList.contains('cms-delete-trigger')) {
            const item = dataset.find(d => d.sub_id === subID);
            this.openModal(item);
          } else {
            this.handleDelete(subID, e);
          }
        })
      }
    }, 500);
  }

  openModal(data) {
    this.mapDataAndRenderModalBody(data);
    $("#form-submission-modal").modal()
  }

  mapDataAndRenderModalBody(data) {
    if(data){
      let tmpl = this.modalBodyTmpl;
      tmpl = this.findAndReplace(tmpl, 'SUB_ID', data.sub_id);
      tmpl = this.findAndReplace(tmpl, 'SUBJECT', data.subject);
      tmpl = this.findAndReplace(tmpl, 'NAME', data.fullname);
      tmpl = this.findAndReplace(tmpl, 'EMAIL', data.email);
      tmpl = this.findAndReplace(tmpl, 'PHONE', data.phone);
      tmpl = this.findAndReplace(tmpl, 'URL', data.page_url);
      tmpl = this.findAndReplace(tmpl, 'LOCATION', data.location);
      tmpl = this.findAndReplace(tmpl, 'SUB_DATA', this.getSubData(data.sub_data).join(' '));
      tmpl = this.findAndReplace(tmpl, 'IP', data.id_address);
      tmpl = this.findAndReplace(tmpl, 'DATE', this.getFormatedDate(data.delivered_on));
      tmpl = this.findAndReplace(tmpl, 'LINK', this.getPageURL(data.page_url));
      this.renderModalBody(tmpl);
    }
  }
  
  getSubData(subData) {
    return JSON.parse(subData).map(d => `
      <tr class=${d.type === 'DOUBLE' ? 'double-size' : ''}>
        <td class='modal-cell-caption'>${d.caption}: </td>
        <td>${d.data}</td>
      </tr>
    `)
  }
  
  renderModalBody(tmpl) {
    this.modalBody.innerHTML = '';
    this.modalBody.insertAdjacentHTML('beforeend', tmpl);
  }

  handleDelete(subID, event) {
    popup.confirm({
      content: 'Are you sure you want to delete this submission?',
      backdrop_close: false,
    }, (param) => {
      if(param.proceed) {
        this.postDeleteAPI(subID);
        event.target.parentNode.parentNode.remove()
      }
    });
  }

  postDeleteAPI(subID) {
    const URL = baseURL(`panel/operations/push-delete/${id}`);
    fetch(URL, {
      method: 'POST',
      body: JSON.stringify({ subID: subID })
    })
    .then(res => res.json())
    .then(res => {
      console.log(res);
    })
  }


  // SEARCH UI
  handelSearch() {
    this.searchInput.addEventListener('keyup', e => {
      setTimeout(() => {
        const term = e.target.value.trim();
        if (term && term.length > 4) {
          this.getSearchData(term).then((res = []) => {
            if (res.length) {
              this.renderSearchItems(res);
              this.toggleSearchResultContainer();
            } else {
              this.toggleSearchResultContainer(false);
            }
          })
        } else {
          this.toggleSearchResultContainer(false);
        }
      }, 800);
    })
  }

  renderSearchItems(items) {
    const result = items.map(item => {
      const rowID = `search-row-id-${item.sub_id}`;
      this.handleTrRowClick(rowID, items);
      return `
        <tr id="${rowID}" data-sub-id="${item.sub_id}">
          <td>${item.fullname}</td>
          <td>${item.email}</td>
          <td>${item.phone}</td>
          <td>${this.getFormatedDate(item.delivered_on)}</td>
        </tr>
      `
    });

    const tbody = this.searchResultContainer.querySelector('table tbody');
    tbody.innerHTML = '';
    tbody.insertAdjacentHTML('beforeend', result.join(' '));

  }

  getSearchData(term) {
    const URL = `${this.searchURL}/${this.currAccessor}/${term}`
    return fetch(URL)
      .then(res => res.json())
      .then(res => {
        return Promise.resolve(res);
      })
  }

  toggleSearchResultContainer(flag = true) {
    if(flag) {
      this.searchResultContainer.classList.add('show')
    } else {
      this.searchResultContainer.classList.remove('show')
    }
  }


  // UTILS
  findAndReplace(tmp, f, r){
		const value = `{{${f}}}`;
		return tmp.replace(value, r).replace(value, r).replace(value, r)
  }

  initPagination(total) {
    $('#pagination-container').pagination({
      items: total,
      itemsOnPage: this.size,
      onPageClick:(num) => {
        this.page = this.size * (num - 1);
        this.getSubmissionData().then(({ data = [] }) => {
          data.forEach((_data) => {
            this.mapDataAndRenderRow(_data);
          });
        });
      }
    });
  }

  getFormatedDate(d) {
    return timeAgo(d);
  }

  renderSubmissionCounter({ total, showing}) {
    this.counterSpan.innerHTML = `${showing}/${total}`;
  }

  showNoSubmissionView() {
    $('#no-submission-view').css({
      display: 'flex'
    });
  }

  showHasSubmissionView(){
    $('#has-submission-view').show();
  }
  
}

$('document').ready(function () { 
  new FormSubmissions(); 
});