!function($) {
    "use strict";

    var emailblast = function() {
        this.$body = $("body");
    };

    var $required = 0; var files = []; var filesName = [];

    emailblast.prototype.validate = function($form, $required)
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

    emailblast.prototype.required_fields = function() {
        
        $.each(this.$body.find(".form-group"), function(){
            if ($(this).hasClass('required')) {       
                var $input = $(this).find("input[type='date'], input[type='text'], select, textarea");
                if ($input.val() == '') {
                    $(this).find('.m-form__help').text('this field is required.');       
                }
                $input.addClass('required');
            } else {
                $(this).find("input[type='text'], select, textarea").removeClass('required');
            } 
        });

    },

    emailblast.prototype.price_separator = function (input) {
        var output = input
        if (parseFloat(input)) {
            input = new String(input); // so you can perform string operations
            var parts = input.split("."); // remove the decimal part
            parts[0] = parts[0].split("").reverse().join("").replace(/(\d{3})(?!$)/g, "$1,").split("").reverse().join("");
            output = parts.join(".");
        }

        return output;
    },

    emailblast.prototype.do_uploads = function($id) {
        var data = new FormData();
        for (var i = 0; i < $('input[name="attachments[]"]').get(0).files.length; ++i) {
            data.append('file[]', $('input[name="attachments[]"]').get(0).files[i]);
        }

        $.ajax({
            type: "POST",
            url: base_url + 'notifications/messaging/emailblast/uploads?files=staffs&id='+$id,
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

    emailblast.prototype.init = function()
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

        this.$body.on('keyup', '#name', function (e){
            e.preventDefault();
            var self = $(this).val();
            $('#code').val(self.replace(/\s+/g, '-').toLowerCase());
            $('#code').closest(".form-group").find(".m-form__help").text("");
        });

        this.$body.on('click', '.submit-btn', function (e){
            e.preventDefault();
            var filename_arr = [];
            var $self = $(this);
            var $form = $('form[name="emailblast_form"]');
            var $error = $.emailblast.validate($form, 0);
            var messagedata = CKEDITOR.instances.message_editor.getData();

            for (var i = 0; i < $('input[name="attachments[]"]').get(0).files.length; ++i) {
                filename_arr[i] = $('input[name="attachments[]"]').get(0).files[i].name;
            }

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
                $.emailblast.required_fields();
            } else {
                
                swal({
                    title: "Sending...",
                    text: "Please do not close.",
                    allowOutsideClick: false,
                    showCancelButton: false,
                    showConfirmButton: false,
                });
                
                $self.prop('disabled', true).html('wait.....').addClass('m-btn--custom m-loader m-loader--light m-loader--right');
                var d1 = $.emailblast.do_uploads(1);
                $.when( d1 ).done(function ( v1 )
                {
                    if (v1 > 0) {

                        $.ajax({
                            type: $form.attr('method'),
                            url: $form.attr('action'),
                            data: $form.serialize()+'&message_editor='+encodeURIComponent(messagedata)+'&filename='+filename_arr,
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
                                                    window.location.replace(base_url + 'notifications/messaging/emailblast/new');
                                                }
                                            }
                                        });
                                    }, 500 + 300 * (Math.random() * 5));
                                } else {
                                    $self.html('<i class="la la-save"></i> Save Changes').removeClass('m-loader m-loader--right m-loader--light').attr('disabled', false);
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
        
    }

    //init emailblast
    $.emailblast = new emailblast, $.emailblast.Constructor = emailblast

}(window.jQuery),

//initializing emailblast
function($) {
    "use strict";
    $.emailblast.required_fields();
    $.emailblast.init();

    $('[name="checkbox_autoattachment"]').change(function(){
        if ($(this).is(':checked')) {
            $('.radio-autoattachment').show();
        } else {
            $('.radio-autoattachment').hide();
        }
    });

}(window.jQuery);
