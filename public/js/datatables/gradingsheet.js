//== Class definition

var DatatableDataLocalDemo = function () {
	//== Private functions
 	console.log(base_url + 'academics/grading-sheets/all-gradingsheets/all-active');
	
	var datatable = $('.m_datatable').mDatatable({
		// datasource definition
		data: {
			type: 'remote',
			source: {
			  read: {
				// sample GET method
				method: 'GET',
				url: base_url + 'academics/grading-sheets/all-gradingsheets/all-active',
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
			field: "gradingID",
			title: "#",
			width: 50,
			sortable: false,
			textAlign: 'center',
			selector: {class: 'm-checkbox--solid m-checkbox--brand'}
		}, {
			field: "gradingCode",
			title: "Code"
		}, {
			field: "gradingSection",
			title: "Class"
		}, {
			field: "gradingSubject",
			title: "Subject",
		}, {
			field: "gradingQuarter",
			title: "Quarter",
		}, {
			field: "gradingModified",
			title: "Last Modified",
		}, {
			field: "gradingStatus",
			title: "Status",
			// callback function support for column rendering
			template: function (row) {
				var type = {
					0 : {'class': 'childhood-bg'},
					1 : {'class': 'm-badge--metal'}
				};
				return '<span class="m-badge ' + type[row.gradingStatusID].class + ' m-badge--wide">' + row.gradingStatus + '</span>';
			}
		}, {
			field: "Actions",
			width: 120,
			title: "Actions",
			sortable: false,
			ordering: false,
			overflow: 'visible',
			template: function (row, index, datatable) {
				var dropup = (datatable.getPageSize() - index) <= 4 ? 'dropup' : '';
				var $privileges = _privileges.split(',');
				if ($privileges[2] == 1) {
					if (user_role == 'administrator' || row.gradingAdviser > 0) {
						if (row.gradingStatusID > 0) {
							return '\
								<a title="1edit this" class=" m-portlet__nav-link btn m-btn m-btn--hover-warning m-btn--icon m-btn--icon-only m-btn--pill" href="' + base_url + 'academics/grading-sheets/all-gradingsheets/edit/' + row.gradingID + '"><i class="la la-edit"></i></a>\
								<a title="export this" class=" m-portlet__nav-link btn m-btn m-btn--hover-success m-btn--icon m-btn--icon-only m-btn--pill" href="' + base_url + 'academics/grading-sheets/all-gradingsheets/export-gradingsheet/' + row.gradingID + '"><i class="la la-download"></i></a>\
								<a title="unlock this" action="Unlock" data-row-id="' + row.gradingID + '"  class="toggle-status m-portlet__nav-link btn m-btn m-btn--hover-primary m-btn--icon m-btn--icon-only m-btn--pill" href="javascript:;"><i class="la la-unlock-alt"></i></a>\
							';
						} else {
							return '\
								<a title="edit this" class=" m-portlet__nav-link btn m-btn m-btn--hover-warning m-btn--icon m-btn--icon-only m-btn--pill" href="' + base_url + 'academics/grading-sheets/all-gradingsheets/edit/' + row.gradingID + '"><i class="la la-edit"></i></a>\
								<a title="export this" class=" m-portlet__nav-link btn m-btn m-btn--hover-success m-btn--icon m-btn--icon-only m-btn--pill" href="' + base_url + 'academics/grading-sheets/all-gradingsheets/export-gradingsheet/' + row.gradingID + '"><i class="la la-download"></i></a>\
								<a title="lock this" action="Lock" data-row-id="' + row.gradingID + '" class="toggle-status m-portlet__nav-link btn m-btn m-btn--hover-primary m-btn--icon m-btn--icon-only m-btn--pill" href="javascript:;"><i class="la la-unlock"></i></a>\
							';
						}
					} else {
						if (row.gradingStatusID > 0) {
							return '\
								<a title="edit this" class=" m-portlet__nav-link btn m-btn m-btn--hover-warning m-btn--icon m-btn--icon-only m-btn--pill" href="' + base_url + 'academics/grading-sheets/all-gradingsheets/edit/' + row.gradingID + '"><i class="la la-edit"></i></a>\
								<a title="export this" class=" m-portlet__nav-link btn m-btn m-btn--hover-success m-btn--icon m-btn--icon-only m-btn--pill" href="' + base_url + 'academics/grading-sheets/all-gradingsheets/export-gradingsheet/' + row.gradingID + '"><i class="la la-download"></i></a>\
							';
						} else {
							return '\
								<a title="edit this" class=" m-portlet__nav-link btn m-btn m-btn--hover-warning m-btn--icon m-btn--icon-only m-btn--pill" href="' + base_url + 'academics/grading-sheets/all-gradingsheets/edit/' + row.gradingID + '"><i class="la la-edit"></i></a>\
								<a title="export this" class=" m-portlet__nav-link btn m-btn m-btn--hover-success m-btn--icon m-btn--icon-only m-btn--pill" href="' + base_url + 'academics/grading-sheets/all-gradingsheets/export-gradingsheet/' + row.gradingID + '"><i class="la la-download"></i></a>\
								<a title="lock this" action="Lock" data-row-id="' + row.gradingID + '"  class="toggle-status m-portlet__nav-link btn m-btn m-btn--hover-primary m-btn--icon m-btn--icon-only m-btn--pill" href="javascript:;"><i class="la la-unlock"></i></a>\
							';
						}
					}
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
		var $action = $(this).attr('action');
		console.log($action);
		var $url = base_url + 'academics/grading-sheets/all-gradingsheets/update-status/' + $rowID;
		var items = []; items.push({ action: $action });
		var $status = $(this).closest('tr').find('td[data-field="gradingStatus"] span.m-badge').text();
		if ($status == 'Locked') { 
			$status = 'unlocked'; 
			var $statusSingular = 'unlock'; 
		} else { 
			$status = 'locked'; 
			var $statusSingular = 'lock'; 
		}
		
		swal({
			title: 'Are you sure?',
			text: "The gradingsheet status will be " + $status + "!",
			type: 'warning',
			showCancelButton: true,
			confirmButtonClass: "btn btn-brand m-btn m-btn--wide",
			confirmButtonText: 'Yes, ' + $statusSingular + ' it!'
		}).then(function(result) {
			if (result.value) {
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
			}
		});
	});
});