//== Class definition

var DatatableDataLocalDemo = function () {
	//== Private functions
 	console.log(base_url + 'academics/attendance-sheets/student-attendance/settings/all-active');
	
	var datatable = $('.m_datatable').mDatatable({
		// datasource definition
		data: {
			type: 'remote',
			source: {
			  read: {
				// sample GET method
				method: 'GET',
				url: base_url + 'academics/attendance-sheets/student-attendance/settings/all-active',
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
			field: "studentsettingsID",
			title: "#",
			width: 50,
			sortable: false,
			textAlign: 'center',
			selector: {class: 'm-checkbox--solid m-checkbox--brand'}
		}, {
			field: "studentsettingsStudentNo",
            title: "Student Name",
            width: 100,
		}, {
			field: "studentsettingsSchedule",
            title: "Schedule",
            width: 100,
		}, {
			field: "studentsettingsModified",
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
                    <a title="edit this" class=" m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" href="' + base_url + 'academics/attendance-sheets/staff-attendance/settings/edit/' + row.staffsettingsID + '"><i class="la la-edit"></i></a>\
				';
			}
		}]
	});

	var demo = function () {
		var query = datatable.getDataSourceQuery();
		$('#m_form_type').on('change', function () {
			datatable.search($(this).val(), 'studentType');
		}).val(typeof query.studentType !== 'undefined' ? query.studentType : '');
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