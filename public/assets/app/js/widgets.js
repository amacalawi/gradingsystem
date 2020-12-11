!function($) {
    "use strict";

    var widgets = function() {
        this.$body = $("body");
    };

    var $required = 0; var files = []; var filesName = [];

    widgets.prototype.validate = function($form, $required)
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

    widgets.prototype.required_fields = function() {
        
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

    widgets.prototype.price_separator = function (input) {
        var output = input
        if (parseFloat(input)) {
            input = new String(input); // so you can perform string operations
            var parts = input.split("."); // remove the decimal part
            parts[0] = parts[0].split("").reverse().join("").replace(/(\d{3})(?!$)/g, "$1,").split("").reverse().join("");
            output = parts.join(".");
        }

        return output;
    },

    widgets.prototype.schoolyear_utilities = function() {
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

    widgets.prototype.get_returned_students = function() {
        console.log(base_url + "dashboard/get-returned-students");
        $.ajax({
            type: "GET",
            url: base_url + "dashboard/get-returned-students",
            success: function(response) {
                var data = $.parseJSON(response);   
                $('#returned-students').text(data.data);

            },
            async: false
        });
    },

    widgets.prototype.get_new_students = function() {
        console.log(base_url + "dashboard/get-new-students");
        $.ajax({
            type: "GET",
            url: base_url + "dashboard/get-new-students",
            success: function(response) {
                var data = $.parseJSON(response);   
                $('#new-students').text(data.data);

            },
            async: false
        });
    },

    widgets.prototype.get_active_users = function() {
        console.log(base_url + "dashboard/get-active-users");
        $.ajax({
            type: "GET",
            url: base_url + "dashboard/get-active-users",
            success: function(response) {
                var data = $.parseJSON(response);   
                $('#active-users').text(data.data);
            },
            async: false
        });
    },

    widgets.prototype.get_active_students_per_malefemale = function() {
        var widgets02 = []; 
        
        if ($('#m_widgets_02').length == 0) {
            return;
        }

        console.log(base_url + "dashboard/get-active-students-per-malefemale");
        $.ajax({
            type: "GET",
            url: base_url + "dashboard/get-active-students-per-malefemale",
            success: function(response) {
                var data = $.parseJSON(response);   
                widgets02 = data.data;
                $.each(data.data, function(i, item) {
                    if (item.label == 'Male') {
                        $('#male_students').text(item.value + '% Male');
                    } 
                    if (item.label == 'Female') {
                        $('#female_students').text(item.value + '% Female');
                    }
                }); 
                Morris.Donut({
                    element: 'm_widgets_02',
                    data: widgets02,
                    colors: [
                        mUtil.getColor('accent'),
                        mUtil.getColor('danger')
                    ],
                });
            },
            async: false
        });
    },

    widgets.prototype.get_calendar = function() {
        var widgets06 = []; 

        if ($('#widgets06').length === 0) {
            return;
        }
        
        var todayDate = moment().startOf('day');
        var YM = todayDate.format('YYYY-MM');
        var YESTERDAY = todayDate.clone().subtract(1, 'day').format('YYYY-MM-DD');
        var TODAY = todayDate.format('YYYY-MM-DD');
        var TOMORROW = todayDate.clone().add(1, 'day').format('YYYY-MM-DD');

        console.log(base_url + "dashboard/get-calendar");
        $.ajax({
            type: "GET",
            url: base_url + "dashboard/get-calendar",
            success: function(response) {
                var data = $.parseJSON(response);   
                widgets06 = data.data;
            },
            async: false
        });

        $('#widgets06').fullCalendar({
            header: {
                left: 'prev,next today',
                center: 'title',
                right: 'month,agendaWeek,agendaDay,listWeek'
            },
            // editable: true,
            eventLimit: true, // allow "more" link when too many events
            navLinks: true,
            defaultDate: moment(),
            events: widgets06,
    
            eventRender: function(event, element) {
                if (element.hasClass('fc-day-grid-event')) {
                    element.data('content', event.description);
                    element.data('placement', 'top');
                    mApp.initPopover(element);
                } else if (element.hasClass('fc-time-grid-event')) {
                    element.find('.fc-title').append('<div class="fc-description">' + event.description + '</div>');
                } else if (element.find('.fc-list-item-title').lenght !== 0) {
                    element.find('.fc-list-item-title').append('<div class="fc-description">' + event.description + '</div>');
                }
            }
    });

    },

    widgets.prototype.get_active_students_per_level = function() {
        var chartContainer = $('#widgets03');
        var widgets03Labels = [];
        var widgets03Datasets = [];

        if (chartContainer.length == 0) {
            return;
        }

        console.log(base_url + "dashboard/get-active-students-per-level");
        $.ajax({
            type: "GET",
            url: base_url + "dashboard/get-active-students-per-level",
            success: function(response) {
                var data = $.parseJSON(response);   
                $.each(data.data, function(i, item) {
                    widgets03Labels.push(item.labels);
                    widgets03Datasets.push(item.dataset);
                });
                console.log(widgets03Labels);

                var chartData = {
                    labels: widgets03Labels,
                    datasets: [{
                        //label: 'Dataset 1',
                        backgroundColor: mUtil.getColor('success'),
                        data: widgets03Datasets
                    }]
                };
        
                var chart = new Chart(chartContainer, {
                    type: 'bar',
                    data: chartData,
                    options: {
                        title: {
                            display: false,
                        },
                        tooltips: {
                            intersect: false,
                            mode: 'nearest',
                            xPadding: 10,
                            yPadding: 10,
                            caretPadding: 10
                        },
                        legend: {
                            display: false
                        },
                        responsive: true,
                        maintainAspectRatio: false,
                        barRadius: 4,
                        scales: {
                            xAxes: [{
                                display: false,
                                gridLines: false,
                                stacked: true
                            }],
                            yAxes: [{
                                display: false,
                                stacked: true,
                                gridLines: false
                            }]
                        },
                        layout: {
                            padding: {
                                left: 0,
                                right: 0,
                                top: 0,
                                bottom: 0
                            }
                        }
                    }
                });
            },
            async: false
        });
    },

    widgets.prototype.init = function()
    {   
        $.widgets.get_returned_students();
        $.widgets.get_new_students();
        $.widgets.get_active_users();
        $.widgets.get_active_students_per_malefemale();
        $.widgets.get_calendar();
        $.widgets.get_active_students_per_level();
    }

    //init widgets
    $.widgets = new widgets, $.widgets.Constructor = widgets

}(window.jQuery),

//initializing widgets
function($) {
    "use strict";
    $.widgets.required_fields();
    $.widgets.init();
}(window.jQuery);
