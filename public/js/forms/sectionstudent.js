!function($) {
    "use strict";

    var sectionstudent = function() {
        this.$body = $("body");
    };

    var $required = 0; var files = []; var filesName = [];

    sectionstudent.prototype.validate = function($form, $required)
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
                    } else if($(this).val()=="" || $(this).val()=="0" || $(this).val()=='NULL' ){
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

    sectionstudent.prototype.required_fields = function() {
        
        $.each(this.$body.find(".form-group"), function(){
            if ($(this).hasClass('required')) {       
                var $input = $(this).find("input[type='date'], input[type='text'], select, textarea");
                if ($input.val() == '') {
                    $(this).find('.m-form__help').text('this field is required.');       
                }
                if ( ($input.val() == 'NULL') || ($input.val() == '0') ) {
                    $(this).find('.m-form__help').text('this field is required.');       
                }
                
                $input.addClass('required');
            } else {
                $(this).find("input[type='text'], select, textarea").removeClass('required');
            } 
        });

    },

    sectionstudent.prototype.price_separator = function (input) {
        var output = input
        if (parseFloat(input)) {
            input = new String(input); // so you can perform string operations
            var parts = input.split("."); // remove the decimal part
            parts[0] = parts[0].split("").reverse().join("").replace(/(\d{3})(?!$)/g, "$1,").split("").reverse().join("");
            output = parts.join(".");
        }

        return output;
    },

    sectionstudent.prototype.do_uploads = function($id) {
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

    sectionstudent.prototype.init = function()
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
        
        this.$body.on('change', '#level', function (e) {
            e.preventDefault();

            var type = $('#type').val();
            
            $.ajax({
                type: "GET",
                url: base_url + 'academics/academics/sections/get-all-section-bylevel/'+$(this).val()+'/'+type,
                success: function (data) {
                    var data = $.parseJSON( data );
                    var section = $("<select></select>").attr("id", "section").attr("name", "section").attr("class", "form-control form-control-lg m-input m-input--solid");
                    $.each(data,function(index, data){
                        section.append($("<option></option>").attr("value", index).text(data));
                    });
                    $('#section-div').empty();
                    $("#section-div").append('<label> Section: </label>');
                    $('#section-div').append(section);

                    $('#section').prop('disabled', false);
                },
                async: false
            });
            
        });

        this.$body.on('change', '#type', function (e) {
            e.preventDefault();
         
            if( $(this).val() )
            {
                //section
                $('#section').remove();
                getSectionList_type($(this).val());

                //level
                $('#level').remove();
                getLevelList_type($(this).val());

                //subject //teacher
                $('#subject').remove();
                getSubjectList_type($(this).val());

                $('#adviser').remove()
                getAdviserList_type();

                $('#teacher').remove()
                getTeacherList_type();
                $('#subject-teacher-main-div').css("display","block");

                clearsubjectteacher(100);
                
                $("#remove-div_1").append('<label style="visibility:hidden;"> Delete: </label><br/>');
                $("#remove-div_1").append('<button style="visibility:hidden;" name="remove-button" type="button" id="remove_1" class="btn btn-lg remove">s</button>');
            }

        });

        this.$body.on('change', '#subjects', function(e){
            e.preventDefault();
            console.log( $("#subjects").val() );
            var values = $("[name='subjects[]']").map(function(){return $(this).val();}).get();
            var exist = checkIfDuplicateExists(values);
            if(exist){
                swal({
                    title: "Oops...",
                    text: "Subject already selected.",
                    type: "warning",
                    showCancelButton: false,
                    closeOnConfirm: true,
                    confirmButtonClass: "btn btn-warning btn-focus m-btn m-btn--pill m-btn--air m-btn--custom"
                });

                $(".subject-div_"+values.length).val('NULL');
            }
            console.log( values );
        });

        this.$body.on('click', '#subject-teacher-addrow', function (e){
            e.preventDefault();
            
            var limit = 100;
            var total_element = $(".subject-div").length;
            var lastid = $(".subject-div:last").attr("id");
            var split_id = lastid.split("_");
            var nextindex = Number(split_id[1]) + 1;
            var type = $("#type").val();

            if( total_element < limit ){
                console.log( $(".subject-div_"+total_element).val() );
                if( $(".subject-div_"+total_element).val() != 'NULL' && $(".subject-div_"+total_element).val() != 0 ){
                    $(".subject-div:last").after("<div class='form-group m-form__group required subject-div' id='subject-div_"+ nextindex +"'></div>");
                    
                    $.ajax({
                        type: "GET",
                        url: base_url + 'academics/academics/subjects/get-all-subjects-bytype/'+type,
                        success: function (data) {
                            var data = $.parseJSON( data );
                            var subject = $("<select></select>").attr("id", "subjects").attr("name", "subjects[]").attr("class", "form-control form-control-lg m-input m-input--solid subject-div_"+ nextindex +" ");
                            
                            $.each(data,function(index, data){
                                if(index == '0'){
                                    subject.append($("<option></option>").attr( { value:"NULL", selected:"true" } ).text(data));
                                }
                                else
                                {
                                    subject.append($("<option></option>").attr("value", index).text(data));
                                }
                            });
                            $("#subject-div_"+nextindex ).append('<label> Subject: </label>');
                            $("#subject-div_"+nextindex ).append(subject);
                            $("#option-subject").css("display","block");
                            
                        },
                        async: false
                    });

                    var limit = 100;
                    var total_element = $(".teacher-div").length;
                    var lastid = $(".teacher-div:last").attr("id");
                    var split_id = lastid.split("_");
                    var nextindex = Number(split_id[1]) + 1;

                    $(".teacher-div:last").after("<div class='form-group m-form__group required teacher-div' id='teacher-div_"+ nextindex +"'></div>");
                    $(".remove-div:last").after("<div class='form-group m-form__group required remove-div' id='remove-div_"+ nextindex +"'></div>");
                    $.ajax({
                        type: "GET",
                        url: base_url + 'memberships/staffs/get-all-teachers',
                        success: function (data) {
                            var data = $.parseJSON( data );
                            var teacher = $("<select></select>").attr("id", "teachers").attr("name", "teachers[]").attr("class", "form-control form-control-lg m-input m-input--solid");
                            
                            $.each(data,function(index, data){
                                if(index == '0'){
                                    teacher.append($("<option></option>").attr( { value:"NULL", selected:"true" } ).text(data));
                                } 
                                else 
                                {
                                    teacher.append($("<option></option>").attr("value", index).text(data));
                                }
                            });
                            $("#teacher-div_"+nextindex ).append('<label> Teacher: </label>');
                            $("#teacher-div_"+nextindex ).append(teacher);
                            $("#option-teacher").css("display","block");

                            $("#remove-div_"+nextindex ).append('<label style="visibility:hidden;"> Delete: </label><br/>');
                            $("#remove-div_"+nextindex ).append("<button type='button' name='remove-button' id='remove_"+nextindex+"' class='btn btn-lg btn-danger remove' > - </button>");

                        },
                        async: false
                    });
                } else {
                    swal({
                        title: "Oops...",
                        text: "Select a subject first before adding another field.",
                        type: "warning",
                        showCancelButton: false,
                        closeOnConfirm: true,
                        confirmButtonClass: "btn btn-warning btn-focus m-btn m-btn--pill m-btn--air m-btn--custom"
                    });
                }          
            }
        });

        this.$body.on('click', '.remove', function (e){
            var id = this.id;
            var split_id = id.split("_");
            var deleteindex = split_id[1];
        
            // Remove <div> with id
            $("#subject-div_" + deleteindex).remove();
            $("#teacher-div_" + deleteindex).remove();
            $("#remove-div_" + deleteindex).remove();
            //$("#sections_subjects_" + deleteindex).remove();
        });

        this.$body.on('click', '.submit-btn', function (e){
            e.preventDefault();
            var $self = $(this);
            var $form = $('form[name="sectionstudent_form"]');
            var $error = $.sectionstudent.validate($form, 0);

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
                $.sectionstudent.required_fields();
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
                                            window.location.replace(base_url + 'academics/admissions/classes');
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

    //init sectionstudent
    $.sectionstudent = new sectionstudent, $.sectionstudent.Constructor = sectionstudent

}(window.jQuery),

//initializing sectionstudent
function($) {
    "use strict";
    $.sectionstudent.required_fields();
    $.sectionstudent.init();
}(window.jQuery);

function checkIfDuplicateExists(w){
    return new Set(w).size !== w.length 
}

function clearsubjectteacher(limit)
{
    //var limit = $('[name=remove-button]').length;
    console.log('remove button = '+limit);
    for(var x = 1; x<=limit; x++)
    {
        // Remove <div> with id
        if (x >= 2)
        {
            $("#subject-div_" + x).remove();
            $("#teacher-div_" + x).remove();
            $("#remove-div_" + x).remove();
        }
        if(x == 1)
        {   
            $("#remove-div_" + x).html("");
        }
    }


}

//Teacher
function getTeacherList_type( type )
{
    //console.log(type);
    $.ajax({
        type: "GET",
        url: base_url + 'memberships/staffs/get-all-teachers-bytype/',
        success: function (data) {
            var data = $.parseJSON( data );

            console.log(data);

            var teacher = $("<select></select>").attr("id", "teacher").attr("name", "teachers[]").attr("class", "form-control form-control-lg m-input m-input--solid");
            $.each(data,function(index, data){
                teacher.append($("<option></option>").attr("value", index).text(data) );
            });
            $('#teacher-div_1').empty();
            $("#teacher-div_1").append('<label> Teachers: </label>');
            $('#teacher-div_1').append(teacher);

        },
        async: false
    });
}

//Subject
function getSubjectList_type( type )
{
    $.ajax({
        type: "GET",
        url: base_url + 'academics/academics/subjects/get-all-subjects-bytype/'+type,
        success: function (data) {
            var data = $.parseJSON( data );
            var subject = $("<select></select>").attr("id", "subjects").attr("name", "subjects[]").attr("class", "form-control form-control-lg m-input m-input--solid subject-div_1");
            $.each(data,function(index, data){
                subject.append($("<option></option>").attr("value", index).text(data));
            });
            $('#subject-div_1').empty();
            $("#subject-div_1").append('<label> Subjects: </label>');
            $('#subject-div_1').append(subject);
            
        },
        async: false
    });
}

//Adviser
function getAdviserList_type( )
{
    $.ajax({
        type: "GET",
        url: base_url + 'memberships/staffs/get-all-advisers-bytype',
        success: function (data) {
            var data = $.parseJSON( data );
            var adviser = $("<select></select>").attr("id", "adviser").attr("name", "adviser").attr("class", "form-control form-control-lg m-input m-input--solid");
            $.each(data,function(index, data){
                adviser.append($("<option></option>").attr("value", index).text(data) );
            });
            $('#adviser-div').empty();
            $("#adviser-div").append('<label> Adviser: </label>');
            $('#adviser-div').append(adviser);

        },
        async: false
    });
}

//Level
function getLevelList_type( type )
{
    $('#level-main-div').css("display","block");

    $.ajax({
        type: "GET",
        url: base_url + 'academics/academics/levels/get-all-levels-bytype/'+type,
        success: function (data) {
            var data = $.parseJSON( data );
            var level = $("<select></select>").attr("id", "level").attr("name", "level").attr("class", "form-control form-control-lg m-input m-input--solid");
            $.each(data,function(index, data){
                level.append($("<option></option>").attr("value", index).text(data));
            });
            $('#level-div').empty();
            $("#level-div").append('<label> Level: </label>');
            $('#level-div').append(level);
        },
        async: false
    });
}

//Section
function getSectionList_type( type )
{
    //console.log(type);
    $('#section-main-div').css("display","block");

    $.ajax({
        type: "GET",
        url: base_url + 'academics/academics/sections/get-all-sections-bytype/'+type,
        success: function (data) {
            var data = $.parseJSON( data );
            var section = $("<select disabled></select>").attr("id", "section").attr("name", "section").attr("class", "form-control form-control-lg m-input m-input--solid");
            $.each(data,function(index, data){
                section.append($("<option></option>").attr("value", index).text(data));
            });
            $('#section-div').empty();
            $("#section-div").append('<label> Section: </label>');
            $('#section-div').append(section);
        },
        async: false
    });
}

$(document).ready(function(){

    if( $('#type').val() ){
        $('#subject-teacher-main-div').css("display","block");
    }
    
    if ( ( $('.no-subject').css('display') == 'block' ) || ( $('.no-teacher').css('display') == 'block' ) ){
        getSubjectList_type($('#type').val())
        getTeacherList_type($('#type').val())
        $('#subject-teacher-main-div').css("display","block");
        $("#remove-div_1").append('<label style="visibility:hidden;"> Delete: </label><br/>');
        $("#remove-div_1").append('<button style="visibility:hidden;" name="remove-button" type="button" id="remove_1" class="btn btn-lg remove">s</button>');
    }
});