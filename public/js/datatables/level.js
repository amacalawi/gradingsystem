//== Class definition

var DatatableDataLocalDemo = function () {
	//== Private functions
 	console.log(base_url + 'academics/academics/levels/all-active');
	
	var datatable = $('.m_datatable').mDatatable({
		// datasource definition
		data: {
			type: 'remote',
			source: {
			  read: {
				// sample GET method
				method: 'GET',
				url: base_url + 'academics/academics/levels/all-active',
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
			field: "levelID",
			title: "#",
			width: 50,
			sortable: false,
			textAlign: 'center',
			selector: {class: 'm-checkbox--solid m-checkbox--brand'}
		}, {
			field: "levelCode",
			title: "Code"
		}, {
			field: "levelName",
			title: "Name",
		}, {
			field: "levelDescription",
			title: "Description"
		}, {
			field: "levelModified",
			title: "Last Modified",
			type: "number"
		}, {
			field: "levelType",
			title: "Type",
			// callback function support for column rendering
			template: function (row) {
				var type = {
					"childhood-education" : {'title': 'Childhood', 'class': 'childhood-bg'},
					"primary-education": {'title': 'Pimary', 'class': 'primary-bg'}, 
                    "secondary-education": {'title': 'Secondary', 'class': 'secondary-bg'},
                    "higher-education": {'title': 'Higher', 'class': 'higher-bg'}
				};
				return '<span class="m-badge ' + type[row.levelType].class + ' m-badge--wide">' + type[row.levelType].title + '</span>';
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

				return '\
					<div class="dropdown ' + dropup + '">\
						<a href="#" class="btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" data-toggle="dropdown">\
							<i class="la la-ellipsis-h"></i>\
						</a>\
						  <div class="dropdown-menu dropdown-menu-right">\
							<a title="edit this" class="dropdown-item" href="' + base_url + 'academics/academics/levels/edit/' + row.levelID + '"><i class="la la-edit"></i> Edit Details</a>\
							<a title="remove this" data-row-id="' + row.levelID + '" action="Remove" class="dropdown-item toggle-status" href="javascript:;"><i class="la la-remove"></i> Remove Details</a>\
							\
						  </div>\
					</div>\
				';
			}
		}]
	});

	var demo = function () {

        // <a class="dropdown-item" href="' + base_url + 'applications/view/' + row.AppID + '"><i class="la la-print"></i> Generate Report</a>

		var query = datatable.getDataSourceQuery();

		$('#m_form_status').on('change', function () {
			datatable.search($(this).val(), 'Status');
		}).val(typeof query.Status !== 'undefined' ? query.Status : '');


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
		var $url = base_url + 'academics/academics/levels/update-status/' + $rowID;
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