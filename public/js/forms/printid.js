!function($) {
    "use strict";

    var module = function() {
        this.$body = $("body");
    };

    var $required = 0; var files = []; var filesName = [];

    module.prototype.validate = function($form, $required)
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

    module.prototype.required_fields = function() {
        
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

    module.prototype.price_separator = function (input) {
        var output = input
        if (parseFloat(input)) {
            input = new String(input); // so you can perform string operations
            var parts = input.split("."); // remove the decimal part
            parts[0] = parts[0].split("").reverse().join("").replace(/(\d{3})(?!$)/g, "$1,").split("").reverse().join("");
            output = parts.join(".");
        }

        return output;
    },

    module.prototype.do_uploads = function($id) {
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

    module.prototype.init = function()
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

        $('.select2').select2({
            placeholder: "select a header"
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
            $('#slug').val(self.replace(/\s+/g, '-').toLowerCase());
        });

        this.$body.on('change', '#user_id', function (e) {
            e.preventDefault();
            //alert($(this).val());
            $.ajax({
                type: 'GET',
                url: 'print-id/search/'+$(this).val(),
                data: { 'id':$(this).val() },
                success: function(response) {
                    var data = $.parseJSON(response);
                    var idno = data.identification_no;
                        idno = idno.replace('-', '');
                    var avatar = base_url+'storage/app/public/uploads/students/'+idno+'/'+data.avatar;
                        //avatar = "{{ asset('img/idphoto/default.png') }}";
                    //console.log( base_url+'storage/app/public/uploads/students/'+idno+'/'+data.avatar);

                    $('#idno').val(data.identification_no);
                    $('#barcode').val(data.identification_no);
                    $('#firstname').val(data.firstname);
                    $('#middlename').val(data.middlename);
                    $('#lastname').val(data.lastname);
                    $('#gender').val(data.gender);
                    $('#level').val(data.level);
                    $('#section').val(data.section);
                    $('#avatar').val(data.avatar);
                    var path = "{{ asset('img/idphoto/default.png') }}"; 
                    //var path2 = "{{ asset('app/public/uploads/students/"+idno+"/"+data.avatar+"') }}"; 
                    console.log(path);
                    //$("#avatar_image").attr('src',path);
                    $('#photoid').css('background-image', 'url('+path+')');
                    //$('#photoid').html('<img type="image" src="' + path + '" id="avatar_image" name="avatar_image" class="w-100 h-80" >');
                    //$("#avatar_image").attr("src", avatar);

                    if(data.father_selected){
                        var guardianname = data.father_firstname;
                            if(data.father_middlename){
                                guardianname += ' '+data.father_middlename;
                            }
                            guardianname += ' '+data.father_lastname;

                        $('#guardian').val(guardianname);
                        $('#contact_number').val(data.father_contact_no); 
                        $('#address').val(data.father_address);
                    }
                    else if(data.mother_selected){
                        var guardianname = data.mother_firstname;
                            if(data.mother_middlename){
                                guardianname += ' '+data.mother_middlename;
                            }
                            guardianname += ' '+data.mother_lastname;

                        $('#guardian').val(guardianname);
                        $('#contact_number').val(data.mother_contact_no); 
                        $('#address').val(data.mother_address);
                    }
                }, 
                complete: function() {
                    window.onkeydown = null;
                    window.onfocus = null;
                }
            });

        });        

        this.$body.on('click', '#print-btn', function (e){
            e.preventDefault();
            var printWindow = window.open('', 'PRINT', 'height=700,width=600');
            var Contractor= $('span[id*="lblCont"]').html();
            //printWindow = window.open("", "PRINT", "location=1,status=1,scrollbars=1,width=650,height=600");
            printWindow.document.write('<html><head>');
            printWindow.document.write('<style type="text/css">@media print{.no-print, .no-print *{display: none !important;}</style>');
            printWindow.document.write('</head><body>');
            printWindow.document.write('<div style="width:100%;text-align:right">');
           
            printWindow.document.write('<input type="button" id="btnPrint" value="Print" class="no-print" style="width:100px" onclick="window.print()" />');
            printWindow.document.write('<input type="button" id="btnCancel" value="Cancel" class="no-print"  style="width:100px" onclick="window.close()" />');
           
            printWindow.document.write('</div>');
           
            printWindow.document.write(document.getElementById('basic_info_prt').innerHTML);
            printWindow.document.write('</body></html>');
            printWindow.document.close();
            printWindow.focus();
        });

        this.$body.on('click', '.submit-btn', function (e){
            e.preventDefault();
            var $self = $(this);
            var $form = $('form[name="module_form"]');
            var $error = $.module.validate($form, 0);

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
                $.module.required_fields();
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
                                            window.location.replace(base_url + 'components/menus/modules');
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

    //init module
    $.module = new module, $.module.Constructor = module

}(window.jQuery),

//initializing module
function($) {
    "use strict";
    $.module.required_fields();
    $.module.init();
}(window.jQuery);
