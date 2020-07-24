!function($) {
    "use strict";

    var component = function() {
        this.$body = $("body");
    };

    var $required = 0;

    var $activity_layer = '<div class="row activity-panel-layout">' +
        '<div class="col-md-11">' +
        '<div class="row">' +
        '<div class="col-md-4">' +
        '<div class="form-group m-form__group required">' +
        '<label for="activity" class="">Code</label>' +
        '<input class="form-control form-control-lg m-input m-input--solid required" name="activity_name[]" type="text" value="">' +
        '<span class="m-form__help m--font-danger"></span>' +
        '</div>' +
        '</div>' +
        '<div class="col-md-4">' +
        '<div class="form-group m-form__group required">' +
        '<label for="value" class="">Value</label>' +
        '<input class="numeric-double form-control form-control-lg m-input m-input--solid required" name="activity_value[]" type="text" value="">' +
        '<span class="m-form__help m--font-danger"></span>' +
        '</div>' +
        '</div>' +
        '<div class="col-md-4">' +
        '<div class="form-group m-form__group required">' +
        '<label for="description" class="">Description</label>' +
        '<input class="form-control form-control-lg m-input m-input--solid required" name="activity_description[]" type="text" value="">' +
        '<span class="m-form__help m--font-danger"></span>' +
        '</div>' +
        '</div>' +
        '</div>' +
        '</div>' +
        '<div class="col-md-1">' +
        '<div class="row">' +
        '<div class="col-md-12">' +
        '<button type="button" class="minus-activity btn">' +
        '<i class="la la-minus"></i>' +
        '</button>' +
        '</div>' +
        '</div>' +
        '</div>' +
        '</div>';

    component.prototype.validate = function($form, $required)
    {   
        $required = 0;

        $.each(this.$body.find("input[type='date'], input[type='text'], select, textarea, radio"), function(){
               
            if (!($(this).attr("name") === undefined || $(this).attr("name") === null)) {
                if ($(this).hasClass("required")){
                    if ($(this).is(':radio')) {
                        if ($('input[name="palette"]:checked').length <= 0) {
                            $(this).closest(".form-group").find(".m-form__help").text("this field is required.");
                            $required++; 
                        }
                    } else if ($(this).is("[multiple]")){
                        if ( !$(this).val() || $(this).find('option:selected').length <= 0 ){
                            $(this).closest(".form-group").find(".m-form__help").text("this field is required.");
                            $required++;
                        }
                    } else if ($(this).val()=="" || $(this).val()=="0"){
                        if (!$(this).is("select")) {
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

    component.prototype.required_fields = function() {
        
        $.each(this.$body.find(".form-group"), function(){
            var $form = $(this);
            if ($form.hasClass('required')) {       
                var $input = $form.find("input[type='date'], input[type='text'], select, textarea, radio");
                if ($input.is("select")) {
                    if ($input.val() == '') {
                        $form.find('.m-form__help').text('this field is required.'); 
                        $input.addClass('required');    
                    }
                } else if ($input.val() == '') {  
                    $form.find('.m-form__help').text('this field is required.'); 
                    $input.addClass('required');  
                } else if ($('input[name="palette"]:checked').length <= 0) {
                    $form.find('.m-form__help').text('this field is required.');    
                    $input.addClass('required');
                }
                $input.addClass('required');    
            } else {
                $form.find("input[type='text'], select, textarea, radio").removeClass('required');
            } 
        });
    },

    component.prototype.price_separator = function (input) {
        var output = input
        if (parseFloat(input)) {
            input = new String(input); // so you can perform string operations
            var parts = input.split("."); // remove the decimal part
            parts[0] = parts[0].split("").reverse().join("").replace(/(\d{3})(?!$)/g, "$1,").split("").reverse().join("");
            output = parts.join(".");
        }

        return output;
    },

    component.prototype.do_uploads = function($id) {
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

    component.prototype.reload_quarter = function($type) 
    {   
        var $quarter = $('#quarter_id'), $section = $('#section_id');
        $quarter.find('option').remove(); $section.find('option').remove();
        $section.append('<option value="">select a section</option>');  

        console.log(base_url + 'academics/grading-sheets/components/reload-quarter-via-type/' + $type);
        $.ajax({
            type: "GET",
            url: base_url + 'academics/grading-sheets/components/reload-quarter-via-type/' + $type,
            success: function(response) {
                var data = JSON.parse(response);
                console.log(data.quarters);
                $.each(data.quarters, function(i, item) {
                    $quarter.append('<option value="' + item.id + '">' + item.name + '</option>');  
                }); 
                $.each(data.sections, function(i, item) {
                    $section.append('<option value="' + item.id + '">' + item.name + '</option>');  
                }); 
            },
            async: false
        });
        
        $('.m_selectpicker').selectpicker('refresh');
        $.component.required_fields();
    },

    component.prototype.reload_subject = function($section) 
    {   
        var $subject = $('#subject_id');
        $subject.find('option').remove(); 
        $subject.append('<option value="">select a subject</option>');  

        console.log(base_url + 'academics/grading-sheets/components/reload-subject-via-section/' + $section);
        $.ajax({
            type: "GET",
            url: base_url + 'academics/grading-sheets/components/reload-subject-via-section/' + $section,
            success: function(response) {
                var data = JSON.parse(response);
                $.each(data.subjects, function(i, item) {
                    $subject.append('<option value="' + item.id + '">' + item.name + '</option>');  
                }); 
            },
            async: false
        });

        $.component.required_fields();
    },

    component.prototype.init = function()
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

        this.$body.on('keypress', '.numeric', function (e) {
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

        this.$body.on('blur', '.numeric, .numeric-double', function (e){
            e.preventDefault();
            var self = $(this);
            if($.isNumeric(self.val()) == false) {
                self.val('');
                if (self.hasClass('required')) {
                    $.component.required_fields();
                }
            }
        });

        /*
        | ---------------------------------
        | # add activity on click
        | ---------------------------------
        */
        this.$body.on('click', '#add-activity', function (e) {
            e.preventDefault();
            var $self = $(this);
            var $panel = $('#activity-panel');
            $panel.append($activity_layer);
            $.component.required_fields();
        });

        this.$body.on('click', '.minus-activity', function (e) {
            e.preventDefault();
            var $self = $(this);
            var $panel = $self.closest('.activity-panel-layout');
            $panel.remove();
        });

        this.$body.on('change', 'select[name="education_type_id"]', function (e) {
            e.preventDefault();
            var $self = $(this);
            if ($self.val() > 0) {
                $.component.reload_quarter($self.val());
            }
        });

        this.$body.on('change', 'select[name="section_id"]', function (e) {
            e.preventDefault();
            var $self = $(this);
            if ($self.val() > 0) {
                $.component.reload_subject($self.val());
            }
        });

        this.$body.on('click', '.submit-btn', function (e){
            e.preventDefault();
            var $self = $(this);
            var $form = $('form[name="component_form"]');
            var $error = $.component.validate($form, 0);

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
                $.component.required_fields();
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
                                            window.location.replace(base_url + 'academics/grading-sheets/components');
                                        }
                                    }
                                });
                            }, 500 + 300 * (Math.random() * 5));
                        } else {
                            $self.html('<i class="la la-save"></i> Save Changes').removeClass('m-loader m-loader--right m-loader--light').attr('disabled', false);
                            $form.find('input[name="code"]').next().text('This is an existing code.');
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

    //init component
    $.component = new component, $.component.Constructor = component

}(window.jQuery),

//initializing component
function($) {
    "use strict";
    $.component.required_fields();
    $.component.init();
}(window.jQuery);
