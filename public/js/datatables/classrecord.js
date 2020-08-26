//== Class definition

var DatatableDataLocalDemo = function () {
	//== Private functions
 	console.log(base_url + 'academics/grading-sheets/class-record/all-active');
	
	var datatable = $('.m_datatable').mDatatable({
		// datasource definition
		data: {
			type: 'remote',
			source: {
			  read: {
				// sample GET method
				method: 'GET',
				url: base_url + 'academics/grading-sheets/class-record/all-active',
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
			field: "classrecordID",
			title: "#",
			width: 50,
			sortable: false,
			textAlign: 'center',
			selector: {class: 'm-checkbox--solid m-checkbox--brand'}
		}, {
        //     field: "classrecordCode",
		// 	title: "Classcode"
		// }, {
			field: "classrecordSection",
			title: "Section"
		}, {
            field: "classrecordLevel",
			title: "Level"
		}, {
			field: "classrecordSubjects",
			title: "No. of Subjects"
		}, {
            field: "classrecordStudents",
			title: "No. of Students"
		}, {
			field: "classrecordModified",
			title: "Last Modified",
		}, {
			field: "classrecordType",
			title: "Type",
			template: function (row) {
				var type = {
					1 : {'class': 'childhood-bg'},
					2 : {'class': 'primary-bg'}, 
                    3 : {'class': 'secondary-bg'},
                    4 : {'class': 'higher-bg'}
				};
				return '<span class="m-badge ' + type[row.classrecordTypeID].class + ' m-badge--wide">' + row.classrecordType + '</span>';
			}
		}, {
			field: "Actions",
			width: 90,
			title: "Actions",
			sortable: false,
			ordering: false,
			overflow: 'visible',
			template: function (row, index, datatable) {
				var dropup = (datatable.getPageSize() - index) <= 4 ? 'dropup' : '';
                return '\
					<a title="view this" class="m-portlet__nav-link btn m-btn m-btn--hover-warning m-btn--icon m-btn--icon-only m-btn--pill" href="' + base_url + 'academics/grading-sheets/class-record/view/' + row.classrecordID + '"><i class="la la-search-plus"></i></a>\
					<a title="export this" class=" m-portlet__nav-link btn m-btn m-btn--hover-success m-btn--icon m-btn--icon-only m-btn--pill" href="' + base_url + 'academics/grading-sheets/class-record/export-record/' + row.classrecordID + '"><i class="la la-download"></i></a>\
                ';
			}
		}]
	});

	var demo = function () {

        // <a class="dropdown-item" href="' + base_url + 'applications/view/' + row.AppID + '"><i class="la la-print"></i> Generate Report</a>

		var query = datatable.getDataSourceQuery();

		$('#m_form_type').on('change', function () {
			datatable.search($(this).val(), 'classrecordTypeID');
		}).val(typeof query.classrecordTypeID !== 'undefined' ? query.classrecordTypeID : '');

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
		var $url = base_url + 'academics/grading-sheets/class-record/update-status/' + $rowID;
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