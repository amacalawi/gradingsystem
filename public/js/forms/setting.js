!function($) {
    "use strict";

    var setting = function() {
        this.$body = $("body");
    };

    var $required = 0; var files = []; var filesName = [];

    setting.prototype.validate = function($form, $required)
    {   
        $required = 0;

        $.each(this.$body.find("input[type='email'], input[type='radio'], input[type='password'], input[type='date'], input[type='text'], select, textarea"), function(){
            var $self = $(this);
            if (!($self.attr("name") === undefined || $self.attr("name") === null)) {
                if($self.hasClass("required")){
                    if ($self.attr('type') == "radio" && $self.val() == "") {
                        $self.closest(".form-group").find(".m-form__help").text("this field is required.");
                        $required++;
                    } else if($self.is("[multiple]")){
                        if( !$self.val() || $self.find('option:selected').length <= 0 ){
                            $self.closest(".form-group").find(".m-form__help").text("this field is required.");
                            $required++;
                        }
                    } else if($self.val()=="" || $self.val()=="0"){
                        if(!$self.is("select")) {
                            $self.closest(".form-group").find(".m-form__help").text("this field is required.");
                            $required++;
                        } else {
                            $self.closest(".form-group").find(".m-form__help").text("this field is required.");
                            $required++;                                          
                        }
                    } 
                }
            }
        });

        return $required;
    },

    setting.prototype.required_fields = function() {
        
        $.each(this.$body.find(".form-group"), function(){
            if ($(this).hasClass('required')) {       
                var $input = $(this).find("input[type='email'], input[type='radio'], input[type='password'], input[type='date'], input[type='text'], select, textarea");
                if ($input.attr('type') == 'radio') {
                    if ( !$input.is(':checked') ) {
                        $(this).find('.m-form__help').text('this field is required.');    
                    }
                } else {
                    if ($input.val() == '') {
                        $(this).find('.m-form__help').text('this field is required.');   
                    }
                }
                $input.addClass('required');
            } else {
                $(this).find("input[type='radio'], input[type='password'], input[type='date'], input[type='text'], select, textarea").removeClass('required');
            } 
        });

    },

    setting.prototype.price_separator = function (input) {
        var output = input
        if (parseFloat(input)) {
            input = new String(input); // so you can perform string operations
            var parts = input.split("."); // remove the decimal part
            parts[0] = parts[0].split("").reverse().join("").replace(/(\d{3})(?!$)/g, "$1,").split("").reverse().join("");
            output = parts.join(".");
        }

        return output;
    },

    setting.prototype.do_uploads = function() {
        var data = new FormData();
        $.each(files, function(key, value)
        {   
            data.append(key, value);
        }); 
        
        console.log(data);
        $.ajax({
            type: "POST",
            url: base_url + 'settings/uploads?files=settings',
            data: data,
            cache: false,
            processData: false,
            contentType: false,
            async: false,
            success: function (data) {
                console.log(data);                       
            }
        });

        return true;
    },

    setting.prototype.readURL = function(input) {
        if (input.files && input.files[0]) {
            var self = input.files[0];
            var closeFile = $(input).closest('.avatar-upload').find('.close-file');
            console.log(closeFile);
            var reader = new FileReader();
            reader.onload = function(e) {
                $(input).closest('.avatar-upload').find('.avatar_preview').css('background-image', 'url('+e.target.result +')');
                $(input).closest('.avatar-upload').find('.avatar_preview').hide();
                $(input).closest('.avatar-upload').find('.avatar_preview').fadeIn(650);
            }
            reader.readAsDataURL(input.files[0]);
    
            console.log(self);
            if (self.length != 0) {
                closeFile.removeClass('invisible');
            } else {
                closeFile.addClass('invisible');
            }
        }
    }
    
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

    setting.prototype.isValidEmailAddress = function () {
        var emailError = 0;
        var pattern = /^([a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+(\.[a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+)*|"((([ \t]*\r\n)?[ \t]+)?([\x01-\x08\x0b\x0c\x0e-\x1f\x7f\x21\x23-\x5b\x5d-\x7e\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|\\[\x01-\x09\x0b\x0c\x0d-\x7f\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))*(([ \t]*\r\n)?[ \t]+)?")@(([a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.)+([a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.?$/i;

        $.each(this.$body.find("input[type='email']"), function(){
            var $self = $(this);
            if ($self.val() != '') {
                var validEmail = pattern.test($self.val());

                if (!validEmail) {
                    emailError++;
                    $self.next().text('this is not a valid email');
                }
            }
        });

        return emailError;
    },

    setting.prototype.init = function()
    {   
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

        this.$body.on('change', 'select, input', function (e) {
            e.preventDefault();
            var self = $(this);
            self.closest(".form-group").find(".m-form__help").text("");
        });
        this.$body.on('dp.change', '.date-picker, .time-picker', function (e){
            e.preventDefault();
            var self = $(this);
            $(this).closest(".form-group").find(".m-form__help").text("");
        });
        this.$body.on('keyup', 'input, textarea', function (e) {
            e.preventDefault();
            var self = $(this);
            $(this).closest(".form-group").find(".m-form__help").text("");
        });
        this.$body.on('blur', 'input, textarea, select', function (e) {
            e.preventDefault();
            var self = $(this);
            self.closest(".form-group").find(".m-form__help").text("");
        });

        this.$body.on('changeDate', 'input[type="date"]', function (e){
            e.preventDefault();
            var self = $(this);
            self.closest(".form-group").find(".m-form__help").text("");
        });

        this.$body.on('click', '.submit-btn', function (e){
            e.preventDefault();
            var $self = $(this);
            var $form = $('form[name="setting_form"]');
            var $error = $.setting.validate($form, 0);
            var $avatar = ($('input[name="avatar"]').val() != '') ? $('input[name="avatar"]').get(0).files[0].name : '';
            var $emailError = $.setting.isValidEmailAddress();

            if ($error != 0) {
                swal({
                    title: "Oops...",
                    text: "Something went wrong! \nPlease fill in the required fields first.",
                    type: "warning",
                    showCancelButton: false,
                    closeOnConfirm: true,
                    confirmButtonClass: "btn btn-warning btn-focus m-btn m-btn--pill m-btn--air m-btn--custom"
                });
                window.onkeydown = null;
                window.onfocus = null;   
                $.setting.required_fields();
            } else if ($emailError > 0) {
                swal({
                    title: "Oops...",
                    text: "Something went wrong! \nPlease use a valid email.",
                    type: "warning",
                    showCancelButton: false,
                    closeOnConfirm: true,
                    confirmButtonClass: "btn btn-warning btn-focus m-btn m-btn--pill m-btn--air m-btn--custom"
                });
                window.onkeydown = null;
                window.onfocus = null;
            } else {
                $self.prop('disabled', true).html('wait.....').addClass('m-btn--custom m-loader m-loader--light m-loader--right');
                var d1 = $.setting.do_uploads();
                $.when( d1 ).done(function ( v1 ) 
                {
                    // do uploads then submit data
                    if (v1 > 0) {
                        $.ajax({
                            type: $form.attr('method'),
                            url: $form.attr('action') + '?avatar=' + $avatar,
                            data: $form.serialize(),
                            success: function(response) {
                                var data = $.parseJSON(response);   
                                console.log(data);
                                if (data.type == 'success') {
                                    setTimeout(function () {
                                        $self.html('<i class="la la-save"></i> Save Changes').removeClass('m-loader m-loader--right m-loader--light').attr('disabled', false);
                                        swal({
                                            title: data.title,
                                            text: data.text,
                                            type: data.type,
                                            confirmButtonClass: "btn " + data.class + " btn-focus m-btn m-btn--pill m-btn--air m-btn--custom",
                                            onClose: () => {
                                                if ($form.find("input[name='method']").val() == 'add') {
                                                    window.location.replace(base_url + 'memberships/students');
                                                }
                                            }
                                        });
                                    }, 500 + 300 * (Math.random() * 5));
                                } else {
                                    $self.html('<i class="la la-save"></i> Save Changes').removeClass('m-loader m-loader--right m-loader--light').attr('disabled', false);
                                    $form.find('input[name="' + data.error + '"]').next().text(data.text);
                                    swal({
                                        title: data.title,
                                        text: data.text,
                                        type: data.type,
                                        showCancelButton: false,
                                        closeOnConfirm: true,
                                        confirmButtonClass: "btn " + data.class + " btn-focus m-btn m-btn--pill m-btn--air m-btn--custom",
                                    });
                                }
                            }, 
                            complete: function() {
                                window.onkeydown = null;
                                window.onfocus = null;
                            }
                        });
                    }
                });
            }
        });
        

        this.$body.on('change', '.avatar-upload input[type="file"]', function (e) {
            $.setting.readURL(this);
        });
        
        this.$body.on('click', '.close-file', function (e) {
            e.preventDefault();
            var $self = $(this);
            $self.addClass('invisible');
            
            var file = $self.closest('.avatar-upload').find('input[type="file"]');
            var emptyFile = document.createElement('input');
            emptyFile.type = 'file';
            file.files = emptyFile.files;
    
            $self.closest('.avatar-upload').find('.avatar_preview').css('background-image', '');
        });
    }

    //init setting
    $.setting = new setting, $.setting.Constructor = setting

}(window.jQuery),

//initializing setting
function($) {
    "use strict";
    $.setting.required_fields();
    $.setting.init();
}(window.jQuery);
