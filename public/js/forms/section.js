!function($) {
    "use strict";

    var section = function() {
        this.$body = $("body");
    };

    var $required = 0; var files = []; var filesName = [];

    section.prototype.validate = function($form, $required)
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

    section.prototype.required_fields = function() {
        
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

    section.prototype.price_separator = function (input) {
        var output = input
        if (parseFloat(input)) {
            input = new String(input); // so you can perform string operations
            var parts = input.split("."); // remove the decimal part
            parts[0] = parts[0].split("").reverse().join("").replace(/(\d{3})(?!$)/g, "$1,").split("").reverse().join("");
            output = parts.join(".");
        }

        return output;
    },

    section.prototype.do_uploads = function($id) {
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

    section.prototype.init = function()
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
        
        this.$body.on('click', '#subject-teacher-addrow', function (e){
            e.preventDefault();
            
            $.ajax({
                type: "GET",
                url: base_url + 'academics/academics/subjects/get-all-subjects',
                success: function (data) {
                    var data = $.parseJSON( data );

                    var subject = $("<select></select>").attr("id", "subjects").attr("name", "subjects").attr("class", "form-control form-control-lg m-input m-input--solid");
                    $.each(data,function(index, data){
                        subject.append($("<option></option>").attr("value", index).text(data));
                    });
                    $("#option-subject").append('<label> Subject: </label>');
                    $("#option-subject").append(subject);

                },
                async: false
            });

            $.ajax({
                type: "GET",
                url: base_url + 'academics/academics/subjects/get-all-teachers',
                success: function (data) {
                    var data = $.parseJSON( data );
                    
                    var teacher = $("<select></select>").attr("id", "teachers").attr("name", "teachers").attr("class", "form-control form-control-lg m-input m-input--solid");
                    $.each(data,function(index, data){
                        teacher.append($("<option></option>").attr("value", index).text(data));
                    });
                    $("#option-teacher").append('<label> Teacher: </label>');
                    $("#option-teacher").append(teacher);
                
                },
                async: false
            });            
            
        });

        this.$body.on('click', '.submit-btn', function (e){
            e.preventDefault();
            var $self = $(this);
            var $form = $('form[name="section_form"]');
            var $error = $.section.validate($form, 0);

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
                $.section.required_fields();
            } else {
                $self.prop('disabled', true).html('wait.....').addClass('m-btn--custom m-loader m-loader--light m-loader--right');
                $.ajax({
                    type: $form.attr('method'),
                    url: $form.attr('action'),
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
                                            window.location.replace(base_url + 'academics/academics/sections');
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

    //init section
    $.section = new section, $.section.Constructor = section

}(window.jQuery),

//initializing section
function($) {
    "use strict";
    $.section.required_fields();
    $.section.init();
}(window.jQuery);


//Added JS
function loadSubjects()
{
    $.ajax({
        type: "GET",
        url: base_url + 'academics/academics/subjects/get-all-subjects',
        success: function (data) {
            var data = $.parseJSON( data );

            var subject = $("<select></select>").attr("id", "subjects").attr("name", "subjects").attr("class", "form-control form-control-lg m-input m-input--solid");
            $.each(data,function(index, data){
                subject.append($("<option></option>").attr("value", index).text(data));
            });
            $("#option-subject").append('<label> Subject: </label>');
            $("#option-subject").append(subject);

        },
        async: false
    });
}

function loadTeacher()
{
    $.ajax({
        type: "GET",
        url: base_url + 'academics/academics/subjects/get-all-teachers',
        success: function (data) {
            var data = $.parseJSON( data );
            
            var teacher = $("<select></select>").attr("id", "teachers").attr("name", "teachers").attr("class", "form-control form-control-lg m-input m-input--solid");
            $.each(data,function(index, data){
                teacher.append($("<option></option>").attr("value", index).text(data));
            });
            $("#option-teacher").append('<label> Teacher: </label>');
            $("#option-teacher").append(teacher);
        
        },
        async: false
    });  
}

$(document).ready(function(){

    loadSubjects();
    loadTeacher();
  
});