//== Class definition

var DatatableDataLocalDemo = function () {
	//== Private functions
 	console.log(base_url + 'components/schools/designations/all-inactive');
	
	var datatable = $('.m_datatable').mDatatable({
		// datasource definition
		data: {
			type: 'remote',
			source: {
			  read: {
				// sample GET method
				method: 'GET',
				url: base_url + 'components/schools/designations/all-inactive',
				map: function(raw) {
				  // sample data mapping
				  var dataSet = raw;
				  if (typeof raw.data !== 'undefined') {
					dataSet = raw.data;
				  }
				  return dataSet;
				},
			  },
			},

			pageSize: 10
		},

		// layout definition
		layout: {
			theme: 'default', // datatable theme
			class: '', // custom wrapper class
			scroll: false, // enable/disable datatable scroll both horizontal and vertical when needed.
			// height: 450, // datatable's body's fixed height
			footer: false // display/hide footer
		},

		// column sorting
		sortable: false,
		ordering: false,

		pagination: true,

		search: {
			input: $('#generalSearch')
		},

		// inline and bactch editing(cooming soon)
		// editable: false,

		// columns definition
		columns: [{
			field: "designationID",
			title: "#",
			width: 50,
			sortable: false,
			textAlign: 'center',
			selector: {class: 'm-checkbox--solid m-checkbox--brand'}
		}, {
			field: "designationCode",
			title: "Code"
		}, {
			field: "designationName",
			title: "Name",
		}, {
			field: "designationDescription",
			title: "Description"
        }, {
			field: "designationModified",
			title: "Last Modified",
		}, {
			field: "designationType",
			title: "Type",
			// callback function support for column rendering
			template: function (row) {
				var class_type = '';
				var type = {
					1 : {'class': 'childhood-bg'},
					2 : {'class': 'primary-bg'}, 
					3 : {'class': 'secondary-bg'},
					4 : {'class': 'higher-bg'}
				};

				var str = '';
				for(var x=0; x<row.designationTypeID.length; x++){
					str = row.designationTypeName[x].charAt(0);
					class_type += '<span class="m-badge ' + type[row.designationTypeID[x]].class + ' m-badge--wide">' + str + '</span> '	
				}

				return class_type;
			}
		}, {
			field: "Actions",
			width: 70,
			title: "Actions",
			sortable: false,
			ordering: false,
			overflow: 'visible',
			template: function (row, index, datatable) {
				var dropup = (datatable.getPageSize() - index) <= 4 ? 'dropup' : '';
				var $privileges = _privileges.split(',');
				if ($privileges[3] == 1) {
					return '\
						<a data-row-id="' + row.designationID + '" action="Active" href="javascript:;" class="toggle-status m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" title="activate this">\
							<i class="la la-undo"></i>\
						</a>\
					';
				}
			}
		}]
	});

	var demo = function () {

        // <a class="dropdown-item" href="' + base_url + 'applications/view/' + row.AppID + '"><i class="la la-print"></i> Generate Report</a>

		var query = datatable.getDataSourceQuery();

		$('#m_form_type').on('change', function () {
			datatable.search($(this).val(), 'designationType');
		}).val(typeof query.designationType !== 'undefined' ? query.designationType : '');

		// $('#m_form_type').on('change', function () {
		// 	datatable.search($(this).val(), 'Type');
		// }).val(typeof query.Type !== 'undefined' ? query.Type : '');

		$('#m_form_status, #m_form_type').selectpicker();

		
	};

	var reload = function () {
		datatable.reload();
	}

	return {
		//== Public functions
		init: function () {
			// init dmeo
			demo();
		}, 
		reload: function () {
			reload();
		}
	};
}();

jQuery(document).ready(function () {
	DatatableDataLocalDemo.init();
	var $body = $("body");

	$body.on('click', '.toggle-status', function (e){
		e.preventDefault();
		var $rowID = $(this).attr('data-row-id');
		console.log($rowID);
		var $action = $(this).attr('action');
		var $url = base_url + 'components/schools/designations/update-status/' + $rowID;
		var items = []; items.push({ action: $action });

		console.log($url);
		$.ajax({
			type: 'PUT',
			url: $url,
			data: { items },
			success: function(response) {
				var data = $.parseJSON(response);   
				console.log(data);
				swal({
					"title": data.title, 
					"text": data.text, 
					"type": data.type,
					"confirmButtonClass": "btn " + data.class + " m-btn m-btn--wide"
				});
				DatatableDataLocalDemo.reload();
			}, 
			complete: function() {
				window.onkeydown = null;
				window.onfocus = null;
			}
		});
	});
});