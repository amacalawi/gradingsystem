//== Class definition

var DatatableDataLocalDemo = function () {
	//== Private functions
 	console.log(base_url + 'notifications/messaging/infoblast/active-outbox');
	
	var datatable = $('.m_datatable').mDatatable({
		// datasource definition
		data: {
			type: 'remote',
			source: {
			  read: {
				// sample GET method
				method: 'GET',
				url: base_url + 'notifications/messaging/infoblast/active-outbox',
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
			field: "outboxID",
			title: "#",
			width: 50,
			sortable: false,
			textAlign: 'center',
			selector: {class: 'm-checkbox--solid m-checkbox--brand'}
		}, {
			field: "outboxPhone",
			title: "Phone Number"
		}, {
			field: "outboxMessage",
			title: "Messages",
		}, {
			field: "outboxNetwork",
			title: "Network"
        }, {
			field: "outboxStatus",
			title: "Status",
		}, {
			field: "outboxDate",
			title: "Datetime",
		}]
	});

	var demo = function () {

        // <a class="dropdown-item" href="' + base_url + 'applications/view/' + row.AppID + '"><i class="la la-print"></i> Generate Report</a>

		var query = datatable.getDataSourceQuery();

		$('#m_form_type').on('change', function () {
			datatable.search($(this).val(), 'departmentType');
		}).val(typeof query.departmentType !== 'undefined' ? query.departmentType : '');

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