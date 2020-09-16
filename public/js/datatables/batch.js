//== Class definition

var DatatableDataLocalDemo = function () {
	//== Private functions
 	console.log(base_url + 'components/schools/batches/all-active');
	
	var datatable = $('.m_datatable').mDatatable({
		// datasource definition
		data: {
			type: 'remote',
			source: {
			  read: {
				// sample GET method
				method: 'GET',
				url: base_url + 'components/schools/batches/all-active',
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
			field: "batchID",
			title: "#",
			width: 50,
			sortable: false,
			textAlign: 'center',
			selector: {class: 'm-checkbox--solid m-checkbox--brand'}
		}, {
			field: "batchCode",
			title: "Code"
		}, {
			field: "batchName",
			title: "Name",
		}, {
			field: "batchDescription",
			title: "Description"
		}, {
			field: "batchStart",
			title: "Batch Start"
		}, {
			field: "batchEnd",
			title: "Batch End"
		}, {
			field: "batchModified",
			title: "Last Modified",
			type: "number"
		}, {
			field: "batchStatus",
			title: "Status",
			// callback function support for column rendering
			template: function (row) {
				var status = {
					"Open" : {'title': 'Open', 'class': 'open-bg'},
					"Closed": {'title': 'Closed', 'class': 'closed-bg'}, 
					"Current": {'title': 'Current', 'class': 'current-bg'},
				};
				return '<span class="m-badge ' + status[row.batchStatus].class + ' m-badge--wide">' + status[row.batchStatus].title + '</span>';
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
				if ($privileges[2] == 1 && $privileges[3] == 1) {
					return '\
						<div class="dropdown ' + dropup + '">\
							<a href="#" class="btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" data-toggle="dropdown">\
								<i class="la la-ellipsis-h"></i>\
							</a>\
							<div class="dropdown-menu dropdown-menu-right">\
								<a title="edit this" class="dropdown-item" href="' + base_url + 'components/schools/batches/edit/' + row.batchID + '"><i class="la la-edit"></i> Edit Details</a>\
								<a title="remove this" data-row-id="' + row.batchID + '" action="Remove" class="dropdown-item toggle-status" href="javascript:;"><i class="la la-remove"></i> Remove Details</a>\
								<a title="set this as current" data-row-id="' + row.batchID + '" action="Current" class="dropdown-item toggle-status" href="javascript:;"><i class="la la-flag"></i> Set as Current</a>\
								<a title="set this as open" data-row-id="' + row.batchID + '" action="Open" class="dropdown-item toggle-status" href="javascript:;"><i class="la la-folder-open"></i> Set as Open</a>\
								<a title="set this as closed" data-row-id="' + row.batchID + '" action="Closed" class="dropdown-item toggle-status" href="javascript:;"><i class="la la-folder-o"></i> Set as Closed</a>\
								\
							</div>\
						</div>\
					';
				} else {
					if ($privileges[2] == 1) {
						return '\
							<div class="dropdown ' + dropup + '">\
								<a href="#" class="btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" data-toggle="dropdown">\
									<i class="la la-ellipsis-h"></i>\
								</a>\
								<div class="dropdown-menu dropdown-menu-right">\
									<a title="edit this" class="dropdown-item" href="' + base_url + 'components/schools/batches/edit/' + row.batchID + '"><i class="la la-edit"></i> Edit Details</a>\
									<a title="set this as current" data-row-id="' + row.batchID + '" action="Current" class="dropdown-item toggle-status" href="javascript:;"><i class="la la-flag"></i> Set as Current</a>\
									<a title="set this as open" data-row-id="' + row.batchID + '" action="Open" class="dropdown-item toggle-status" href="javascript:;"><i class="la la-folder-open"></i> Set as Open</a>\
									<a title="set this as closed" data-row-id="' + row.batchID + '" action="Closed" class="dropdown-item toggle-status" href="javascript:;"><i class="la la-folder-o"></i> Set as Closed</a>\
									\
								</div>\
							</div>\
						';
					}
					if ($privileges[3] == 1) {
						return '\
							<div class="dropdown ' + dropup + '">\
								<a href="#" class="btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" data-toggle="dropdown">\
									<i class="la la-ellipsis-h"></i>\
								</a>\
								<div class="dropdown-menu dropdown-menu-right">\
									<a title="remove this" data-row-id="' + row.batchID + '" action="Remove" class="dropdown-item toggle-status" href="javascript:;"><i class="la la-remove"></i> Remove Details</a>\
									\
								</div>\
							</div>\
						';
					}
				}
			}
		}]
	});

	var demo = function () {

        // <a class="dropdown-item" href="' + base_url + 'applications/view/' + row.AppID + '"><i class="la la-print"></i> Generate Report</a>

		var query = datatable.getDataSourceQuery();

		$('#m_form_status').on('change', function () {
			datatable.search($(this).val(), 'Status');
		}).val(typeof query.Status !== 'undefined' ? query.Status : '');

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
		var $url = base_url + 'components/schools/batches/update-status/' + $rowID;
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