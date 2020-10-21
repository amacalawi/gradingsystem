//== Class definition

var DatatableDataLocalDemo = function () {
	//== Private functions
 	console.log(base_url + 'academics/admissions/enrollments/all-active');
	
	var datatable = $('.m_datatable').mDatatable({
		// datasource definition
		data: {
			type: 'remote',
			source: {
			  read: {
				// sample GET method
				method: 'GET',
				url: base_url + 'academics/admissions/enrollments/all-active',
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
			field: "enrollID",
			title: "#",
			width: 50,
			sortable: false,
			textAlign: 'center',
			selector: {class: 'm-checkbox--solid m-checkbox--brand'}
		}, {
			field: "enrollLrn",
			title: "LRN"
		}, {
			field: "enrollFullname",
			title: "Fullname",
		}, {
			field: "enrollAgeGender",
			title: "Age & Gender"
        }, {
			field: "enrollEmail",
			title: "Email Address",
		}, {
			field: "enrollModified",
			title: "Last Modified",
		}, {
			field: "enrollStatus",
			title: "Status",
			// callback function support for column rendering
			template: function (row) {
				var status = {
					'enlisted' : {'class': 'childhood-bg'},
					'assessed' : {'class': 'focus-bg'}, 
					'enrolled' : {'class': 'secondary-bg'},
					'admitted' : {'class': 'secondary-bg'},
				};
				return '<span class="m-badge ' + status[row.enrollStatus].class + ' m-badge--wide">' + row.enrollStatus.toUpperCase() + '</span>';
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
				var $privileges = _privileges.split(',');
				var url = base_url + 'academics/admissions/enrollments/edit/' + row.enrollID;
				if ($privileges[2] == 1 && $privileges[3] == 1) {
					return '\
						<a onclick="popupWindow('+  row.enrollID +');" href="javascript:;" title="edit this" class=" m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill"><i class="la la-edit"></i></a>\
					';
				} else {
					if ($privileges[2] == 1) {
						return '\
						<a onclick="popupWindow("'+url+'", "edit application", 200, 100);" href="javascript:;" title="edit this" class=" m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill"><i class="la la-edit"></i></a>\
						';
					}
					if ($privileges[3] == 1) {
					}
				}
			}
		}]
	});

	var demo = function () {

        // <a class="dropdown-item" href="' + base_url + 'applications/view/' + row.AppID + '"><i class="la la-print"></i> Generate Report</a>

		var query = datatable.getDataSourceQuery();

		$('#m_form_type').on('change', function () {
			datatable.search($(this).val(), 'enrollType');
		}).val(typeof query.enrollType !== 'undefined' ? query.enrollType : '');

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

function popupWindow($id) {
	var url =  base_url + 'academics/admissions/enrollments/edit/' + $id;
	var w = window.innerWidth;
	var h = window.innerHeight;
    const y = window.top.outerHeight / 2 + window.top.screenY - ( h / 2);
    const x = window.top.outerWidth / 2 + window.top.screenX - ( w / 2);
    return window.open(url, 'edit application', `toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, copyhistory=no, width=${w}, height=${h}, top=${y}, left=${x}`);
}

jQuery(document).ready(function () {
	DatatableDataLocalDemo.init();
	var $body = $("body");

	$body.on('click', '.toggle-status', function (e){
		e.preventDefault();
		var $rowID = $(this).attr('data-row-id');
		console.log($rowID);
		var $action = $(this).attr('action');
		var $url = base_url + 'academics/admissions/enrollments/update-status/' + $rowID;
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