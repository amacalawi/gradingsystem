//== Class definition

var DatatableDataLocalDemo = function () {
	//== Private functions
 	console.log(base_url + 'notifications/messaging/infoblast/active-tracking');
	
	var datatable = $('.m_datatable').mDatatable({
		// datasource definition
		data: {
			type: 'remote',
			source: {
			  read: {
				// sample GET method
				method: 'GET',
				url: base_url + 'notifications/messaging/infoblast/active-tracking',
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
			field: "outboxIDs",
			title: "Tracking ID",
		}, {
			field: "outboxMessage",
			title: "Messages",
		}, {
			field: "outboxContact",
			title: "No. of Contacts"
		}, {
			field: "outboxSuccessful",
			title: "Successful"
        }, {
			field: "outboxPending",
			title: "Pending",
		}, {
			field: "outboxFailure",
            title: "Failure",
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
                    <a title="resend this" data-row-id="' +  row.outboxID + '" action="Resend" class="dropdown-item resend-item m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" href="javascript:;"><i class="fa fa-location-arrow"></i></a>\
				';
			}
		}]
	});

	var demo = function () {

        // <a class="dropdown-item" href="' + base_url + 'applications/view/' + row.AppID + '"><i class="la la-print"></i> Generate Report</a>

		var query = datatable.getDataSourceQuery();

		$('#m_form_type').on('change', function () {
			datatable.search($(this).val(), 'outboxMessageType');
		}).val(typeof query.outboxMessageType !== 'undefined' ? query.outboxMessageType : '');

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

    $body.on('click', '.refresh-table', function (e){
        e.preventDefault();
        DatatableDataLocalDemo.reload();
        var timenow = moment().format('DD-MMM-YYYY hh:mm A');
        $('.refresh-text').text('DATA AS OF ' + timenow);
    });

    $body.on('click', '.resend-item', function (e){
		e.preventDefault();
		var $rowID = $(this).attr('data-row-id');
		console.log($rowID);
		var $url = base_url + 'notifications/messaging/infoblast/resend-item/' + $rowID;

		console.log($url);
		$.ajax({
			type: 'POST',
			url: $url,
			success: function(response) {
				var data = $.parseJSON(response);   
				console.log(data);
				swal({
					"title": data.title, 
					"text": data.text, 
					"type": data.type,
					"confirmButtonClass": "btn " + data.class + " m-btn m-btn--wide"
                });
                setTimeout(function(){ DatatableDataLocalDemo.reload(); }, 5000);
			}, 
			complete: function() {
				window.onkeydown = null;
				window.onfocus = null;
			}
		});
	});
});