!function($) {
    "use strict";

    var class_record_wizzardS = function() {
        this.$body = $("body");
    };

    var $required = 0; var files = []; var filesName = [];

    class_record_wizzardS.prototype.validates = function($form)
    {   
        $required = 0;

        $.each($('body .m-wizard__form-step--current').find("input[type='text'], select, textarea"), function(){
               
            if (!($(this).attr("name") === undefined || $(this).attr("name") === null)) {
                if($(this).hasClass("required")){
                    if($(this).is("[multiple]")){
                        if( !$(this).val() || $(this).find('option:selected').length <= 0 ){
                            $(this).closest(".form-group").addClass("has-danger").find(".m-form__help").text("this field is required.");
                            $required++;
                        }
                    } else if($(this).val()=="" || $(this).val()=="0"){
                        if(!$(this).is("select")) {
                            $(this).closest(".form-group").addClass("has-danger").find(".m-form__help").text("this field is required.");
                            $required++;
                        } else {
                            $(this).closest(".form-group").addClass("has-danger").find(".m-form__help").text("this field is required.");
                            $required++;                                          
                        }
                    } 
                }
            }
        });

        $('body').stop().animate({
            scrollTop: $('.has-danger').top - 100
        }, 1500, 'easeInOutExpo');

        return $required;
    },

    class_record_wizzardS.prototype.required_fields = function() {

        $('.form-group span.c-red').remove();

        $.each(this.$body.find(".form-group"), function(){
            
            if ($(this).hasClass('required')) {
                $(this).find('label').append('<span class="pull-right c-red">*</span>');            
                $(this).find("input[type='text'], select, textarea").addClass('required');
            } else {
                $(this).find("input[type='text'], select, textarea").removeClass('required');
            }  

        });

    },

    class_record_wizzardS.prototype.price_separator = function (input) {
        var output = input
        if (parseFloat(input)) {
            input = new String(input); // so you can perform string operations
            var parts = input.split("."); // remove the decimal part
            parts[0] = parts[0].split("").reverse().join("").replace(/(\d{3})(?!$)/g, "$1,").split("").reverse().join("");
            output = parts.join(".");
        }

        return output;
    },

    class_record_wizzardS.prototype.do_uploads = function() {
        var data = new FormData();
        $.each(files, function(key, value)
        {   
            data.append(key, value);
        }); 
        
        console.log(data);
        $.ajax({
            type: "POST",
            url: base_url + 'applications/uploads?files',
            data: data,
            cache: false,
            processData: false,
            contentType: false,
            success: function (data) {
                console.log(data);                       
            }
        });

        return true;
    },

    class_record_wizzardS.prototype.init = function()
    {   
        var wizardEl = $('#m_wizard');
        var formEl = $('#m_form');
        var validator;
        var wizard;
        var stepCurrent = stepStart;
        

        var initWizard = function () {
            //== Initialize form wizard
            console.log(stepStart);
            wizard = wizardEl.mWizard({
                startStep: stepStart,
                clickableSteps: true
            }); 

            //== Validation before going to next page
            wizard.on('beforeNext', function(wizard) {
                var d1 = $.class_record_wizzardS.validates('validate');
                if (d1 != 0) {
                    console.log(d1);
                    return false; return false;
                }
                
            });

            //== Change event
            wizard.on('change', function(wizard) {
                console.log(wizard.currentStep);
                var breadcrumb = $.trim($('body .m-wizard__steps .m-wizard__step--current .m-wizard__step-label').html());
                $('.breadcrumb-title').text(breadcrumb);
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
                    // application_no: {
                    //     required: true 
                    // },
                    // application_title: {
                    //     required: true 
                    // },
                    // application_filing_date: {
                    //     required: true 
                    // },
                    // application_category: {
                    //     required: true 
                    // },
                    email: {
                        required: true,
                        email: true 
                    },       
                    phone: {
                        required: true,
                        phoneUS: true 
                    },     

                    //== Mailing address
                    address1: {
                        required: true 
                    },
                    city: {
                        required: true 
                    },
                    state: {
                        required: true 
                    },
                    city: {
                        required: true 
                    },
                    country: {
                        required: true 
                    },

                    //=== Client Information(step 2)
                    //== Account Details
                    account_url: {
                        required: true,
                        url: true
                    },
                    account_username: {
                        required: true,
                        minlength: 4
                    },
                    account_password: {
                        required: true,
                        minlength: 6
                    },                

                    //== Client Settings
                    account_group: {
                         required: true
                    },                
                    'account_communication[]': {
                        required: true
                    },

                    //=== Client Information(step 3)
                    //== Billing Information
                    billing_card_name: {
                        required: true
                    },
                    billing_card_number: {
                        required: true,
                        creditcard: true
                    },
                    billing_card_exp_month: {
                        required: true
                    },
                    billing_card_exp_year: {
                        required: true
                    },
                    billing_card_cvv: {
                        required: true,
                        minlength: 2,
                        maxlength: 3
                    },

                    //== Billing Address
                    billing_address_1: {
                        required: true
                    },
                    billing_address_2: {
                        
                    },
                    billing_city: {
                        required: true
                    },
                    billing_state: {
                        required: true
                    },
                    billing_zip: {
                        required: true,
                        number: true
                    },
                    billing_delivery: {
                        required: true
                    },

                    //=== Confirmation(step 4)
                    accept: {
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

                if (validator.form()) {
                    //== See: src\js\framework\base\app.js
                    mApp.progress(btn);
                    //mApp.block(formEl); 

                    //== See: http://malsup.com/jquery/form/#ajaxSubmit
                    formEl.ajaxSubmit({
                        success: function() {
                            mApp.unprogress(btn);
                            //mApp.unblock(formEl);

                            swal({
                                "title": "", 
                                "text": "The application has been successfully submitted!", 
                                "type": "success",
                                "confirmButtonClass": "btn btn-secondary m-btn m-btn--wide"
                            });
                        }
                    });
                }
            });
        }

        initWizard(); 
        initValidation();
        initSubmit();
            
        $('input[type="file"]').on('change', prepareUpload);                 
        function prepareUpload(event)
        {       
            var self = event.target;
            if (event.target.files[0] != '' && event.target.files[0] !== undefined) {
                var found = false;
                for (var i = 0; i < filesName.length; i++) {
                    if (filesName[i] == event.target.name) {
                        found = true;
                        break; break;
                    }
                }

                if (found == true) {
                    files[i] = event.target.files[0];
                } else {
                    filesName.push(event.target.name);
                    files.push(event.target.files[0]);
                }
            } else {
                $.each(filesName, function (ix) {
                    if (filesName[ix] == event.target.name) {
                        filesName.splice(ix, 1);
                        files.splice(ix, 1);
                        console.log(self);
                        return false;
                    }
                });
            }

            console.log(filesName);
            console.log(files);
        } 

        /*
        | ---------------------------------
        | # select, input, and textarea on change or keyup remove error
        | ---------------------------------
        */
        this.$body.on('keypress', '.numeric-double', function (event) {
            var $this = $(this);
            if ((event.which != 46 || $this.val().indexOf('.') != -1) &&
                ((event.which < 48 || event.which > 57) &&
                    (event.which != 0 && event.which != 8))) {
                event.preventDefault();
            }
    
            var text = $(this).val();
            if ((event.which == 46) && (text.indexOf('.') == -1)) {
                setTimeout(function () {
                    if ($this.val().substring($this.val().indexOf('.')).length > 3) {
                        $this.val($this.val().substring(0, $this.val().indexOf('.') + 3));
                    }
                }, 1);
            }
    
            if ((text.indexOf('.') != -1) &&
                (text.substring(text.indexOf('.')).length > 2) &&
                (event.which != 0 && event.which != 8) &&
                ($(this)[0].selectionStart >= text.length - 2)) {
                event.preventDefault();
            }
        });

        this.$body.on('blur', '.numeric-double', function (event) {
            var $total = 0;
            $.each($('.numeric-double'), function(){
                var $self = $(this);
                if ($self.val() != '' && $self.val() > 0) {
                    $total += parseFloat($self.val());
                }
            });
            $('#totalAppAmount').text($.class_record_wizzardS.price_separator(parseFloat($total).toFixed(2)));
            console.log($total);
        });


        this.$body.on('change', 'select, input', function (e) {
            e.preventDefault();
            var self = $(this);
            self.closest(".form-group").removeClass("has-danger").find(".form-control-feedback").text("");
        });
        this.$body.on('dp.change', '.date-picker, .time-picker', function (e){
            e.preventDefault();
            var self = $(this);
            $(this).closest(".form-group").removeClass("has-danger").find(".form-control-feedback").text
        });

        this.$body.on('keyup', 'input, textarea', function (e) {
            e.preventDefault();
            var self = $(this);
            $(this).closest(".form-group").removeClass("has-danger").find(".form-control-feedback").text("");
        });
        this.$body.on('blur', 'input, textarea', function (e) {
            e.preventDefault();
            var self = $(this);
            self.closest(".form-group").removeClass("has-danger").find(".form-control-feedback").text("");
        });

        /*
        | ---------------------------------
        | # formality examination report mailing date on blur
        | ---------------------------------
        */
        this.$body.on('blur', 'input[name="sub_mailing_date1"]', function (e){
            var self = $(this);
            if (self.val() != '') {
                $('input[name="sub_amount_file1"]').prop('disabled', false).closest('.form-group').removeClass('required');
                $('input[name="sub_filing_date1"]').prop('disabled', false).closest('.form-group').addClass('required');
                $.class_record_wizzardS.required_fields();
            }
        });

        /*
        | ---------------------------------
        | # formality examination report subsequent input checkbox
        | ---------------------------------
        */
        this.$body.on('click', 'input[name="fer_yes_no"]', function (e) {
            var self = $(this);
            if (self.val() == 'Yes') {
                $('.subsequent-form-2').removeClass('hidden');
                $('.subsequent-form-1').find('input').prop('disabled', true);
                $('input[name="sub_paper_no1"], input[name="sub_mailing_date1"], input[name="sub_filing_date1"]').closest('.form-group').removeClass('required').find('.m-form__help').text('');
                $('input[name="sub_paper_no2"], input[name="sub_mailing_date2"]').closest('.form-group').addClass('required').find('.m-form__help').text('');
                if ($('input[name="sub_mailing_date2"]').val() != '') {
                    $('input[name="sub_filing_date2"]').closest('.form-group').addClass('required').find('.m-form__help').text('');
                }
                $.class_record_wizzardS.required_fields();
            } else {
                $('.subsequent-form-2').addClass('hidden');
                $('.subsequent-form-1').find('input').prop('disabled', false);
                $('input[name="sub_paper_no1"], input[name="sub_mailing_date1"]').closest('.form-group').addClass('required').find('.m-form__help').text('');
                $('input[name="sub_paper_no2"], input[name="sub_mailing_date2"], input[name="sub_filing_date2"]').closest('.form-group').removeClass('required').find('.m-form__help').text('');
                if ($('input[name="sub_mailing_date1"]').val() != '') {
                    $('input[name="sub_filing_date1"]').closest('.form-group').addClass('required').find('.m-form__help').text('');
                }
                $.class_record_wizzardS.required_fields();
            }
        });

        /*
        | ---------------------------------
        | # formality examination report subsequent mailing date on blur
        | ---------------------------------
        */
        this.$body.on('blur', 'input[name="sub_mailing_date2"]', function (e){
            var self = $(this);
            if (self.val() != '') {
                $('input[name="sub_amount_file2"]').prop('disabled', false).closest('.form-group').removeClass('required');
                $('input[name="sub_filing_date2"]').prop('disabled', false).closest('.form-group').addClass('required');
                $.class_record_wizzardS.required_fields();
            }
        });

        /*
        | ---------------------------------
        | # substantive examination report filing date on blur
        | ---------------------------------
        */
        this.$body.on('blur', 'input[name="subs_filing_date1"]', function (e){
            var self = $(this);
            if (self.val() != '') {
                $('input[name="subs_paper_no1"]').prop('disabled', false).closest('.form-group').removeClass('required');
                $('input[name="subs_mailing_date1"]').prop('disabled', false).closest('.form-group').addClass('required');
                $.class_record_wizzardS.required_fields();
            }
        });

        /*
        | ---------------------------------
        | # substantive examination report subsequent input checkbox
        | ---------------------------------
        */
        this.$body.on('click', 'input[name="subsequent_checklist_form_4"]', function (e) {
            var self = $(this);
            if (self.val() == 'Yes') {
                $('.subsequent-form-4-2').removeClass('hidden');
                $('.subsequent-form-4-1').find('input').prop('disabled', true);
                $('input[name="subs_amount_file2"], input[name="subs_filing_date2"]').closest('.form-group').addClass('required');
                $('input[name="subs_amount_file2"], input[name="subs_filing_date2"]').prop('disabled', false);
                $.class_record_wizzardS.required_fields();
            } else {
                $('.subsequent-form-4-2').addClass('hidden');
                $('.subsequent-form-4-1').find('input').prop('disabled', false);
                $('input[name="subs_amount_file2"], input[name="subs_filing_date2"]').closest('.form-group').removeClass('required');
                $('input[name="subs_amount_file2"], input[name="subs_filing_date2"]').prop('disabled', true);
                $.class_record_wizzardS.required_fields();
            }
        });

        /*
        | ---------------------------------
        | # substantive examination report filing date on blur
        | ---------------------------------
        */
        this.$body.on('blur', 'input[name="subs_filing_date2"]', function (e){
            var self = $(this);
            if (self.val() != '') {
                $('input[name="subs_paper_no2"]').prop('disabled', false).closest('.form-group').removeClass('required');
                $('input[name="subs_mailing_date2"]').prop('disabled', false).closest('.form-group').addClass('required');
                $.class_record_wizzardS.required_fields();
            }
        });

        /*
        | ---------------------------------
        | # save button click
        | ---------------------------------
        */
        this.$body.on('click', '#save-btn', function (e){
            e.preventDefault();
            var btn = $(this);
            var $form = $('#m_form');
            var appID = $('input[name="app_id"]');
            var inputfile1 = ($('input[name="app_file"]').val() != '') ? $('input[name="app_file"]').get(0).files[0].name : '';
            var inputfile2 = ($('input[name="sub_file1"]').val() != '') ? $('input[name="sub_file1"]').get(0).files[0].name : '';   
            var inputfile3 = ($('input[name="sub_file2"]').val() != '') ? $('input[name="sub_file2"]').get(0).files[0].name : ''; 
            var inputfile4 = ($('input[name="pub_file"]').val() != '') ? $('input[name="pub_file"]').get(0).files[0].name : ''; 
            var inputfile5 = ($('input[name="subs_file1"]').val() != '') ? $('input[name="subs_file1"]').get(0).files[0].name : ''; 
            var inputfile6 = ($('input[name="subs_file2"]').val() != '') ? $('input[name="subs_file2"]').get(0).files[0].name : ''; 
            var inputfile7 = ($('input[name="allow_file"]').val() != '') ? $('input[name="allow_file"]').get(0).files[0].name : '';

            btn.addClass('m-loader m-loader--right m-loader--light').attr('disabled', true);

            var applicants = $('input[name="app_applicants"]').val();

            /*
            | ---------------------------------
            | # uploads ajax
            | ---------------------------------
            */   
            var d1 = $.class_record_wizzardS.do_uploads();

            $.when( d1 ).done(function ( v1 ) 
            {   
                /*
                | ---------------------------------
                | # save ajax
                | ---------------------------------
                */
                var $url = (appID.val() != '') ? 
                    base_url + 'applications/update/' + appID.val() + '?file1=' + inputfile1 + '&file2=' + inputfile2 + '&file3=' + inputfile3 + '&file4=' + inputfile4 + '&file5=' + inputfile5 + '&file6=' + inputfile6 + '&file7=' + inputfile7 : 
                    base_url + 'applications/store?file1=' + inputfile1 + '&file2=' + inputfile2 + '&file3=' + inputfile3 + '&file4=' + inputfile4 + '&file5=' + inputfile5 + '&file6=' + inputfile6 + '&file7=' + inputfile7;
                
                console.log($url);
                $.ajax({
                    type: (appID.val() != '') ? 'PUT' : 'POST',
                    url: $url,
                    data: $form.serialize(),
                    success: function(response) {
                        console.log(response);
                        setTimeout(function() {
                            var data = $.parseJSON(response);   
                            if (appID.val() == '') {
                                appID.val(data.id);
                            }
                            swal({
                                title: 'Sweet!',
                                text: 'The information has been successfully saved.',
                                imageUrl: base_url + 'img/thumbs-up.png',
                                imageWidth: 120,
                                imageHeight: 120,
                                imageAlt: 'thumbs up',
                                animation: false,
                                confirmButtonClass: "btn btn-info btn-focus m-btn m-btn--pill m-btn--air"
                            });
                            btn.removeClass('m-loader m-loader--right m-loader--light').attr('disabled', false);
                        }, 1000);
                    }, 
                    complete: function() {
                        window.onkeydown = null;
                        window.onfocus = null;
                    }
                });
            });
        });

        /*
        | ---------------------------------
        | # application no on blur
        | ---------------------------------
        */
        this.$body.on('blur', 'input[name="app_no"]', function (e){
            var self = $(this);
            var className = $(this).attr('name');
            var infoWidget = $('.app-widget-info');

            if (self.val() != '') {
                infoWidget.find('.' + className).text(self.val());
            } else {
                infoWidget.find('.' + className).text('');
            }
        });

        /*
        | ---------------------------------
        | # application no on blur
        | ---------------------------------
        */
        this.$body.on('blur', 'input[name="app_title"]', function (e){
            var self = $(this);
            var className = $(this).attr('name');
            var infoWidget = $('.app-widget-info');

            if (self.val() != '') {
                infoWidget.find('.' + className).text(self.val());
            } else {
                infoWidget.find('.' + className).text('');
            }
        });

        /*
        | ---------------------------------
        | # application category on change
        | ---------------------------------
        */
        this.$body.on('change', 'select[name="app_category"]', function (e){
            var self = $(this);
            var className = $(this).attr('name');
            var infoWidget = $('.app-widget-info');

            if (self.val() != 0) {
                infoWidget.find('.' + className).text(self.find('option:selected').text());
            } else {
                infoWidget.find('.' + className).text('');
            }
        });

        /*
        | ---------------------------------
        | # application no on change
        | ---------------------------------
        */
        this.$body.on('blur', '#applicants', function (e){
            var self = $(this);
            var className = $(this).attr('name');
            var infoWidget = $('.app-widget-info');

            self.val();
            // if (self.val() != 0) {
            //     infoWidget.find('.' + className).text(self.find('option:selected').text());
            // } else {
            //     infoWidget.find('.' + className).text('');
            // }
        });
    }

    //init class_record_wizzardS
    $.class_record_wizzardS = new class_record_wizzardS, $.class_record_wizzardS.Constructor = class_record_wizzardS

}(window.jQuery),

//initializing class_record_wizzardS
function($) {
    "use strict";
    $.class_record_wizzardS.required_fields();
    $.class_record_wizzardS.init();
}(window.jQuery);
