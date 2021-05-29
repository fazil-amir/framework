$('document').ready(function () {
  $("select.form-control").selectpicker();
  const CKV = new commonUI();
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
      CKV.submit();
    } else {
      CKV.handleError();
		}
  });
});


class commonUI extends Widget {
	constructor() {
		super();
		this.CKV_Counter = 1;
		this.templateLocation = baseURL('modules/widgets/assets/common-ui/widget-common-ui-tmpl.html');
		this.CKV_Container = document.getElementById('CKV-widget-container');
		this.CKV_Item = document.getElementsByClassName('CKV-item');
		this.collapseHandle	= document.getElementsByClassName('collapse-handle');

		this.preloadWidgetData();
		this.handleWidgetItemAddClick(this.renderWidgetItem, this.CKV_Item);
		this.initSortable();
	}

	preloadWidgetData = () => {
		this.getRichDataParsed().then(preData => {
			if(preData) {
				preData.map(value => { 
					this.renderWidgetItem(value) 
				});
				this.collapseOnlyLast(this.CKV_Item);
			} else {
				this.renderWidgetItem();
			}
		});
  }

	renderWidgetItem = (value = null) => {
		this.fetchTemplate(this.templateLocation).then(tmp => {
			const CKY_ICON_ID = `CKV-icon-${this.CKV_Counter}`;
			const CKY_BG_ID = `CKV-BG-${this.CKV_Counter}`;
			const deleteID = `CKV-delete-${this.CKV_Counter}`;
			const collapseID = `CKV-collapse-${this.CKV_Counter}`;

			// Assign dynamic ids
			tmp = this.findAndReplace(tmp, 'CKV_ITEM_COUNT', this.CKV_Counter);
			tmp = this.findAndReplace(tmp, 'CKV_ITEM_ICON_ID', CKY_ICON_ID);
			tmp = this.findAndReplace(tmp, 'CKV_ITEM_BG_ID', CKY_BG_ID);
			tmp = this.findAndReplace(tmp, 'CKV_ITEM_DELETE_ID', deleteID);
			tmp = this.findAndReplace(tmp, 'CKV_ITEM_COLLAPSE_ID', collapseID);

			// Inject values
			const headline = value && value.headline ? value.headline : ''
			tmp = this.findAndReplace(tmp, 'CKV_ITEM_HEADLINE', headline);

			const sub_headline = value && value.sub_headline ? value.sub_headline : ''
			tmp = this.findAndReplace(tmp, 'CKV_ITEM_SUB_HEADLINE', sub_headline);

			const caption = value && value.caption ? value.caption : ''
			tmp = this.findAndReplace(tmp, 'CKV_ITEM_CAPTION', caption);

			const sub_caption = value && value.sub_caption ? value.sub_caption : ''
			tmp = this.findAndReplace(tmp, 'CKV_ITEM_SUB_CAPTION', sub_caption);

      const button_link = value && value.button_link ? value.button_link : ''
			tmp = this.findAndReplace(tmp, 'CKV_ITEM_BUTTON_LINK', button_link);

			const button_caption = value && value.button_caption ? value.button_caption : ''
			tmp = this.findAndReplace(tmp, 'CKV_ITEM_BUTTON_CAPTION', button_caption);

			const ckv_key1 = value && value.ckv_key1 ? value.ckv_key1 : ''
			tmp = this.findAndReplace(tmp, 'CKV_ITEM_CK_1', ckv_key1);

			const ckv_key2 = value && value.ckv_key2 ? value.ckv_key2 : ''
			tmp = this.findAndReplace(tmp, 'CKV_ITEM_CK_2', ckv_key2);

			const ckv_key3 = value && value.ckv_key3 ? value.ckv_key3 : ''
			tmp = this.findAndReplace(tmp, 'CKV_ITEM_CK_3', ckv_key3);
			
			const visibility = value && value.visibility ? value.visibility : ''
			tmp = this.findAndReplace(tmp, 'CKV_ITEM_VISIBILITY', this.getItemVisibilityState(visibility));

			const message = value && value.message ? value.message : ''
			tmp = this.findAndReplace(tmp, 'CKV_ITEM_MESSAGE', message);

			const icon = value && value.icon ? value.icon : ''
			tmp = this.findAndReplace(tmp, 'CKV_ITEM_ICON', this.getImage(icon));

      const bg = value && value.bg ? value.bg : ''
			tmp = this.findAndReplace(tmp, 'CKV_ITEM_BG', this.getImage(bg));

			// add to dom
			this.CKV_Container.insertAdjacentHTML('beforeend', tmp);

			this.initPhoto(CKY_ICON_ID);
			this.initPhoto(CKY_BG_ID);
			this.handleWidgetItemDelete(deleteID, this.CKV_Item);
			this.handleContentCollapse(collapseID, value);
			this.CKV_Counter++;
		});
	}

	initSortable() {
		$("#CKV-widget-container").sortable({
			handle: 'span.move-handle',
			axis: 'y',
			update: () => this.updateCount(this.CKV_Item)
		});
	}

	getImage = (src = '') => {
		if(!src) return '';
		return `<div class="preview-images"><img src="${src}"><span class="icon delete"></span></div>`
	}

	getItemVisibilityState(v) {
		if(v === 'on') {
			return `checked="checked"`
		}
	}

	getCKVWidgetData = () => {
		const data = [];
		for(let i = 0; i < this.CKV_Item.length; i++){
			const input = this.CKV_Item[i].getElementsByTagName('input');
			const textarea = this.CKV_Item[i].getElementsByTagName('textarea');
			const icon = this.CKV_Item[i].querySelectorAll('.input')[13].querySelector('.preview-images img')
			const bg = this.CKV_Item[i].querySelectorAll('.input')[14].querySelector('.preview-images img')

			data.push({
				headline: input[0].value,
				sub_headline: input[5].value,
				caption: input[1].value,
				sub_caption: input[6].value,
				button_link: input[2].value,
				button_caption: input[7].value,
				ckv_key1: input[3].value,
				ckv_key2: input[8].value,
				ckv_key3: input[4].value,
				message: textarea[0].value,
				visibility: input[9].checked ? 'on' : 'off',
				icon: icon ? icon.getAttribute('src') : '',
				bg: bg ? bg.getAttribute('src') : ''
			});
		}
		return data;
	}

	handleError() {
		this.collapseErrorContent(this.CKV_Item);
	}

	submit = () => {
		this.saveWidget(this.getCKVWidgetData());
	}

}