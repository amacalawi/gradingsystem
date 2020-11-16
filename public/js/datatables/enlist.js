//== Class definition
var list_of_admitted_student;

var DatatableDataLocalDemo = function () {

	var demo = function () {
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
			//demo();
		}, 
		reload: function () {
			reload();
		},
		enlisted: function(data_){
			//$(".enlist_datatable").load(location.href + " .enlist_datatable");
			var enlist_datatable = $('.enlist_datatable').mDatatable({
				data: {
				  source: {
					read: {
					  map: function() {
						return data_;
					  },
					},
				  },
				},
		
				search: {
				  input: $('#enlist_generalSearch'),
				},

				columns: [{
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
					field: "Actions",
					width: 90,
					title: "Actions",
					sortable: false,
					ordering: false,
					overflow: 'visible',
					template: function (row, index, datatable) {
						var dropup = (datatable.getPageSize() - index) <= 4 ? 'dropup' : '';
		
						return '\
							<a title="remove this" data-row-id="' + row.studentID + '" action="Remove" class="dropdown-item toggle-status m-portlet__nav-link btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill" onclick="removegroupmember('+row.studentID+')" ><i class="la la-remove"></i></a>\
						';
					}
				}]
			});
		},

		enlisted_main: function(data_){

			var datatable = $('.m_datatable').mDatatable({
				// datasource definition
				data: {
					source: {
					  read: {
						map: function() {
						  return data_;
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
				}]
			});
		}
	};
}();

var enlisted_student = [];
var stud_arry = [];

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

			if($('#method').val() == 'edit'){

				$.ajax({
					type: 'GET',
					url: base_url + 'academics/admissions/classes/remove-admitted-student/'+id, //member_id
					success: function(response) {
						var data = $.parseJSON(response);
						console.log(data);
						$("#enlist-div-"+id).remove();
						enlisted_student.splice(enlisted_student.indexOf(id), 1);
					},
					complete: function() {
						window.onkeydown = null;
						window.onfocus = null;
					},
					error: function(){
						$("#enlist-div-"+id).remove();
						enlisted_student.splice(enlisted_student.indexOf(id), 1);
						//alert('error');
					}
				});
			} else {
				$("#enlist-div-"+id).remove();
				enlisted_student.splice(enlisted_student.indexOf(id), 1);
			}
		}
    });
	
});

//ENLIST
jQuery(document).ready(function (e) {
	
	//DatatableDataLocalDemo.init();
	var $body = $("body");
	var enlisted_data = {};

	$('#local_data').each(function() {	
		var cellText = $(this).html();    
		console.log('celltext -> '+cellText);
		if(cellText == 'second')
		{
			$(this).closest('tr').addClass("selected");
		}
	});

	$('#enlist-btn-load').on('click', function(e) {

		if($('#method').val() == 'edit'){
			var enlisted_main = listed_student();
			DatatableDataLocalDemo.enlisted_main( enlisted_main );
			$('.m_datatable').mDatatable('reload');
		} else {
			var enlisted_main = listed_student();
			DatatableDataLocalDemo.enlisted_main( enlisted_main );
			$('.m_datatable').mDatatable('reload');
		}
	});

	$('.m_datatable').on('click', function() {
		var input = $('.m_datatable').val();
		//datatable.setActive(input);
	});

	//enlist-student-selected
	$('#enlist-student-selected').on('click', function(e) {

		e.preventDefault();
		var section_id = $('#section').val();
		
		//if( (section_id) && section_id != '0')
		//{
			if($('#method').val() == 'edit'){

				var stud_data = {};
					//stud_arry.length = 0;
				$('input:checkbox:checked').each(function() {
					
					if($(this).val() != 'on')
					{
						var row_id = $(this).val();
						var items = [];
						console.log('academics/admissions/classes/save-this-admitted/'+row_id+'/'+section_id);
						$.ajax({
							type: 'GET',
							url: base_url + 'academics/admissions/classes/save-this-admitted/'+row_id+'/'+section_id,
							data: { items },
							success: function(response) {
								var data = $.parseJSON(response);
								//alert(data);
								if( (enlisted_student.indexOf(data[0].id)) < 0){
									
									$(".tbody-enlisted-student" ).append("<input type='text' name='list_admitted_student[]' value='"+data[0].id+"' readonly='true' hidden>");
									enlisted_student.push(data[0].id);

									stud_data = {
											'studentID': data[0].id, 
											'studentNumber': data[0].identification_no,
											'studentName': data[0].lastname+", "+data[0].firstname+" "+data[0].middlename,
											'studentGender': data[0].gender
										};
									stud_arry.push(stud_data);
								}
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
				
				console.log(stud_arry);			
				DatatableDataLocalDemo.enlisted( stud_arry );
				$('.enlist_datatable').mDatatable('reload');

			}
			else {
				var items = [];
				$.ajax({
					type: 'GET',
					url: base_url + 'academics/admissions/classes/get-student-admitted-section/'+section_id,
					data: { items },
					success: function(response) {
						var data = $.parseJSON(response);
						$.each(data, function(index, value) {
							//$(".tbody-enlisted-student" ).append("<tr id='enlist-div-"+data[0].id+"'><td>"+data[0].identification_no+"</td><td>"+data[0].lastname+", "+data[0].firstname+" "+data[0].middlename+"</td><td>"+data[0].gender+"</td><td><input type='text' name='list_admitted_student[]' value='"+data[0].id+"' readonly='true' hidden> <button type='button' id='semi-enlist-student' class='semi-enlist-student btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill' value='"+data[0].id+"' ><span class='la la-close'></span></button></td></tr>");
							//$("#admitted_student" ).append("<div class='btn-group mr-2' id='enlist-div-"+data[index].stud_id+"' > <input type='text' name='list_admitted_student[]' value='"+data[index].stud_id+"' readonly='true' hidden><button type='button' class='btn bg-secondary' >"+data[index].lastname+", "+data[index].firstname+" "+data[index].middlename+"</button><button type='button' id='semi-enlist-student' class='btn bg-danger semi-enlist-student' value='"+data[index].stud_id+"' >x</button></div>");
						});
					}, 
					complete: function() {
						window.onkeydown = null;
						window.onfocus = null;
					}
				});

				var stud_data = {};
					stud_arry.length = 0;
				$('input:checkbox:checked').each(function() {
					
					if($(this).val() != 'on')
					{
						var row_id = $(this).val();
						var items = [];
						console.log('academics/admissions/classes/save-this-admitted/'+row_id+'/'+section_id);
						$.ajax({
							type: 'GET',
							url: base_url + 'academics/admissions/classes/save-this-admitted/'+row_id+'/'+section_id,
							data: { items },
							success: function(response) {
								var data = $.parseJSON(response);
								//alert(data);
								//if( (enlisted_student.indexOf(data[0].id)) < 0){
									
									$(".tbody-enlisted-student" ).append("<input type='text' name='list_admitted_student[]' value='"+data[0].id+"' readonly='true' hidden>");
									enlisted_student.push(data[0].id);

									stud_data = {
											'studentID': data[0].id, 
											'studentNumber': data[0].identification_no,
											'studentName': data[0].lastname+", "+data[0].firstname+" "+data[0].middlename,
											'studentGender': data[0].gender
										};
									stud_arry.push(stud_data);
								//}
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

				console.log(stud_arry);			
				DatatableDataLocalDemo.enlisted( stud_arry );
				$('.enlist_datatable').mDatatable('reload');
			}
		/*
		}
		else 
		{
			swal({
				title: "Oops...",
				text: "No section selected.",
				type: "warning",
				showCancelButton: false,
				closeOnConfirm: true,
				confirmButtonClass: "btn btn-warning btn-focus m-btn m-btn--pill m-btn--air m-btn--custom"
			});
		}
		*/
	});

	if($('#method').val() == 'edit'){
		var items = [];
		$.ajax({
			type: 'GET',
			url: base_url + 'academics/admissions/classes/get-student-admitted-section/'+$('.edit-admission-enlist-student').val(),
			data: { items },
			success: function(response) {
				var data = $.parseJSON(response);

				$.each(data, function(index, value) {
					$(".tbody-enlisted-student" ).append("<input type='text' name='list_admitted_student[]' value='"+data[0].id+"' readonly='true' hidden>");
					enlisted_student.push(data[index].id);
					stud_data = {
						'studentID': data[index].id, 
						'studentNumber': data[index].identification_no,
						'studentName': data[index].lastname+", "+data[index].firstname+" "+data[index].middlename,
						'studentGender': data[index].gender
					};
					stud_arry.push(stud_data);
				});
				DatatableDataLocalDemo.enlisted( stud_arry );
				$('.enlist_datatable').mDatatable('reload');
			}, 
			complete: function() {
				window.onkeydown = null;
				window.onfocus = null;
			}
		});
	}

});

function listed_student()
{
	var enlisted_main = [];

	$.ajax({
		type: 'GET',
		url: base_url + 'academics/admissions/classes/all-admitted',
		success: function(raw) {
			$.each(raw, function(index, value) {
				enlisted_data = {
					'studentID': value.studentID, 
					'studentNumber': value.studentNumber,
					'studentName': value.studentName,
					'studentGender': value.studentGender
				};
				enlisted_main.push(enlisted_data);
			});
		}
	});

	return enlisted_main;
}

function removegroupmember(stud_id)
{
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
			var id = stud_id;
			
			if($('#method').val() == 'edit'){
				
				$.each(stud_arry, function(i){
					if(stud_arry[i].studentID === id ) {
						stud_arry.splice(i,1);
						$.ajax({
							type: 'GET',
							url: base_url + 'academics/admissions/classes/remove-admitted-student-admission-id/'+id, //member_id
							success: function(response) {
								var data = $.parseJSON(response);
								enlisted_student.splice(enlisted_student.indexOf(id), 1);
							},
							complete: function() {
								window.onkeydown = null;
								window.onfocus = null;
							},
							error: function(){
								//alert('error');
							}
						});

						return false;
					}
				});
				$('.enlist_datatable').mDatatable('reload');
				
			} else {
				enlisted_student.splice(enlisted_student.indexOf(id), 1);
				stud_arry.splice(stud_arry.indexOf(id), 1);
				$('.enlist_datatable').mDatatable('reload');
			}
		}
    });
}