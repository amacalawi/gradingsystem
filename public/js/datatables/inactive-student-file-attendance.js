//== Class definition

var DatatableDataLocalDemo = function () {
	//== Private functions
 	console.log(base_url + 'academics/attendance-sheets/student-attendance/file-attendance/all-inactive');
	
	var datatable = $('.m_datatable').mDatatable({
		// datasource definition
		data: {
			type: 'remote',
			source: {
			  read: {
				// sample GET method
				method: 'GET',
				url: base_url + 'academics/attendance-sheets/student-attendance/file-attendance/all-inactive',
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
			field: "attendancesheetID",
			title: "#",
			width: 50,
			sortable: false,
			textAlign: 'center',
			selector: {class: 'm-checkbox--solid m-checkbox--brand'}
		}, {
			field: "attendancesheetUserName",
            title: "Student Name",
            width: 100,
		}, {
			field: "attendancesheetTimedIn",
            title: "Timed In",
            width: 100,
		}, {
			field: "attendancesheetTimedOut",
            title: "Timed Out",
            width: 100,
		}, {
			field: "attendancesheetStatus",
            title: "Status",
            width: 50
		}, {
			field: "attendancesheetModified",
			title: "Last Modified",
		}, {
			field: "Actions",
			width: 50,
			title: "Actions",
			sortable: false,
			ordering: false,
			overflow: 'visible',
			template: function (row, index, datatable) {
				var dropup = (datatable.getPageSize() - index) <= 4 ? 'dropup' : '';

                return '\
					<a data-row-id="' + row.attendancesheetID + '" action="Active" href="javascript:;" class="toggle-status m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" title="activate this">\
						<i class="la la-undo"></i>\
					</a>\
				';
			}
		}]
	});

	var demo = function () {

        // <a class="dropdown-item" href="' + base_url + 'applications/view/' + row.AppID + '"><i class="la la-print"></i> Generate Report</a>

		var query = datatable.getDataSourceQuery();

		$('#m_form_type').on('change', function () {
			datatable.search($(this).val(), 'moduleType');
		}).val(typeof query.moduleType !== 'undefined' ? query.moduleType : '');

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
});