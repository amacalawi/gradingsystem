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
				url: base_url + 'academics/admissions/classes/all-admitted',
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
		
		// columns definition
		columns: [{
			field: "studentID",
			title: "#",
			width: 50,
			sortable: false,
			textAlign: 'center',
			selector: {class: 'm-checkbox--solid m-checkbox--brand'}
		}, {
			field: "studentNumber",
            title: "ID No.",
            width: 100
        }, {
			field: "studentName",
			title: "Name",
			width: 190
		}, {
			field: "studentGender",
            title: "Gender",
            width: 60,
		}, {
			field: "studentContactNo",
            title: "Contact No",
            width: 190
        }, {
			field: "studentModified",
			title: "Last Modified",
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

//$('#semi-enlist-student').on('click', function(e) {
$('body').on('click', '.semi-enlist-student', function() {
	
	swal({
		title: "Warning",
		text:  "Do you really want to remove this student?",
		type:  "warning",
		showCancelButton: true,
		closeOnConfirm: true,
		confirmButtonClass: "btn btn-danger btn-focus m-btn m-btn--custom"
	}).then((confirmed) => {
		if(confirmed.value)
		{
			var id = $(this).val();
			$("#enlist-div-"+id).remove();
		}
    });
	
});

//ENLIST
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

	//enlist-student-selected
	$('#enlist-student-selected').on('click', function(e) {

		e.preventDefault();
		var section_id = $('#section').val();
		
		if( (section_id) && section_id != '0')
		{
			$("#admitted_student" ).html("");

			var items = [];
			$.ajax({
				type: 'GET',
				url: base_url + 'academics/admissions/classes/get-student-admitted-section/'+section_id,
				data: { items },
				success: function(response) {
					var data = $.parseJSON(response);
					$.each(data, function(index, value) {
						$("#admitted_student" ).append("<div class='btn-group mr-2' id='enlist-div-"+data[index].stud_id+"' > <input type='text' name='list_admitted_student[]' value='"+data[index].stud_id+"' readonly='true' hidden><button type='button' class='btn bg-secondary' >"+data[index].lastname+", "+data[index].firstname+" "+data[index].middlename+"</button><button type='button' id='semi-enlist-student' class='btn bg-danger semi-enlist-student' value='"+data[index].stud_id+"' >x</button></div>");
					});
				}, 
				complete: function() {
					window.onkeydown = null;
					window.onfocus = null;
				}
			});

			$('input:checkbox:checked').each(function() {
				
				if($(this).val() != 'on')
				{
					var row_id = $(this).val();
					var items = [];
					
					$.ajax({
						type: 'GET',
						url: base_url + 'academics/admissions/classes/save-this-admitted/'+row_id+'/'+section_id,
						data: { items },
						success: function(response) {
							var data = $.parseJSON(response);
							$("#admitted_student" ).append("<div class='btn-group mr-2' id='enlist-div-"+data[0].id+"' > <input type='text' name='list_admitted_student[]' value='"+data[0].id+"' readonly='true' hidden><button type='button' class='btn bg-secondary' >"+data[0].lastname+", "+data[0].firstname+" "+data[0].middlename+"</button><button type='button' id='semi-enlist-student' class='btn bg-danger semi-enlist-student' value='"+data[0].id+"' >x</button></div>");
						}, 
						complete: function() {
							window.onkeydown = null;
							window.onfocus = null;
						}
					});
				}
				else {

				}
			});

		}
		else 
		{
			alert('No section selected');
		}
		//$("#enlist-div").load(location.href+" #enlist-div>*","");
	});

});