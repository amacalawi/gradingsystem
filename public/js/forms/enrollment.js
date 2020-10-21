//== Class definition
var WizardDemo = function () {
    //== Base elements
    var wizardEl = $('#m_wizard');
    var formEl = $('#m_form');
    var validator;
    var wizard;
    
    //== Private functions
    var initWizard = function () {
        //== Initialize form wizard
        wizard = wizardEl.mWizard({
            startStep: 1
        });

        //== Validation before going to next page
        wizard.on('beforeNext', function(wizard) {
            if (validator.form() !== true) {
                return false;  // don't go to the next step
            }
        })

        //== Change event
        wizard.on('change', function(wizard) {
            mApp.scrollTop();
        });
    }

    var initValidation = function() {
        validator = formEl.validate({
            //== Validate only visible fields
            ignore: ":hidden",

            //== Validation rules
            rules: {
                //=== Client Information(step 1)
                //== Client details
                name: {
                    required: true 
                },
                student_email: {
                    required: true,
                    email: true 
                },    
                is_new: {
                    required: true
                }, 
                student_number: {
                    required: true
                },  
                lrn_no: {
                    required: true,
                    minlength: 12,
                    maxlength: 12
                },  
                psa_no: {
                    required: false
                },  
                grade_level: {
                    required: true
                },
                student_firstname: {
                    required: true
                },
                student_middlename: {
                    required: false
                },
                student_lastname: {
                    required: true
                },
                student_age: {
                    required: true,
                    number: true
                },
                student_gender: {
                    required: true
                },
                student_birthdate: {
                    required: true
                },
                student_birthorder: {
                    required: true
                },
                student_reside_with: {
                    required: true
                },  
                student_address: {
                    required: true
                },
                student_barangay: {
                    required: true
                },
                student_last_attended: {
                    required: true
                },
                student_transfer_reason: {
                    required: true
                },
                
                /* father */
                father_firstname: {
                    required: true
                },
                father_middlename: {
                    required: false
                },
                father_lastname: {
                    required: true
                },
                father_contact: {
                    required: true,
                    mobile: true,
                    minlength: 11,
                    maxlength: 11
                },
                father_birthdate: {
                    required: true
                },
                father_birthplace: {
                    required: true
                },
                father_address: {
                    required: true
                },
                father_religion: {
                    required: true,
                    others: true
                },
                father_specific_religion: {
                    required: true
                },
                father_occupation: {
                    required: false
                },
                father_education: {
                    required: true
                },
                father_employment_status: {
                    required: true
                },
                father_workplace: {
                    required: true
                },
                father_work_quarantine: {
                    required: true
                },

                /* mother */
                mother_firstname: {
                    required: true
                },
                mother_middlename: {
                    required: false
                },
                mother_lastname: {
                    required: true
                },
                mother_maidenname: {
                    required: true
                },
                mother_contact: {
                    required: true,
                    mobile: true,
                    minlength: 11,
                    maxlength: 11
                },
                mother_birthdate: {
                    required: true
                },
                mother_birthplace: {
                    required: true
                },
                mother_address: {
                    required: true
                },
                mother_religion: {
                    required: true,
                    others: true
                },
                mother_specific_religion: {
                    required: true
                },
                mother_occupation: {
                    required: false
                },
                mother_education: {
                    required: true
                },
                mother_employment_status: {
                    required: true
                },
                mother_workplace: {
                    required: true
                },
                mother_work_quarantine: {
                    required: true
                },
                parent_marriage_status: {
                    required: true
                },

                /* guardian */
                guardian_firstname: {
                    required: true
                },
                guardian_middlename: {
                    required: false
                },
                guardian_lastname: {
                    required: true
                },
                guardian_relationship: {
                    required: true
                },
                guardian_contact: {
                    required: true,
                    mobile: true,
                    minlength: 11,
                    maxlength: 11
                },
                guardian_employment_status: {
                    required: true
                },
                guardian_work_quarantine: {
                    required: true
                },
                family_4ps: {
                    required: true
                },
                student_siblings: {
                    required: true
                },
                student_previous_academic: {
                    required: true
                },

                /* form 3 */
                student_transpo: {
                    required: true
                },
                student_studying: {
                    required: true,
                    others: true
                },
                specific_student_studying: {
                    required: true,
                    number: true
                },
                student_supplies: {
                    required: true
                },
                'student_devices[]': {
                    required: true,
                    'others[]': true
                },
                specific_student_devices: {
                    required: true,
                },
                student_with_internet: {
                    required: true,
                },
                student_internet_connection: {
                    required: true
                },
                student_describe_internet: {
                    required: true
                },
                student_learning_modality: {
                    required: true
                },
                student_learning_delivery: {
                    required: true
                },
                'student_challenges_education[]': {
                    required: true,
                    'others[]': true
                },
                specific_student_challenges_education: {
                    required: true
                },  

                /* form 4 */
                'student_documents[]': {
                    required: true
                },
                student_tuition_fee_types: {
                    required: true,
                    changeImage: true
                },

                /* form 5 */
                student_payment_terms: {
                    required: true
                },
                student_sibling_discount: {
                    required: true
                },
                student_subsidy_grantee: {
                    required: true
                },
                student_payment_option: {
                    required: true
                },

                /* form 6 */
                student_acknowledge_1: {
                    required: true
                },
                student_acknowledge_2: {
                    required: true
                },
                student_acknowledge_3: {
                    required: true
                },
                student_acknowledge_4: {
                    required: true
                }
            },

            //== Validation messages
            messages: {
                'account_communication[]': {
                    required: 'You must select at least one communication option'
                },
                accept: {
                    required: "You must accept the Terms and Conditions agreement!"
                } 
            },
            
            //== Display error  
            invalidHandler: function(event, validator) {     
                mApp.scrollTop();

                swal({
                    "title": "", 
                    "text": "There are some errors in your submission. Please correct them.", 
                    "type": "error",
                    "confirmButtonClass": "btn btn-secondary m-btn m-btn--wide"
                });
            },

            //== Submit valid form
            submitHandler: function (form) {
                
            }
        });   
    }

    var initSubmit = function() {
        var btn = formEl.find('[data-wizard-action="submit"]');

        btn.on('click', function(e) {
            e.preventDefault();
            var $form = $('form[name="enrollment_form"]');
            var $options = { 
                type: $form.attr('method'),
                url: $form.attr('action'),
                data: $form.serialize(),
                timeout: 5000, 
                success: function(response) {
                    mApp.unprogress(btn);
                    var data = $.parseJSON(response);   
                    console.log(data);
                    if (data.type == 'success') {
                        swal({
                            title: data.title,
                            text: data.text,
                            type: data.type,
                            confirmButtonClass: "btn " + data.class + " btn-focus m-btn m-btn--pill m-btn--air m-btn--custom",
                        }).then((result) => {
                            if ($form.find('input[name="method"]').val() !== 'edit') {
                                $('#forms').addClass('hidden');
                                $('#acknowledgement').removeClass('hidden');
                            }
                        })
                    } else {
                        swal({
                            title: data.title,
                            text: data.text,
                            type: data.type,
                            showCancelButton: false,
                            closeOnConfirm: true,
                            confirmButtonClass: "btn " + data.class + " btn-focus m-btn m-btn--pill m-btn--air m-btn--custom",
                        });
                    }
                }
            }; 
         

            if (validator.form()) {
                //== See: src\js\framework\base\app.js
                mApp.progress(btn);
                //mApp.block(formEl); 

                //== See: http://malsup.com/jquery/form/#ajaxSubmit
                formEl.ajaxSubmit($options);
            }
        });
    }

    return {
        // public functions
        init: function() {
            wizardEl = $('#m_wizard');
            formEl = $('#m_form');

            initWizard(); 
            initValidation();
            initSubmit();
        }
    };
}();

jQuery.validator.addMethod("others", function(value, element, params) {
    console.log(value);
    if (value == 'Other') {
        $(element).parents('.m-radio-list, .m-checkbox-list').next().removeClass('hidden').prop('disabled', false);
    } else {
        $(element).parents('.m-radio-list, .m-checkbox-list').next().addClass('hidden').prop('disabled', true);
    }
    return true;
}, jQuery.validator.format("This field is required"));

var otherlist = ["Other"];

jQuery.validator.addMethod("others[]", function(value, element, params) {
    console.log(value);
    var inputname = $(element).attr('name');
    var zero = 0;
    $.each($('input[name="' +inputname + '"]:checked'), function(){
        if ($(this).val() == 'Other') {
            zero++;
        }
    });
    if (zero > 0) {
        $(element).parents('.m-radio-list, .m-checkbox-list').next().removeClass('hidden').prop('disabled', false);
    } else {
        $(element).parents('.m-radio-list, .m-checkbox-list').next().addClass('hidden').prop('disabled', true);
    }
    return true;
}, jQuery.validator.format("This field is required"));

jQuery.validator.addMethod("changeImage", function(value, element, params) {
    if (value == 'Grade School (Nursery to Grade 6)') {
        var imageUrl = base_url + 'img/gr1-gr6.png';
    } else if (value == 'Grade School (Nursery to Grade 6)') {
        var imageUrl = base_url + 'img/gr7-gr10.png';
    } else {
        var imageUrl = base_url + 'img/gr11-gr12.png';
    }
    console.log(imageUrl);
    $('.payment_mode_schedule').prop('src', imageUrl);
    return true;
}, jQuery.validator.format("Please enter a valid mobile number."));

jQuery.validator.addMethod("mobile", function(value, element, params) {
    return this.optional( element ) || /([0-9]{11})|(\([0-9]{3}\)\s+[0-9]{3}\-[0-9]{4})/.test( value );
}, jQuery.validator.format("Please enter a valid mobile number."));

(function( $ ){
    $.fn.compute_age = function($date) {
        var dob = new Date($date);
        var today = new Date();
        var age = Math.floor((today-dob) / (365.25 * 24 * 60 * 60 * 1000));
        return age;
    }; 
 })( jQuery );

jQuery(document).ready(function() {    
    WizardDemo.init();

    $('.m_selectpicker').selectpicker();

    if ($('input[name="student_birthdate"]').val() !== '') {
        var age = $('body').compute_age($('input[name="student_birthdate"]').val());
        $('input[name="student_age"]').val(age);
    }

    $('body').on('change', 'input[name="student_birthdate"]', function (e){
        e.preventDefault();
        var age = $('body').compute_age($(this).val());
        $('input[name="student_age"]').val(age);
    });

    $('body').on('click', 'input[name="is_new"]', function (e){
        var self = $(this);
        var value = $(this).val();
        if (value == 0) {
            $('#student-row').removeClass('hidden').find('input[name="student_number"]').val('').removeClass('hidden');
        } else {
            $('#student-row').addClass('hidden').find('input[name="student_number"]').addClass('hidden');
        }
    });

    $('body').on('click', 'input[name="student_studying"], input[name="father_religion"], input[name="mother_religion"]', function (e){
        var self = $(this);
        var value = $(this).val();
        if (value == 'Other') {
            self.parents('.m-radio-list').next().removeClass('hidden').prop('disabled', false);
        } else {
            self.parents('.m-radio-list').next().addClass('hidden').prop('disabled', true);
        }
    });

    $('body').on('click', 'input[name="student_challenges_education[]"], input[name="student_devices[]"]', function (e){
        var self = $(this);
        var zero = 0;
        var inputname = self.attr('name');
        $.each($('input[name="' +inputname + '"]:checked'), function(){
            if ($(this).val() == 'Other') {
                zero++;
            }
        });
        if (zero > 0) {
            self.parents('.m-radio-list, .m-checkbox-list').next().removeClass('hidden').prop('disabled', false);
        } else {
            self.parents('.m-radio-list, .m-checkbox-list').next().addClass('hidden').prop('disabled', true);
        }
    });

    $('body').on('click', '#search-student-btn', function (e){
        e.preventDefault();
        var self = $(this);
        $.ajax({
            type: "GET",
            url: base_url + 'enrollment/search?id_number='+ $('input[name="student_number"]').val(),
            success: function(response) {
                var data = JSON.parse(response);
                var _form = $('form[name="enrollment_form"]');
                console.log(data);
                $.each(data.data, function(k, v) {
                    var _input = _form.find('[name="' + k + '"]');
                    if (k == 'student_birthdate') {
                        _input.val( v );
                        _form.find('[name="student_age"]').val($('body').compute_age(v));
                    } else {
                        if (_input.is(':radio')) {
                            if (v !== '') {
                                _form.find('[name="' + k + '"][value="' + v + '"]').prop('checked', true);
                            }
                        } else if (_input.is(':checkbox')) {
                            if (v !== '') {
                                var vArray = v.split(',');
                                for(var i = 0; i < vArray.length; i++){
                                    _form.find('[name="' + k + '"][value="' + vArray[i] + '"]').prop('checked', true);
                                }
                            }
                        } else {
                            _input.val( v );
                        }
                    }
                }); 
            },
            async: false
        });
    });

    Dropzone.autoDiscover = false;
	// var accept = ".csv";

	$('#import-student-document-dropzone').dropzone({
		// acceptedFiles: accept,
		init: function () {
		this.on("processing", function(file) {
			this.options.url = base_url + 'enrollment/uploads?lrn=' + $('input[name="lrn_no"]').val();
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
		});  
		this.on("error", function(file){if (!file.accepted) this.removeFile(file);});            
		}
	});
});