!function($) {
    "use strict";

    var gradingsheet = function() {
        this.$body = $("body");
    };

    var $required = 0; var files = []; var transmutations = [];

    gradingsheet.prototype.validate = function($form, $required)
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

    gradingsheet.prototype.required_fields = function() {
        
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

    gradingsheet.prototype.price_separator = function (input) {
        var output = input
        if (parseFloat(input)) {
            input = new String(input); // so you can perform string operations
            var parts = input.split("."); // remove the decimal part
            parts[0] = parts[0].split("").reverse().join("").replace(/(\d{3})(?!$)/g, "$1,").split("").reverse().join("");
            output = parts.join(".");
        }

        return output;
    },

    gradingsheet.prototype.do_uploads = function($id) {
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

    gradingsheet.prototype.compute = function($rows, $group = '', $activity, $component) 
    {   
        if ($group != '') {
            var $tcCell  = $rows.find('.tc-cell input[name="tc_score[]"]');
            var $qcCell  = $rows.find('.quarter-cell');
            var $initialCell = $rows.find('.initial-cell');
    
            var $sum = 0, $division = 0;
            $.each($rows.find('td .component-cell'), function(){
                var $score = $(this).val();

                if ($score != '') {
                    $sum += parseFloat($score);
                    $division++;
                } 
            });

            var $initPercent = 0;
            if ($sum > 0) {
                $initPercent += parseFloat($sum) / parseFloat($division);
                console.log('init percent: ' + parseFloat($initPercent));
            }

            if ( parseFloat($tcCell.val()) > 0 ) {
                $initPercent = parseFloat($initPercent) + parseFloat($tcCell.val());
            }

            var $scoring = $initPercent.toString().match(/^-?\d+(?:\.\d{0,2})?/)[0];
            $initialCell.text($scoring);
            console.log('scoring: ' + $scoring);

            // var filters = transmutations.filter(x => x.score <= $scoring);
            // var qg = Math.max.apply(Math, filters.map(function(o) { return o.equivalent; }));
            var qg = $scoring;
            $qcCell.text(qg);
        } 
        else
        {   
            var $tcCell = $rows.find('.tc-cell input[name="tc_score[]"]');
            var $initialCell = $rows.find('.initial-cell');
            var $qcCell  = $rows.find('.quarter-cell');

            var $initPercent = 0, $division = 0;
            $.each($rows.find('td .component-cell'), function(){
                var $score = $(this).val();

                if ($score != '') {
                    $initPercent += parseFloat($score);
                    $division++;
                }
            });

            if ($division > 0) {
                $initPercent = parseFloat($initPercent) / parseFloat($division);
            }
            if ($tcCell.val() != '') {
                $initPercent = parseFloat($initPercent) + parseFloat($tcCell.val());
            }

            var $scoring = $initPercent.toString().match(/^-?\d+(?:\.\d{0,2})?/)[0];
            $initialCell.text($scoring)

            // var filters = transmutations.filter(x => x.score <= $scoring);
            // var qg = Math.max.apply(Math, filters.map(function(o) { return o.equivalent; }));
            var qg = $scoring;
            $qcCell.text(qg);
        }

        var initGrade = $rows.find('.tc-cell input[name="init_grade[]"]');
        var quarterGrade = $rows.find('.tc-cell input[name="quarter_grade[]"]');
        initGrade.val($scoring);
        quarterGrade.val(qg);

        var $rating = '';
        if (parseFloat(qg) >= 95) {
            $rows.find('.rating-cell').text('E');
            $rows.find('input[name="rating[]"]').val('E');
            $rating = 'E';
        } else if (parseFloat(qg) >= 90) {
            $rows.find('.rating-cell').text('VS');
            $rows.find('input[name="rating[]"]').val('VS');
            $rating = 'VS';
        } else if (parseFloat(qg) >= 85) {
            $rows.find('.rating-cell').text('S');
            $rows.find('input[name="rating[]"]').val('S');
            $rating = 'S';
        } else if (parseFloat(qg) >= 80) {
            $rows.find('.rating-cell').text('MS');
            $rows.find('input[name="rating[]"]').val('MS');
            $rating = 'MS';
        } else if (parseFloat(qg) >= 75) {
            $rows.find('.rating-cell').text('FS');
            $rows.find('input[name="rating[]"]').val('FS');
            $rating = 'FS';
        } else {
            $rows.find('.rating-cell').text('NI');
            $rows.find('input[name="rating[]"]').val('NI');
            $rating = 'NI';
        }

        $.gradingsheet.rankings($rows, $scoring, qg, $rating, $activity, $component);
    },

    gradingsheet.prototype.rankings = function($rows = '', $scoring = '', $quartergrade = '', $rating = '', $activity = '', $component = '')
    {
        $(".quarter-cell")
        .map(function(){return $(this).text()})
        .get()
        .sort(function(a,b){return a - b })
        .reduce(function(a, b){ if (b != a[0]) a.unshift(b); return a }, [])
        .forEach((v,i)=>{
            var $i = i + 1;
            $('.quarter-cell').filter(function() {return $(this).text() == v;}).next().find('input[name="ranking[]"]').val($i).parents('td').next().next().text($i);
        });

        if ($rows !== '' && $component !== '') {
            var rowActivity = $component;
            var rowGrade = $scoring;
            var rowQuarter = $quartergrade;
            var rowTc = $rows.find('input[name="tc_score[]"]').val();
            var rowRating = $rating;
            var rowRanking = $rows.find('input[name="ranking[]"]').val();
            
            console.log(base_url + 'academics/grading-sheets/all-gradingsheets/update-rows/' +  + $('#gradingsheetid').val() + '?component=' + rowActivity + '&score=' + $activity + '&igrade=' + rowGrade + '&qgrade=' + rowQuarter + '&tcscore=' + rowTc + '&rating=' + rowRating + '&ranking=' + rowRanking);
            $.ajax({
                type: 'GET',
                url: base_url + 'academics/grading-sheets/all-gradingsheets/update-rows/' +  + $('#gradingsheetid').val() + '?component=' + rowActivity + '&score=' + $activity + '&igrade=' + rowGrade + '&qgrade=' + rowQuarter + '&tcscore=' + rowTc + '&rating=' + rowRating + '&ranking=' + rowRanking,
                success: function(response) {
                    var data = JSON.parse(response);
                    console.log(data);
                },
                async: false
            });
        }
    },

    gradingsheet.prototype.reload_subject_via_section = function($section)
    {   
        var $subject = $('#subject_id');
        $subject.find('option').remove();
        $subject.append('<option value="">select a subject</option>');  

        console.log(base_url + 'academics/grading-sheets/all-gradingsheets/reload-subject/' + $section);
        $.ajax({
            type: "GET",
            url: base_url + 'academics/grading-sheets/all-gradingsheets/reload-subject/' + $section,
            success: function(response) {
                var data = JSON.parse(response);
                $.each(data.subjects, function(i, item) {
                    $subject.append('<option value="' + item.id + '">' + item.name + '</option>');  
                }); 
            } 
        });

        $.gradingsheet.required_fields();
    },

    gradingsheet.prototype.reload_section_subject_quarter = function($type) 
    {   
        var $section = $('#section_id'), $subject = $('#subject_id'), $quarter = $('#quarter_id');
        $section.find('option').remove(); $subject.find('option').remove(); $quarter.find('option').remove();
        $section.append('<option value="">select a section</option>');  
        $subject.append('<option value="">select a subject</option>');  
        $quarter.append('<option value="">select a quarter</option>');  

        console.log(base_url + 'academics/grading-sheets/all-gradingsheets/reload/' + $type);
        $.ajax({
            type: "GET",
            url: base_url + 'academics/grading-sheets/all-gradingsheets/reload/' + $type,
            success: function(response) {
                var data = JSON.parse(response);
                $.each(data.sections, function(i, item) {
                    $section.append('<option value="' + item.id + '">' + item.name + '</option>');  
                }); 
                $.each(data.subjects, function(i, item) {
                    $subject.append('<option value="' + item.id + '">' + item.name + '</option>');  
                }); 
                $.each(data.quarters, function(i, item) {
                    $quarter.append('<option value="' + item.id + '">' + item.name + '</option>');  
                }); 
            } 
        });

        $.gradingsheet.required_fields();
    },

    gradingsheet.prototype.fetch_transmutations = function()
    { 
        $.ajax({
            type: 'GET',
            url: base_url + 'academics/grading-sheets/all-gradingsheets/fetch-transmutations/' + $('#type').text(),
            success: function(response) {
                transmutations = JSON.parse(response);
            },
            async: false
        });

        console.log(transmutations);
    },

    gradingsheet.prototype.init = function()
    {   
        $.gradingsheet.fetch_transmutations();
        $.gradingsheet.rankings('');
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
            $('#slug').val(self.replace(/\s+/g, '-').toLowerCase());
        });

        this.$body.on('keyup', '.component-cell', function (e){
            e.preventDefault();
            var self = $(this);
            var maxValue = $(this).attr('maxvalue');

            if (maxValue != '') { 
                if (parseFloat(self.val()) > parseFloat(maxValue)) {
                    swal({
                        title: "Oops...",
                        text: "the input value must be less than or equal to the HPS",
                        type: "warning",
                        showCancelButton: false,
                        closeOnConfirm: true,
                        confirmButtonClass: "btn btn-warning btn-focus m-btn m-btn--pill m-btn--air m-btn--custom"
                    });
                    self.val('');
                }
            } else {
                self.val('');
            }
            $.gradingsheet.compute(self.closest('tr'), self.closest('td').attr('group'));
        });
        // this.$body.on('blur', '.component-cell', function (e){
        //     e.preventDefault();
        //     var self = $(this);
        //     var maxValue = $(this).attr('maxvalue');

        //     if (maxValue != '') { 
        //         if (parseFloat(self.val()) > parseFloat(maxValue)) {
        //             swal({
        //                 title: "Oops...",
        //                 text: "the input value must be less than or equal to the HPS",
        //                 type: "warning",
        //                 showCancelButton: false,
        //                 closeOnConfirm: true,
        //                 confirmButtonClass: "btn btn-warning btn-focus m-btn m-btn--pill m-btn--air m-btn--custom"
        //             });
        //             self.val('');
        //         }
        //     } else {
        //         self.val('');
        //     }
        //     $.gradingsheet.compute(self.closest('tr'), self.closest('td').attr('group'));
        // });

        this.$body.on('keyup', 'input[name="tc_score[]"]', function (e){
            e.preventDefault();
            var rows = $(this).closest('tr');
            var self = $(this);
            var maxValue = $(this).attr('maxvalue');

            if (parseFloat(self.val()) > parseFloat(maxValue)) {
                self.val(maxValue);
            }
            $.gradingsheet.compute(self.closest('tr'), '');
        });

        this.$body.on('change', '#education_type_id', function (e){
            e.preventDefault();
            var self = $(this).val();

            if (self != '') {
                $.gradingsheet.reload_section_subject_quarter(self);
            }
        });

        this.$body.on('change', '#section_id', function (e){
            e.preventDefault();
            var self = $(this).val();

            if (self != '') {
                $.gradingsheet.reload_subject_via_section(self);
            }
        });

        this.$body.on('click', '.submit-btn', function (e){
            e.preventDefault();
            var $self = $(this);
            var $form = $('form[name="gradingsheet_form"]');
            var $error = $.gradingsheet.validate($form, 0);

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
                $.gradingsheet.required_fields();
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
                                            window.location.replace(base_url + 'academics/grading-sheets/all-gradingsheets');
                                        }
                                    }
                                });
                            }, 500 + 300 * (Math.random() * 5));
                        } else {
                            if ($form.attr('method') == 'POST') {
                                $self.html('<i class="la la-save"></i> Generate Grading Sheet').removeClass('m-loader m-loader--right m-loader--light').attr('disabled', false);
                            } else {
                                $self.html('<i class="la la-save"></i> Save Changes').removeClass('m-loader m-loader--right m-loader--light').attr('disabled', false);
                            }
                            $form.find('select[name="type"]').next().text('This is an existing type.');
                            $form.find('select[name="section_id"]').next().text('This is an existing section.');
                            $form.find('select[name="subject_id"]').next().text('This is an existing subject.');
                            $form.find('select[name="quarter_id"]').next().text('This is an existing quarter.');
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

        this.$body.on('blur', 'input[name="score[]"]', function (e){
            e.preventDefault();
            var self = $(this);
            var row = $(this).closest('tr');
            var col = $(this).closest('td');
            var rowId = $('#gradingsheetid').val();
            var rowActivity = col.find('input[name="component[]"]').val();
            var rowGrade = row.find('input[name="init_grade[]"]').val();
            var rowQuarter = row.find('input[name="quarter_grade[]"]').val();
            var rowTc = row.find('input[name="tc_score[]"]').val();
            var rowRating = row.find('input[name="rating[]"]').val();
            var rowRanking = row.find('input[name="ranking[]"]').val();
            var maxValue = $(this).attr('maxvalue');

            if (self.val() != '') {
                if (maxValue != '') { 
                    if (parseFloat(self.val()) > parseFloat(maxValue)) {
                        swal({
                            title: "Oops...",
                            text: "the input value must be less than or equal to the HPS (100)",
                            type: "warning",
                            showCancelButton: false,
                            closeOnConfirm: true,
                            confirmButtonClass: "btn btn-warning btn-focus m-btn m-btn--pill m-btn--air m-btn--custom"
                        });
                        self.val('');
                    } 
                } else {
                    self.val('');
                }
                $.gradingsheet.compute(self.closest('tr'), self.closest('td').attr('group'), self.val(), rowActivity);
            }
        });
    }

    //init gradingsheet
    $.gradingsheet = new gradingsheet, $.gradingsheet.Constructor = gradingsheet

}(window.jQuery),

//initializing gradingsheet
function($) {
    "use strict";
    $.gradingsheet.required_fields();
    $.gradingsheet.init();
}(window.jQuery);
