!function($) {
    "use strict";

    var reportcard = function() {
        this.$body = $("body");
    };

    var $required = 0; var files = []; var transmutations = [];

    reportcard.prototype.validate = function($form, $required)
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

    reportcard.prototype.required_fields = function() {
        
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

    reportcard.prototype.price_separator = function (input) {
        var output = input
        if (parseFloat(input)) {
            input = new String(input); // so you can perform string operations
            var parts = input.split("."); // remove the decimal part
            parts[0] = parts[0].split("").reverse().join("").replace(/(\d{3})(?!$)/g, "$1,").split("").reverse().join("");
            output = parts.join(".");
        }

        return output;
    },

    reportcard.prototype.do_uploads = function($id) {
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

    reportcard.prototype.compute = function($rows, $group = '') 
    {   
        if ($group != '') {
            var $sumCell = $rows.find('.sum-cell[group="'+ $group + '"]');
            var $hpsCell = $rows.find('.hps-cell[group="'+ $group + '"]');
            var $psCell  = $rows.find('.ps-cell[group="'+ $group + '"]');
            var $tcCell  = $rows.find('.tc-cell input[name="tc_score[]"]');
            var $qcCell  = $rows.find('.quarter-cell');
            var $percentageCell = $rows.find('.percentage-cell[group="'+ $group + '"]');
            var $initialCell = $rows.find('.initial-cell');
            var $sumHeader = $('#reportcard-table th.sum-header[group="'+ $group + '"]');
            var $psHeader = $('#reportcard-table th.ps-header[group="'+ $group + '"]');
    
            var $sum = 0, $hps = 0;
            $.each($rows.find('td[group="'+ $group + '"] .activity-cell'), function(){
                var $score = $(this).val();
                var $maxscore = $(this).attr('maxvalue');

                if ($score > 0) {
                    $sum += parseFloat($score);
                    $hps += parseFloat($maxscore);
                }
            });
            
            $hpsCell.text($hps);

            if (parseFloat($hpsCell.text()) > 0) {
                var $percentage = (parseFloat($sum) / parseFloat($hpsCell.text())) * 100; 
                var $totalPercentage = (parseFloat($sum) / parseFloat($hpsCell.text())) * $percentageCell.attr('maxvalue');
            } else if (parseFloat($sumHeader.text()) > 0) {
                var $percentage = (parseFloat($sum) / parseFloat($sumHeader.text())) * 100; 
                var $totalPercentage = $percentage * parseFloat('.' + $percentageCell.attr('maxvalue'));
            } else {
                var $percentage = (parseFloat($sum) / parseFloat($psHeader.attr('maxvalue'))) * 100; 
                var $totalPercentage = $percentage * parseFloat('.' + $percentageCell.attr('maxvalue'));
            }

            $sumCell.text($sum);
            $psCell.text($percentage.toString().match(/^-?\d+(?:\.\d{0,2})?/)[0]);
            $percentageCell.text($totalPercentage.toString().match(/^-?\d+(?:\.\d{0,2})?/)[0]);

            var $initPercent = 0;
            $.each($rows.find('.percentage-cell'), function(){
                var $score = $(this).text();

                if ($score > 0) {
                    $initPercent += parseFloat($score);
                }
            });

            if ( parseFloat($tcCell.val()) > 0 ) {
                $initPercent = parseFloat($initPercent) + parseFloat($tcCell.val());
            }

            var $scoring = $initPercent.toString().match(/^-?\d+(?:\.\d{0,2})?/)[0];
            $initialCell.text($scoring);

            var filters = transmutations.filter(x => x.score <= $scoring);
            var qg = Math.max.apply(Math, filters.map(function(o) { return o.equivalent; }));
            $qcCell.text(qg);
        } 
        else
        {   
            var $tcCell = $rows.find('.tc-cell input[name="tc_score[]"]');
            var $initialCell = $rows.find('.initial-cell');
            var $qcCell  = $rows.find('.quarter-cell');

            var $initPercent = 0;
            $.each($rows.find('.percentage-cell'), function(){
                var $score = $(this).text();

                if ($score > 0) {
                    $initPercent += parseFloat($score);
                }
            });

            if ( parseFloat($tcCell.val()) > 0 ) {
                $initPercent = parseFloat($initPercent) + parseFloat($tcCell.val());
            }

            var $scoring = $initPercent.toString().match(/^-?\d+(?:\.\d{0,2})?/)[0];
            $initialCell.text($scoring)

            var filters = transmutations.filter(x => x.score <= $scoring);
            var qg = Math.max.apply(Math, filters.map(function(o) { return o.equivalent; }));
            $qcCell.text(qg);
        }

        var initGrade = $rows.find('.tc-cell input[name="init_grade[]"]');
        var quarterGrade = $rows.find('.tc-cell input[name="quarter_grade[]"]');
        initGrade.val($scoring);
        quarterGrade.val(qg);
    },

    reportcard.prototype.reload_students = function($section, $batch)
    {   
        var $student = $('#student_id');
        $student.find('option').remove();
        

        console.log(base_url + 'academics/grading-sheets/report-card/reload-students?sections=' + $section + '&batch=' + $batch);
        $.ajax({
            type: "GET",
            url: base_url + 'academics/grading-sheets/report-card/reload-students?sections=' + $section + '&batch=' + $batch,
            success: function(response) {
                var data = JSON.parse(response);
                if (data.students.length > 0) {
                    $.each(data.students, function(i, item) {
                        $student.append('<option value="' + item.id + '">' + item.name + '</option>');  
                    }); 
                } else {
                    $student.append('<option value="">select a student</option>');  
                }
                $student.selectpicker('refresh');
            } 
        });

        $.reportcard.required_fields();
    },

    reportcard.prototype.reload_classes = function($type, $batch) 
    {   
        var $section = $('#section_info_id');
        $section.find('option').remove();
        $section.append('<option value="">select a class</option>'); 

        console.log(base_url + 'academics/grading-sheets/report-card/reload-classes?type=' + $type + '&batch=' + $batch);
        $.ajax({
            type: "GET",
            url: base_url + 'academics/grading-sheets/report-card/reload-classes?type=' + $type + '&batch=' + $batch,
            success: function(response) {
                var data = JSON.parse(response);
                $.each(data.sections, function(i, item) {
                    $section.append('<option value="' + item.id + '">' + item.name + '</option>');  
                }); 
                $section.selectpicker('refresh');
            } 
        });

        $.reportcard.required_fields();
    },

    reportcard.prototype.fetch_transmutations = function()
    {   
        if (activeSubSubModule == 'edit') {
            $.ajax({
                type: 'GET',
                url: base_url + 'academics/grading-sheets/all-reportcards/fetch-transmutations/' + $('#type').text(),
                success: function(response) {
                    transmutations = JSON.parse(response);
                },
                async: false
            });

            console.log(transmutations);
        }
    },

    reportcard.prototype.init = function()
    {   
        $.reportcard.fetch_transmutations();

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

        this.$body.on('change', '#education_type_id', function (e){
            e.preventDefault();
            var self = $(this).val();
            var batch = $('#batch_id').val();

            if (self != '') {
                $.reportcard.reload_classes(self, batch);
            }
        });
        this.$body.on('change', '#batch_id', function (e){
            e.preventDefault();
            var self = $(this).val();
            var type = $('#education_type_id').val();

            if (self != '') {
                $.reportcard.reload_classes(type, self);
            }
        });

        this.$body.on('change', '#section_info_id', function (e){
            e.preventDefault();
            var self = $(this).val();
            var batch = $('#batch_id').val();

            if (self != '') {
                $.reportcard.reload_students(self, batch);
            }
        });

        this.$body.on('click', '.export-btn', function (e){
            e.preventDefault();
            var $self = $(this);
            var $form = $('form[name="reportcard_form"]');
            var $error = $.reportcard.validate($form, 0);
            var $student_id = $form.find('select[name="student_id"]').val();
            var $section_info_id = $form.find('select[name="section_info_id"]').val();
            var $batch_id = $form.find('select[name="batch_id"]').val();
            var $type_id = $form.find('select[name="education_type_id"]').val();
            var $url = $form.attr('action') + '?student_id='+ $student_id +'&section_info_id=' + $section_info_id + '&batch_id=' + $batch_id + '&type_id=' + $type_id;

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
                $.reportcard.required_fields();
            } else {
                var win = window.open($url, '_blank');
                win.focus();
            }
        });

        this.$body.on('click', '#preview-btn', function (e){
            e.preventDefault();
            var w = window.innerWidth;
            var h = window.innerHeight;
            var divContents = document.getElementById("section-to-print").innerHTML; 
            var a = window.open('', '', 'height='+h+', width='+w+''); 
            a.document.write('<html>'); 
            a.document.write('<head>'); 
            a.document.write('<style>'); 
            a.document.write('@media print{body *{ font-family: arial,sans-serif; }.col-md-6{position:relative;width:50%!important;float:left!important}.col-md-3{position:relative;width:25%!important;float:left!important}#report-card-table td{border:1px solid #575962!important; padding: 2px;}#report-card-table{table-layout:fixed;min-width:100%}.table-responsive>.table-bordered{border:0}.table-bordered{border:1px solid #f4f5f8}table{border-collapse:collapse}#report-card-table td{border:1px solid #575962!important;color:#212529!important;vertical-align:middle}.text-center{text-align:center}#report-card-table td.border-0{border:1px solid transparent!important}#report-card-table td.border-bottom{border-bottom:1px solid #575962!important}#report-card-table td.p-b-0{font-size:.85rem}p{margin-bottom:0!important;margin-top:0!important}.m-t-30{margin-top:30px !important}.border-top{border-top:1px solid #575962!important}.m-b-0{margin-bottom:0!important}.text-right{text-align:right}h5{margin: 0 !important;font-size: 1.2rem;font-weight: normal;}.m-bottom-1{margin-bottom: 1.2rem !important;}}'); 
            a.document.write('</style>'); 
            a.document.write('</head>'); 
            a.document.write('<body>'); 
            a.document.write(divContents); 
            a.document.write('</body></html>'); 
            a.document.close(); 
            a.print(); 
            a.onfocus=function(){ a.close();}
        })
    
    }

    //init reportcard
    $.reportcard = new reportcard, $.reportcard.Constructor = reportcard

}(window.jQuery),

//initializing reportcard
function($) {
    "use strict";
    $.reportcard.required_fields();
    $.reportcard.init();
}(window.jQuery);
