//== Class definition

var DatatableDataLocalDemo = function () {
	//== Private functions
 	console.log(base_url + 'components/schools/quarters/all-active');
	
	var datatable = $('.m_datatable').mDatatable({
		// datasource definition
		data: {
			type: 'remote',
			source: {
			  read: {
				// sample GET method
				method: 'GET',
				url: base_url + 'components/schools/quarters/all-active',
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
			field: "quarterID",
			title: "#",
			width: 50,
			sortable: false,
			textAlign: 'center',
			selector: {class: 'm-checkbox--solid m-checkbox--brand'}
		}, {
			field: "quarterCode",
			title: "Code",
			sortable: true,
			ordering: true,
		}, {
			field: "quarterName",
			title: "Name",
			sortable: true,
			ordering: true,
		}, {
			field: "quarterDescription",
			title: "Description",
			sortable: true,
			ordering: true,
        }, {
			field: "quarterStart",
			title: "Quarter Start",
			sortable: true,
			ordering: true,
		}, {
			field: "quarterEnd",
			title: "Quarter End",
			sortable: true,
			ordering: true,
		}, {
			field: "quarterModified",
			title: "Last Modified",
			sortable: true,
			ordering: true,
		}, {
			field: "quarterType",
			width: 150,
			sortable: true,
			ordering: true,
			title: "Education Type",
			// callback function support for column rendering
			template: function (row) {
				var class_type = '';
				var type = {
					1 : {'class': 'childhood-bg'},
					2 : {'class': 'primary-bg'}, 
					3 : {'class': 'secondary-bg'},
					4 : {'class': 'higher-bg'}
				};

				var str = '';
				for(var x=0; x<row.quarterTypeID.length; x++){
					str = row.quarterTypeName[x].charAt(0);
					class_type += '<span class="m-badge ' + type[row.quarterTypeID[x]].class + ' m-badge--wide">' + str + '</span> '	
				}
					
				return class_type;
			}
		}, {
			field: "Actions",
			width: 90,
			title: "Actions",
			sortable: true,
			ordering: true,
			overflow: 'visible',
			template: function (row, index, datatable) {
				var dropup = (datatable.getPageSize() - index) <= 4 ? 'dropup' : '';
				var $privileges = _privileges.split(',');
				if ($privileges[2] == 1 && $privileges[3] == 1) {
					return '\
						<a title="edit this" class=" m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" href="' + base_url + 'components/schools/quarters/edit/' + row.quarterID + '"><i class="la la-edit"></i></a>\
						<a title="remove this" data-row-id="' + row.quarterID + '" action="Remove" class="dropdown-item toggle-status m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" href="javascript:;"><i class="la la-remove"></i></a>\
					';
				} else {
					if ($privileges[2] == 1) {
						return '\
							<a title="edit this" class=" m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" href="' + base_url + 'components/schools/quarters/edit/' + row.quarterID + '"><i class="la la-edit"></i></a>\
						';
					}
					if ($privileges[3] == 1) {
						return '\
							<a title="remove this" data-row-id="' + row.quarterID + '" action="Remove" class="dropdown-item toggle-status m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" href="javascript:;"><i class="la la-remove"></i></a>\
						';
					}
				}
			}
		}]
	});

	var demo = function () {

        // <a class="dropdown-item" href="' + base_url + 'applications/view/' + row.AppID + '"><i class="la la-print"></i> Generate Report</a>

		var query = datatable.getDataSourceQuery();

		$('#m_form_type').on('change', function () {
			datatable.search($(this).val(), 'quarterTypeID');
		}).val(typeof query.quarterTypeID !== 'undefined' ? query.quarterTypeID : '');

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

	$body.on('click', '.toggle-status', function (e){
		e.preventDefault();
		var $rowID = $(this).attr('data-row-id');
		console.log($rowID);
		var $action = $(this).attr('action');
		var $url = base_url + 'components/schools/quarters/update-status/' + $rowID;
		var items = []; items.push({ action: $action });

		swal({
			title: 'Are you sure?',
			text: "The quarter will be removed!",
			type: 'warning',
			showCancelButton: true,
			confirmButtonClass: "btn btn-brand m-btn m-btn--wide",
			confirmButtonText: 'Yes, remove it!'
		}).then(function(result) {
			if (result.value) {
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
			}
		});
	});

	Dropzone.autoDiscover = false;
	var accept = ".csv";

	$('#import-quarter-dropzone').dropzone({
		acceptedFiles: accept,
		maxFilesize: 209715200,
		timeout: 0,
		init: function () {
		this.on("processing", function(file) {
			this.options.url = base_url + 'components/schools/quarters/import';
			console.log(this.options.url);
		}).on("queuecomplete", function (file, response) {
			// console.log(response);
		}).on("success", function (file, response) {
			console.log(response);
			var data = $.parseJSON(response);
			if (data.message == 'success') {
				if ( $('.m_datatable').length ) {
					$('.m_datatable').mDatatable().reload();
				}
			}
		}).on("totaluploadprogress", function (progress) {
			var progressElement = $("[data-dz-uploadprogress]");
			progressElement.width(progress + '%');
			progressElement.find('.progress-text').text(progress + '%');
		});
		this.on("error", function(file){if (!file.accepted) this.removeFile(file);});            
		}
	});
});