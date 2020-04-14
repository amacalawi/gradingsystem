!function($) {
    "use strict";

    var student = function() {
        this.$body = $("body");
    };

    var $required = 0; var files = []; var filesName = [];
    
    var $student_layer = '<div class="row siblings-panel-layout">' +
        '<div class="col-md-11">' +
        '<div class="row">' +
        '<div class="col-md-4">' +
        '<div class="form-group m-form__group">' +
        '<label>' +
        'Firstname' +
        '</label>' +
        '<input type="email" class="form-control form-control-lg m-input m-input--solid" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="">' +
        '<span class="m-form__help m--font-danger">' +
        'this field is required.' +
        '</span>' +
        '</div>' +
        '</div>' +
        '<div class="col-md-4">' +
        '<div class="form-group m-form__group">' +
        '<label for="name">' +
        'Middlename' +
        '</label>' +
        '<input type="text" id="name" name="name" class="form-control form-control-lg m-input m-input--solid" aria-describedby="emailHelp" placeholder="">' +
        '<span class="m-form__help m--font-danger">' +
        'this field is required.' +
        '</span>' +
        '</div>' +
        '</div>' +
        '<div class="col-md-4">' +
        '<div class="form-group m-form__group">' +
        '<label for="name">' +
        'Lastname' +
        '</label>' +
        '<input type="text" id="name" name="name" class="form-control form-control-lg m-input m-input--solid" aria-describedby="emailHelp" placeholder="">' +
        '<span class="m-form__help m--font-danger">' +
        'this field is required.' +
        '</span>' +
        '</div>' +
        '</div>' +
        '</div>' +
        '</div>' +
        '<div class="col-md-1">' +
        '<div class="row">' +
        '<div class="col-md-12">' +
        '<button type="button" class="minus-sibling btn">' +
        '<i class="la la-minus"></i>' +
        '</button>' +
        '</div>' +
        '</div>' +
        '</div>' +
        '</div>';

    student.prototype.validate = function($form, $required)
    {   
        $required = 0;

        $.each(this.$body.find("input[type='date'], input[type='text'], select, textarea"), function(){
               
            if (!($(this).attr("name") === undefined || $(this).attr("name") === null)) {
                if($(this).hasClass("required")){
                    if($(this).is("[multiple]")){
                        if( !$(this).val() || $(this).find('option:selected').length <= 0 ){
                            $(this).closest(".form-group").find(".m-form__help").text("this field is required.");
                            $required++;
                        }
                    } else if($(this).val()=="" || $(this).val()=="0"){
                        if(!$(this).is("select")) {
                            $(this).closest(".form-group").find(".m-form__help").text("this field is required.");
                            $required++;
                        } else {
                            $(this).closest(".form-group").find(".m-form__help").text("this field is required.");
                            $required++;                                          
                        }
                    } 
                }
            }
        });

        return $required;
    },

    student.prototype.required_fields = function() {
        
        $.each(this.$body.find(".form-group"), function(){
            if ($(this).hasClass('required')) {       
                var $input = $(this).find("input[type='radio'], input[type='password'], input[type='date'], input[type='text'], select, textarea");
                if ($input.val() == '' || $input.is(":not(:checked)")) {
                    $(this).find('.m-form__help').text('this field is required.');       
                }
                $input.addClass('required');
            } else {
                $(this).find("input[type='radio'], input[type='password'], input[type='date'], input[type='text'], select, textarea").removeClass('required');
            } 
        });

    },

    student.prototype.price_separator = function (input) {
        var output = input
        if (parseFloat(input)) {
            input = new String(input); // so you can perform string operations
            var parts = input.split("."); // remove the decimal part
            parts[0] = parts[0].split("").reverse().join("").replace(/(\d{3})(?!$)/g, "$1,").split("").reverse().join("");
            output = parts.join(".");
        }

        return output;
    },

    student.prototype.do_uploads = function($id) {
        var data = new FormData();
        $.each(files, function(key, value)
        {   
            data.append(key, value);
        }); 
        
        console.log(data);
        $.ajax({
            type: "POST",
            url: base_url + 'applications/uploads?files=copyrights&id=' + $id,
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

    student.prototype.readURL = function(input) {
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

    student.prototype.init = function()
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
            var $form = $('form[name="student_form"]');
            var $error = $.student.validate($form, 0);

            if ($error != 0) {
                $.student.required_fields();
            } else {
                $self.prop('disabled', true).text('wait... ').addClass('m-btn--custom m-loader m-loader--light m-loader--right');
                setTimeout(function(){ 
                    $form.submit();
                }, 1000);
            }
        });
        
        /*
        | ---------------------------------
        | # parent and siblins on toggle
        | ---------------------------------
        */
        this.$body.on('click', '#add-sibling', function (e) {
            e.preventDefault();
            var $self = $(this);
            var $panel = $('#siblings-panel');
            $panel.append($student_layer);
        });

        this.$body.on('click', '.minus-sibling', function (e) {
            e.preventDefault();
            var $self = $(this);
            var $panel = $self.closest('.siblings-panel-layout');
            $panel.remove();
        });

        this.$body.on('click', '#sibling-cell', function (e) {
            var $panel = $('#siblings-panel, #siblings-panel-button');
            var $label = $('#siblings-label');
            $panel.toggleClass("hidden");
            $label.toggleClass("m-bottom-1");
        });

        this.$body.on('click', '#parent-cell', function (e) {
            var $panel = $('#parents-panel');
            var $label = $('#parents-label');
            $panel.toggleClass("hidden");
            $label.toggleClass("m-bottom-1");
        });

        this.$body.on('change', '.avatar-upload input[type="file"]', function (e) {
            $.student.readURL(this);
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

        this.$body.on('click', '#parent-cell', function (e) {
            var $self = $(this);

            if ($self.is(":checked")) {
                $('#guardian_selected, #mother_firstname, #mother_lastname, #mother_contact_no, #father_firstname, #father_lastname, #father_contact_no').addClass('required').closest('.form-group').addClass('required');
            } else {
                $('#guardian_selected, #mother_firstname, #mother_lastname, #mother_contact_no, #father_firstname, #father_lastname, #father_contact_no').removeClass('required').closest('.form-group').removeClass('required');
            }
            $.student.required_fields();
        });

        this.$body.on('click', '#sibling-cell', function (e) {
            var $self = $(this);

            if ($self.is(":checked")) {
                $('.sibling_firstname, .sibling_lastname').addClass('required').closest('.form-group').addClass('required');
            } else {
                $('.sibling_firstname, .sibling_lastname').removeClass('required').closest('.form-group').removeClass('required');
            }
            $.student.required_fields();
        });
    }

    //init student
    $.student = new student, $.student.Constructor = student

}(window.jQuery),

//initializing student
function($) {
    "use strict";
    $.student.required_fields();
    $.student.init();
}(window.jQuery);
