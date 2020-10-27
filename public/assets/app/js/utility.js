!function($) {
    "use strict";

    var utility = function() {
        this.$body = $("body");
    };

    var $required = 0; var files = []; var filesName = [];

    utility.prototype.validate = function($form, $required)
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

    utility.prototype.required_fields = function() {
        
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

    utility.prototype.price_separator = function (input) {
        var output = input
        if (parseFloat(input)) {
            input = new String(input); // so you can perform string operations
            var parts = input.split("."); // remove the decimal part
            parts[0] = parts[0].split("").reverse().join("").replace(/(\d{3})(?!$)/g, "$1,").split("").reverse().join("");
            output = parts.join(".");
        }

        return output;
    },

    utility.prototype.schoolyear_utilities = function() {
        console.log(base_url + "dashboard/get-all-open-batches");
        $.ajax({
            type: "GET",
            url: base_url + "dashboard/get-all-open-batches",
            success: function(response) {
                var data = $.parseJSON(response);   
                if (data.opened.length > 0) {
                    $('.opened-list').removeClass('hidden');
                    $('.opened-nav').empty();
                    $.each(data.opened, function(i, item) {
                        var $message = '<li class="m-menu__item ">' +
                                        '<a value="' + item.id + '" href="inner.html" class="m-menu__link">' +
                                        '<span class="m-menu__link-text">' +
                                        '' + item.code + '' +
                                        '</span>' +
                                        '</a>' +
                                        '</li>';

                        $('.opened-nav').append($message);
                    });
                }

                if (data.current.length > 0) {
                    $('.current-list').removeClass('hidden');
                    $.each(data.current, function(i, item) {
                        $('.current-nav').text(item.code);
                    });
                }

                console.log(data);
            },
            complete: function() {
                window.onkeydown = null;
                window.onfocus = null;
            }
        });
    },

    utility.prototype.init = function()
    {   
        /*
        | ---------------------------------
        | # select, input, and textarea on change or keyup remove error
        | ---------------------------------
        */
        $( document ).ready(function() {
            var slugMenus = ['add', 'edit'];
            $('body .m-menu__subnav .m-menu__item.m-menu__item--submenu[slug="' + activeModule + '"]').addClass('m-menu__item--open');
            console.log(slugMenus.indexOf(activeSubSubModule));
            if (slugMenus.indexOf(activeSubSubModule) === -1 && activeSubSubModule == '') {
                $('body .m-menu__subnav .m-menu__item.m-menu__item--submenu .m-menu__item[slug="' + activeSubModule + '"]').addClass('active-menu-items');
            } else {
                $('body .m-menu__subnav .m-menu__subnav .m-menu__item.m-menu__item--submenu[slug="' + activeSubModule + '"]').addClass('m-menu__item--open');
                $('body .m-menu__subnav .m-menu__subnav .m-menu__item.m-menu__item--submenu .m-menu__item[slug="' + activeSubSubModule + '"]').addClass('active-menu-items');
            }
        });

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
        
        $.utility.schoolyear_utilities();

        this.$body.on('click', 'ul.opened-nav a', function (e){
            e.preventDefault();
            var self = $(this);
            $.ajax({
                type: "GET",
                url: base_url + "dashboard/update-current/" + self.attr('value'),
                success: function(response) {
                    var data = $.parseJSON(response);   
                    if (data.type == 'success') {
                        $('.opened-list').removeClass('m-menu__item--hover');
                        $.utility.schoolyear_utilities();
                        swal({
                            title: data.title,
                            text: data.text,
                            type: data.type,
                            confirmButtonClass: "btn " + data.class + " btn-focus m-btn m-btn--pill m-btn--air m-btn--custom"
                        });
                        if ( $('.m_datatable').length ) {
                            $('.m_datatable').mDatatable().reload();
                        }
                    }
                }
            });
        });
    }

    //init utility
    $.utility = new utility, $.utility.Constructor = utility

}(window.jQuery),

//initializing utility
function($) {
    "use strict";
    $.utility.required_fields();
    $.utility.init();
}(window.jQuery);
