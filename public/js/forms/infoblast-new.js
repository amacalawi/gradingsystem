!function($) {
    "use strict";

    var infoblast = function() {
        this.$body = $("body");
    };

    var $required = 0; var $groups = []; var $sections = []; var $users = []; var $anonymousMsisdn = []; 

    var $validNumbers = ['0817','0905','0906','0907','0908','0909','0910','0912','0915','0916','0917','0918','0919','0920','0921','0922','0923','0924','0925','0926',
    '0927','0928','0929','0930','0931','0932','0933','0934','0935','0936','0937','0938','0939','0940','0941','0942','0943','0945','0946','0947',
    '0948','0949','0950','0951','0953','0954','0955','0956','0961','0965','0966','0967','0973','0974','0975','0977','0978','0979','0995','0996',
    '0997','0998','0999','0917','0925'];

    infoblast.prototype.validate = function($form, $required)
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

    infoblast.prototype.required_fields = function() {
        
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

    infoblast.prototype.price_separator = function (input) {
        var output = input
        if (parseFloat(input)) {
            input = new String(input); // so you can perform string operations
            var parts = input.split("."); // remove the decimal part
            parts[0] = parts[0].split("").reverse().join("").replace(/(\d{3})(?!$)/g, "$1,").split("").reverse().join("");
            output = parts.join(".");
        }

        return output;
    },

    infoblast.prototype.do_uploads = function($id) {
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

    infoblast.prototype.check_if_msisdn_exist = function($msisdn) {
        var exist = jQuery.inArray( $msisdn, $anonymousMsisdn );
        return exist;
    },

    infoblast.prototype.validate_msisdn = function($msisdn) {
        var validate = jQuery.inArray( $msisdn, $validNumbers );
        return validate;
    },

    infoblast.prototype.validate_recipient = function() {   
        var $recipient = 0;

        if ($groups.length > 0) {
            $recipient++;
        }
        if ($sections.length > 0) {
            $recipient++;
        }
        if ($users.length > 0) {
            $recipient++;
        }
        if ($anonymousMsisdn.length > 0) {
            $recipient++;
        }

        return $recipient;
    },

    infoblast.prototype.init = function()
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
        this.$body.on('keyup', 'input', function (e) {
            e.preventDefault();
            var self = $(this);
            $(this).closest(".form-group").find(".m-form__help").text("");
        });
        this.$body.on('blur', 'input, select', function (e) {
            e.preventDefault();
            var self = $(this);
            self.closest(".form-group").find(".m-form__help").text("");
        });

        this.$body.on('changeDate', 'input[type="date"]', function (e){
            e.preventDefault();
            var self = $(this);
            self.closest(".form-group").find(".m-form__help").text("");
        });

        this.$body.on('keypress', 'input[name="anonymous"]', function (e){
            var self = $(this);
            var parent = self.closest('#m_tabs_6_4');
            var validates = $.infoblast.validate_msisdn(self.val().substring(4, 0));
            var exist = $.infoblast.check_if_msisdn_exist(self.val());

            if (e.which == 13) {
                if (validates !== -1 && self.val().length == 11) {
                    if (exist === -1) {
                        var items = '<label class="m-checkbox m-checkbox--air">' +
                                    '<input name="user[]" type="checkbox" value="' + self.val() + '" checked="checked" disabled>' +
                                    self.val() +
                                    '<span></span>' +
                                    '<a href="javascript:;" class="m--font-secondary remove-anonymous pull-right"><i class="la la-close"></i></a>' +
                                    '</label>';
                        parent.find('.m-checkbox-list').append(items);
                        $anonymousMsisdn.push(self.val());
                        self.val('');
                    }
                }
                console.log($anonymousMsisdn);
                e.preventDefault();
            }
        });

        this.$body.on('click', '.remove-anonymous', function (e) { 
            var self = $(this).closest('.m-checkbox');
            var value = self.find('input').val();
            
            $.each($anonymousMsisdn, function (ix) {
                if ($anonymousMsisdn[ix] == value) {
                    $anonymousMsisdn.splice(ix, 1);
                    self.remove();
                    return false;
                }
            });
            console.log($anonymousMsisdn);
        });
        
        /*
        | ---------------------------------
        | # users checkbox
        | ---------------------------------
        */
        this.$body.on('click', '#m_tabs_6_3 input[type="checkbox"]', function (e) { 
            var self = $(this);
            var value = self.val();

            if (self.is(':checked')) {
                $users.push(value);
            } else {
                $.each($users, function (ix) {
                    if ($users[ix] == value) {
                        $users.splice(ix, 1);
                        return false;
                    }
                });
            }
            console.log($users);
        });

        /*
        | ---------------------------------
        | # sections checkbox
        | ---------------------------------
        */
        this.$body.on('click', '#m_tabs_6_2 input[type="checkbox"]', function (e) { 
            var self = $(this);
            var value = self.val();

            if (self.is(':checked')) {
                $sections.push(value);
            } else {
                $.each($sections, function (ix) {
                    if ($sections[ix] == value) {
                        $sections.splice(ix, 1);
                        return false;
                    }
                });
            }
            console.log($sections);
        });
        
        /*
        | ---------------------------------
        | # groups checkbox
        | ---------------------------------
        */
        this.$body.on('click', '#m_tabs_6_1 input[type="checkbox"]', function (e) { 
            var self = $(this);
            var value = self.val();

            if (self.is(':checked')) {
                $groups.push(value);
            } else {
                $.each($groups, function (ix) {
                    if ($groups[ix] == value) {
                        $groups.splice(ix, 1);
                        return false;
                    }
                });
            }
            console.log($groups);
        });

        this.$body.on('keyup', 'textarea[name="messages"]', function (e){
            var self = $(this);
            var limitholder = self.next();
            limitholder.text( parseFloat(500) - self.val().length);
        });
        this.$body.on('blur', 'textarea[name="messages"]', function (e){
            var self = $(this);
            var limitholder = self.next();
            limitholder.text( parseFloat(500) - self.val().length);
        });
        this.$body.on('paste', 'textarea[name="messages"]', function (e){
            var self = $(this);
            var limitholder = self.next();
            limitholder.text( parseFloat(500) - self.val().length);
        });
        this.$body.on('copy', 'textarea[name="messages"]', function (e){
            var self = $(this);
            var limitholder = self.next();
            limitholder.text( parseFloat(500) - self.val().length);
        });
        this.$body.on('cut', 'textarea[name="messages"]', function (e){
            var self = $(this);
            var limitholder = self.next();
            limitholder.text( parseFloat(500) - self.val().length);
        });

        this.$body.on('click', '.submit-btn', function (e){
            e.preventDefault();
            var $self = $(this);
            var $form = $('form[name="infoblast_form"]');
            var $messages = $form.find('textarea');
            var $type = $form.find('input[type="radio"]');
            var $recipient = $.infoblast.validate_recipient();

            if ($messages.val() == '' || $recipient == 0) {
                swal({
                    title: "Oops...",
                    text: "Something went wrong! \nPlease fill in messages and recipient first.",
                    type: "warning",
                    showCancelButton: false,
                    closeOnConfirm: true,
                    confirmButtonClass: "btn btn-warning btn-focus m-btn m-btn--pill m-btn--air m-btn--custom"
                });
                window.onkeydown = null;
                window.onfocus = null;   
            } else {
                $self.prop('disabled', true).html('wait.....').addClass('m-btn--custom m-loader m-loader--light m-loader--right');
                $.ajax({
                    type: $form.attr('method'),
                    url: $form.attr('action'),
                    data: { 'messages': $messages.val(), 'message_type_id': $type.val(), 'groups': $groups, 'sections': $sections, 'users': $users, 'anonymous': $anonymousMsisdn },
                    success: function(response) {
                        var data = $.parseJSON(response);   
                        console.log(data);
                        if (data.type == 'success') {
                            setTimeout(function () {
                                $self.html('<i class="la la-send"></i> Send Message').removeClass('m-loader m-loader--right m-loader--light').attr('disabled', false);
                                swal({
                                    title: data.title,
                                    text: data.text,
                                    type: data.type,
                                    confirmButtonClass: "btn " + data.class + " btn-focus m-btn m-btn--pill m-btn--air m-btn--custom",
                                    onClose: () => {
                                        if ($form.find("input[name='method']").val() == 'add') {
                                            window.location.replace(base_url + 'components/schools/infoblasts');
                                        }
                                    }
                                });
                            }, 500 + 300 * (Math.random() * 5));
                        } else {
                            $self.html('<i class="la la-send"></i> Send Message').removeClass('m-loader m-loader--right m-loader--light').attr('disabled', false);
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

    //init infoblast
    $.infoblast = new infoblast, $.infoblast.Constructor = infoblast

}(window.jQuery),

//initializing infoblast
function($) {
    "use strict";
    $.infoblast.required_fields();
    $.infoblast.init();
}(window.jQuery);
