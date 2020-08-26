//== Class definition

var group_members = [];

var list_available_member = function () {
	//== Private functions
	
	var datatable = $('.groupmember_datatable').mDatatable({
        // datasource definition
        
		data: {
			type: 'remote',
			source: {
			  read: {
				// sample GET method
				method: 'GET',
				url: base_url + 'components/groups/all-member',
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
			field: "studentIdentification",
            title: "ID No.",
            width: 100
        }, {
			field: "studentName",
			title: "Name",
			width: 190
		}, {
			field: "Actions",
			width: 70,
			title: "Actions",
			sortable: false,
			ordering: false,
			overflow: 'visible',
			template: function (row, index, datatable) {
                //row.studentID
				return '\
                    <span title="add this" class=" m-portlet__nav-link btn m-btn m-btn--hover-info m-btn--icon m-btn--icon-only m-btn--pill" onclick="addgroupmember('+row.studentID+')"><i class="la la-plus"></i></span>\
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

//ENLIST
jQuery(document).ready(function (e) {
	
	list_available_member.init();
	group_members

	$('.cl_group_member').each(function( index ){
		group_members.push(Number(this.value));
	});
	console.log(group_members);
});

function addgroupmember($stud_id)
{
	$.ajax({
		type: 'GET',
		url: base_url + 'components/groups/get-student/'+$stud_id,
		success: function(response) {
			var data = $.parseJSON(response);
			console.log(data);
			var exist = group_members.includes(data[0].id);
			if(!exist){
				$("#group_member_table" ).append("<tr id='group_member_"+data[0].id+"'> <td> "+data[0].identification_no+"</td> <td>"+data[0].firstname+" "+data[0].lastname+"</td> <td> <span title='remove this' class=' m-portlet__nav-link btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill' onclick='removegroupmember("+data[0].id+")'><i class='la la-minus'></i></span></td></tr>");
				$("#group_member_table" ).append("<input type='text' class='cl_group_member' name='group_member[]' value='"+data[0].id+"' hidden>");
				group_members.push(data[0].id);
			}
		}, 
		complete: function() {
			window.onkeydown = null;
			window.onfocus = null;
		}
	});
	
}

function removegroupmember(stud_id)
{
	var index = group_members.indexOf(stud_id);
	if (index > -1) {
		$("#group_member_"+stud_id).remove();
		group_members.splice(index, 1);
	}
	console.log(index);
	console.log(stud_id);
	console.log(group_members);
}