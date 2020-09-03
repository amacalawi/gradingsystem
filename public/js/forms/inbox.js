!function($) {
    "use strict";

    var inbox = function() {
        this.$body = $("body");
    };

    var $required = 0; var $groups = []; var $sections = []; var $users = []; var $anonymousMsisdn = []; 

    inbox.prototype.validate = function($form, $required)
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

    inbox.prototype.required_fields = function() {
        
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

    inbox.prototype.price_separator = function (input) {
        var output = input
        if (parseFloat(input)) {
            input = new String(input); // so you can perform string operations
            var parts = input.split("."); // remove the decimal part
            parts[0] = parts[0].split("").reverse().join("").replace(/(\d{3})(?!$)/g, "$1,").split("").reverse().join("");
            output = parts.join(".");
        }

        return output;
    },

    inbox.prototype.searchKeywords = function () {
        var input, filter, ul, li, a, i, txtValue;
        input = document.getElementById('generalSearch');
        filter = input.value.toUpperCase();
        ul = document.getElementById("m_nav");
        li = ul.getElementsByTagName('li');

        // Loop through all list items, and hide those who don't match the search query
        for (i = 0; i < li.length; i++) {
            a = li[i].getElementsByTagName("span")[0];
            txtValue = a.textContent || a.innerText;
            if (txtValue.toUpperCase().indexOf(filter) > -1) {
            li[i].style.display = "";
            } else {
            li[i].style.display = "none";
            }
        }
    },

    inbox.prototype.get_inboxes_via_msisdn = function ($msisdn) {
        if ($msisdn != '') {
            $anonymousMsisdn.push($msisdn);
        }
        var $increment = 0; var $first = ''; var $left = ''; 
        var $portlet = $("#panel-result"); $('.infoblast-inbox .m-content .mCSB_container').css("height", "400px !important");
        $portlet.html('<div class="panel-disabled"><div class="preloader"><div class="m-loader m-loader--lg" style="width: 100px; display: inline-block;"></div></div></div>');
        console.log(base_url + 'notifications/messaging/infoblast/get-inboxes-via-msisdn?msisdn=' + $msisdn);
        $.ajax({
            type: 'GET',
            url: base_url + 'notifications/messaging/infoblast/get-inboxes-via-msisdn?msisdn=' + $msisdn,
            success: function(response) {
                var data = JSON.parse(JSON.stringify(response));
                if (data.status == 'ok') {
                    if (data.data.length > 0) {
                        var $message = '<div class="content-layer">';
                        $.each(data.data, function(i, item) {
                            if(item.type == 'inbox') { $left = 'left'; } else { $left = 'right'; }
                            $message += '<div class="content-items ' + $left + '">' +
                            '<div class="avatar"><i class="flaticon-profile-1"></i></div>' +
                            '<div class="content-arrow"></div>' +
                            '<div class="content-text">' +
                            '<b class="c-primary">' + item.msgDate + '' + item.msgTime + '</b>' +
                            '<p>' + item.msg + '</p>' +
                            '</div>' +
                            '</div>';
                        }); 
                        $message += '</div>';
                    }
                    $('.infoblast-inbox .m-content .mCSB_container').css("height", "auto !important");
                    var $pd = $portlet.find('.panel-disabled');
                    setTimeout(function () {
                        $pd.fadeOut('fast', function () {
                            $pd.remove();
                            if (data.data.length > 0) {
                                $portlet.html($message);
                            }
                        });
                    }, 500 + 300 * (Math.random() * 5));
                }
            }, 
            complete: function() {
                window.onkeydown = null;
                window.onfocus = null;
            },
            async: false
        });
    },

    inbox.prototype.refresh = function() {
        $groups = []; $sections = []; $users = []; $anonymousMsisdn = [];
        $('textarea[id="messages"]').val('');
    },

    inbox.prototype.validate_recipient = function() {   
        var $recipient = 0;

        if ( $('.m-content #m_nav .m-tabs__item--active').length ) {
            $recipient++; 
        }

        return $recipient;
    },

    inbox.prototype.init = function()
    {   
        // $.inbox.get_inboxes_via_msisdn('');

        this.$body.on('click', '.m-nav__link.m-tabs__item', function (e) {
            e.preventDefault();
            $anonymousMsisdn = [];
            var $self = $(this);
            var $msisdn = $self.attr('data-msisdn');
            $.inbox.get_inboxes_via_msisdn($msisdn);
        });
        this.$body.on('keyup', '#generalSearch', function (e) {
            $.inbox.searchKeywords();
        });

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
            var $form = $('form[name="infoblast_form"]');
            var $messages = $form.find('textarea');
            var $type = $form.find('input[type="radio"]');
            var $recipient = $.inbox.validate_recipient();

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
                    data: { 'messages': $messages.val(), 'message_type_id': 1, 'groups': $groups, 'sections': $sections, 'users': $users, 'anonymous': $anonymousMsisdn },
                    success: function(response) {
                        var data = $.parseJSON(response);   
                        console.log(data);
                        if (data.type == 'success') {
                            setTimeout(function () {
                                $.inbox.refresh();
                                $.inbox.get_inboxes_via_msisdn($('.m-content .m-nav__link.m-tabs__item.m-tabs__item--active').attr('data-msisdn'));
                                $self.html('<i class="la la-send"></i> SEND').removeClass('m-loader m-loader--right m-loader--light').attr('disabled', false);
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
                            $self.html('<i class="la la-send"></i> SEND').removeClass('m-loader m-loader--right m-loader--light').attr('disabled', false);
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

    //init inbox
    $.inbox = new inbox, $.inbox.Constructor = inbox

}(window.jQuery),

//initializing inbox
function($) {
    "use strict";
    $.inbox.required_fields();
    $.inbox.init();
}(window.jQuery);
