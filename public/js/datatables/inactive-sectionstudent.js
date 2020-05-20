//== Class definition

var DatatableDataLocalDemo = function () {
	//== Private functions
 	//console.log(base_url + 'academics/academics/sections/all-active');
	
	var datatable = $('.m_datatable').mDatatable({
		// datasource definition
		data: {
			type: 'remote',
			source: {
			  read: {
				// sample GET method
				method: 'GET',
				url: base_url + 'academics/admissions/section-student/all-inactive',
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
			field: "sectionsstudentsID",
			title: "#",
			width: 50,
			name: "test",
			sortable: false,
			textAlign: 'center',			
			selector: {class: 'm-checkbox--solid m-checkbox--brand checkboxcheck'},
		}, {
			field: "sectionsstudentsCode",
			title: "Code"
		}, {
			field: "sectionsstudentsName",
			title: "Name",
		}, {
			field: "sectionsstudentsDescription",
			title: "Description"
		}, {
			field: "sectionsstudentsModified",
			title: "Last Modified",
			type: "number"
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
                    <a data-row-id="' + row.sectionsstudentsID + '" action="Active" href="javascript:;" class="toggle-status m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" title="activate this">\
                        <i class="la la-undo"></i>\
                    </a>\
				';
			}
		}]
	
	});

	var demo = function () {

        //<a class="dropdown-item" href="' + base_url + 'applications/view/' + row.AppID + '"><i class="la la-print"></i> Generate Report</a>

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

jQuery(document).ready(function (e) {
	
	DatatableDataLocalDemo.init();
	var $body = $("body");

	$('#local_data').each(function() {
		
		var cellText = $(this).html();    
		console.log('celltext -> '+cellText);
		
		if(cellText == 'second')
		{
			$(this).closest('tr').addClass("selected");
		}

	});

	$('input[type="checkbox"]').each(function() {
		//console.log($(this).val());
	});

	$('#enlist-student-selected').on('click', function(e) {

		e.preventDefault();
		
		$('input:checkbox:checked').each(function() {

			if($(this).val() != 'on')
			{
				var row_id = $(this).val();
				var items = [];

				//$("#admitted_student").html("");
				
				$.ajax({
					type: 'GET', 
					url: base_url + 'academics/admissions/section-student/get-this-admitted/'+row_id,
					data: { items },
					success: function(response) {
						var data = $.parseJSON(response);
						$("#admitted_student" ).append("<input type='text' name='list_admitted_student[]' value='"+data[0].user_id+"' readonly='true' hidden><button type='button' class='btn p-2 m-1 bg-secondary' >"+data[0].lastname+", "+data[0].firstname+" "+data[0].middlename+"</button>");
					}, 
					complete: function() {
						window.onkeydown = null;
						window.onfocus = null;
					}
				});
			}
			else {
				//$("#admitted_student").html("");
			}
		});

	});

	$body.on('click', '.toggle-status', function (e){
		e.preventDefault();
		var $rowID = $(this).attr('data-row-id');
		console.log($rowID);
		var $action = $(this).attr('action');
		var $url = base_url + 'academics/admissions/section-student/update-status/' + $rowID;
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