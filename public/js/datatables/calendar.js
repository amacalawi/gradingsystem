function AllCalendarData(){
    
    var calendarData;
    $.ajax({
        type: 'GET',
        url: base_url + 'components/calendars/get-calendar',
        success: function (data) {
            console.log(data);
            var data = $.parseJSON(data);
            calendarData = data;
        },
        error: function( jqXhr ) {
            if( jqXhr.status == 400 ) { 
                var json = $.parseJSON( jqXhr.responseText );
            }
        },
        async: false
    });

    return calendarData;
} 
    

function reloadCalendar()
{
    $.ajax({
        type: 'GET',
        url: base_url + 'components/calendars/get-calendar',
        success: function (data) {
            var data = $.parseJSON(data);
            alert(data);
            calendarData = data;
        },
        error: function( jqXhr ) {
            if( jqXhr.status == 400 ) { 
                var json = $.parseJSON( jqXhr.responseText );
            }
        },
        async: false
    });
}

function required_fields() {

    $.each($('body').find(".form-group"), function(){
        
        if($(this).hasClass('required')) {
            $(this).find('label').append('<span class="pull-right c-red">&nbsp;*</span>');            
            $(this).find("input[type='text'], select, textarea").addClass('required');
        }   

    });

}   

function hideModal($modals) {
    $modals.modal('hide');
}  

function refresh($form) {
        
    $.each($form.find("input[type='text'], select, textarea"), function(){

        if ($(this).attr("name") === undefined || $(this).attr("name") === null) {

        } else {
            if($(this).is("[multiple]")){
                if( $(this).val() ){
                    $(this).selectpicker('refresh');
                    $(this).selectpicker('deselectAll').closest(".form-group").removeClass("has-error").find(".help-block").text("");
                }
            } else if( $(this).val() != "" ){
                if(!$(this).is("select")) {             
                    $(this).val("");
                } else if($(this).is("select")) { 
                    $(this).selectpicker('refresh');
                    $(this).selectpicker('val', '0')
                } else { 
                    $(this).val("");
                }
            }
            $(this).parents(".form-group").removeClass("has-error");
            $(this).parents(".form-group").find(".help-block").text("");
        }

    });
}

function swAlert($type, $form) {

    if($type == "error" && $form != "") 
    {   
        swal({
            title: "Oops...",
            text: "Something went wrong! \nPlease fill the required fields to continue..",
            type: "warning",
            showCancelButton: false,
            closeOnConfirm: true
        }, function(isConfirm){ 

            if (isConfirm) {     
            } 

            window.onkeydown = null;
            window.onfocus = null;    

        });
    }
    else if($type == "remove-calendar" && $form == "") 
    {
        setTimeout(function(){     
            swal({   
                title: "Sweet!",   
                text: "The information has been sucessfully removed.",   
                imageUrl: base_url('assets/img/thumbs-up.png'), 
                timer: 500,   
                showConfirmButton: false
            }); 
        }, 1000);
    }
}

function validate($form, $error) {
                            
    $.each($form.find("input[type='text'], select, textarea"), function(){
           
        if ($(this).attr("name") === undefined || $(this).attr("name") === null) {

        } else { 
            if($(this).hasClass("required")){
                if($(this).is("[multiple]")){
                    if( !$(this).val() ){
                        $(this).closest(".form-group").addClass("has-error").find(".help-block").text("this field is required.");
                        $error++;
                    }
                } else if($(this).val()=="" || $(this).val()=="0"){
                    if(!$(this).is("select")) {
                        $(this).closest(".form-group").addClass("has-error").find(".help-block").text("this field is required.");
                        $error++;
                    } else {
                        $(this).closest(".form-group").addClass("has-error").find(".help-block").text("this field is required.");
                        $error++;                                          
                    }
                } 
            }
        }

    });

    return $error;

}

$(document).ready(function() {

    if ($('.date-picker')[0]) {
        $('.date-picker').datetimepicker({
            format: 'MM/DD/YYYY'
        });
    }

    required_fields();
    var calendarData = AllCalendarData();
    var date = new Date();
    var d = date.getDate();
    var m = date.getMonth();
    var y = date.getFullYear();
    
    if((m+1) < 10)
    {
        m = '0' + (m + 1);
    }

    /*
    | ---------------------------------
    | # select, input, and textarea on change or keyup remove error
    | ---------------------------------
    */
    $('body').on('change', 'select, input', function (e) {
        e.preventDefault();
        $(this).closest(".form-group").removeClass("has-error").find(".help-block").text("");
    });

    $('body').on('click', '#close-btn', function (e) {
        e.preventDefault();
        var $form = $(this).closest("form");
        $.purchase_order.refresh($form);
    });

    $('body').on('keyup', 'input, textarea', function (e) {
        e.preventDefault();
        $(this).closest(".form-group").removeClass("has-error").find(".help-block").text("");
    });

    $('body').on('dp.change', '.date-time-picker, .date-picker, .time-picker', function (e){
        e.preventDefault();
        $(this).closest(".form-group").removeClass("has-error").find(".help-block").text("");
    });

    var cId = $('#calendar'); //Change the name if you want. I'm also using thsi add button for more actions

    var ink = 0;
    $('body').on('change', '#sections', function (e) {
        
        var title = $('button').text();
        var n = title.search("SELECT ALL");

        if ( (n > -1) && (ink == 1) ){
            $('body #addNew-event #sections').selectpicker('refresh');
            $('body #addNew-event #sections').selectpicker('selectAll');
            ink = 0;
        } else if ( (n < 0) && (ink == 0) ) { 
            $('body #addNew-event #sections').selectpicker('refresh');
            $('body #addNew-event #sections').selectpicker('deselectAll');
            ink = 1;
        }

    });
    //Generate the Calendar
    cId.fullCalendar({
        header: {
            right: '',
            center: 'prev, title, next',
            left: ''
        },
        theme: true, //Do not remove this as it ruin the design
        selectable: true,
        selectHelper: true,
        editable: false,

        //Add Events
        events: calendarData,
        eventRender: function(event, element) {
            $(element).click(function(e) {
                e.preventDefault();

                console.log(event);

                swal({
                    title: "Do you like to remove this now?",
                    text: "The information will be removed to the database.",
                    type: "info",
                    confirmButtonText: "Yes, please!",
                    cancelButtonText: "No, thanks!",
                    showCancelButton: true,   
                    closeOnConfirm: false,   
                    showLoaderOnConfirm: true,
                }, function(isConfirm){
                    if (isConfirm) {   

                        var me = $(this);

                        if ( me.data('requestRunning') ) {
                            return;
                        }

                        me.data('requestRunning', true);

                        console.log(base_url('schedules/deleteCalendar/' + event.id));
                        $.ajax({
                            type: "GET",
                            url: base_url('schedules/deleteCalendar/' + event.id),
                            success: function (data) { 

                                var data = $.parseJSON(data);   
                                console.log(data);
                                $("#calendar").fullCalendar('removeEvents', event.id); 
                                swAlert('remove-calendar', '');

                            },
                            complete: function() {
                                me.data('requestRunning', false);
                                window.onkeydown = null;
                                window.onfocus = null;
                            },
                            async: false
                        });
                    }
                }); 
                
            });
            // $(element).tooltip({title: event.title});             
        },
        //On Day Select
        select: function(start, end, allDay) {            
            $('#addNew-event').modal('show');   
            $('#addNew-event input:text').val('');
            var d = new Date(end);
            var monthStart = 0, dateStart = 0, hoursStart = 0, minutesStart = 0, secondsStart = 0;
            hoursStart = (d.getHours() < 10) ? '0' + d.getHours() : d.getHours();            
            hoursEnd = (d.getHours() + 9);
            minutesStart = (d.getMinutes() < 10) ? '0' + d.getMinutes() : d.getMinutes();
            secondsStart = (d.getSeconds() < 10) ? '0' + d.getSeconds() : d.getSeconds();

            dateStart  = ((d.getDate() - 1) < 10) ? '0' + (d.getDate() - 1) : (d.getDate() - 1);
            monthStart = ((d.getMonth()+1) < 10) ? '0' + (d.getMonth()+1) : (d.getMonth()+1);

            // var startTime = (d.getMonth()+1) + '/' + (d.getDate() - 1) + '/' + d.getFullYear() + ' ' + hoursStart + ':' + minutesStart + ':' + secondsStart;
            // var endTime = (d.getMonth()+1) + '/' + (d.getDate() - 1) + '/' + d.getFullYear() + ' ' + hoursEnd + ':' + minutesStart + ':' + secondsStart;

            var startTime = monthStart + '/' + dateStart + '/' + d.getFullYear();
            var endTime = monthStart + '/' + dateStart + '/' + d.getFullYear();
            
            $('#addNew-event #getStart').val(startTime);
            $('#addNew-event #getEnd').val(endTime);

            $('body #addNew-event #sections').selectpicker('refresh');
            $('body #addNew-event #sections').selectpicker('selectAll');


            var customday = $('select[name=holidayType]').val();
            if(customday == 'custom-day'){
                $('#custom_event').css('display', 'block');
                $('input[name=calendar_start_time]').val('08:00:00');
                $('input[name=calendar_end_time]').val('17:00:00');
            }else{
                $('#custom_event').css('display', 'none');
            }

        }
    });

    //Create and ddd Action button with dropdown in Calendar header. 
    var actionMenu = 
    '<ul class="actions actions-alt" id="fc-actions">' +
        '<li class="dropdown">' +
            '<a href="" data-toggle="dropdown"><i class="zmdi zmdi-more-vert"></i></a>' +
            '<ul class="dropdown-menu dropdown-menu-right">' +
                '<li class="active">' +
                    '<a data-view="month" href="">Month View</a>' +
                '</li>' +
                '<li>' +
                    '<a data-view="basicWeek" href="">Week View</a>' +
                '</li>' +
                '<li>' +
                    '<a data-view="agendaWeek" href="">Agenda Week View</a>' +
                '</li>' +
                '<li>' +
                    '<a data-view="basicDay" href="">Day View</a>' +
                '</li>' +
                '<li>' +
                    '<a data-view="agendaDay" href="">Agenda Day View</a>' +
                '</li>' +
            '</ul>' +
        '</div>' +
    '</li>';


    cId.find('.fc-toolbar').append(actionMenu);
    
    //Event Tag Selector
    (function(){
        $('body').on('click', '.event-tag > span', function(){
            $('.event-tag > span').removeClass('selected');
            $(this).addClass('selected');
        });
    })();

    //Add new Event
    $('body').on('click', '#addEvent', function(){
        var eventName = $('#eventName').val();
        var tagColor  = $('.event-tag > span.selected').attr('data-tag');
        var urls      = base_url('schedules/saveCalendar');
        var form      = $('#EventForm');
        var error     = 0;
        var errors    = validate(form, error);

        if(errors != 0) { 
            swAlert('error', form);
        } else {                
            $.ajax({
                type: form.attr("method"),
                url: urls + '?colors=' + tagColor,
                data: form.serialize(),
                success: function (data) {
                    var data = $.parseJSON(data);
                    
                    $.each(data.datas, function(i, item) {
                        $('#calendar').fullCalendar('renderEvent', {
                            id: item.id,
                            title: item.title,
                            start: item.startDate,
                            end: item.endDate,
                            allDay: true,
                            className: tagColor
                        }, true);
                    }); 

                    // var now = new Date($('#getEnd').val());
                    // for (var d = new Date($('#getStart').val()); d <= now; d.setDate(d.getDate() + 1)) {
                        
                    //     var hoursStart = 0, minutesStart = 0, secondsStart = 0;
                    //     var hoursEnd = 0, minutesEnd = 0, secondsEnd = 0;

                    //     hoursStart = (d.getHours() < 10) ? '0' + d.getHours() : d.getHours();
                    //     minutesStart = (d.getMinutes() < 10) ? '0' + d.getMinutes() : d.getMinutes();
                    //     secondsStart = (d.getSeconds() < 10) ? '0' + d.getSeconds() : d.getSeconds();

                    //     hoursEnd = (now.getHours() < 10) ? '0' + now.getHours() : now.getHours();
                    //     minutesEnd = (now.getMinutes() < 10) ? '0' + now.getMinutes() : now.getMinutes();
                    //     secondsEnd = (now.getSeconds() < 10) ? '0' + now.getSeconds() : now.getSeconds();

                    //     $('#calendar').fullCalendar('renderEvent', {
                    //         id: 
                    //         title: eventName,
                    //         start: (d.getMonth()+1) + '/' + d.getDate() + '/' + d.getFullYear(),
                    //         end: (d.getMonth()+1) + '/' + d.getDate() + '/' + d.getFullYear(),
                    //         allDay: true,
                    //         className: tagColor
                    //     }, true);
                    // }

                    refresh(form);
                    hideModal($('#addNew-event'));
                    notify(data.message, data.type, 4000);

                    location.reload();
                },
                error: function( jqXhr ) {
                    if( jqXhr.status == 400 ) { 
                        var json = $.parseJSON( jqXhr.responseText );
                    }
                }

            });
        }
    });   

    //Calendar views
    $('body').on('click', '#fc-actions [data-view]', function(e){
        e.preventDefault();
        var dataView = $(this).attr('data-view');
        $('#fc-actions li').removeClass('active');
        $(this).parent().addClass('active');
        cId.fullCalendar('changeView', dataView);  
    });

    $('select[name=holidayType]').on('change', function (e) {

        var customday = $(this).val();

        if(customday == 'custom-day'){
            $('#custom_event').css('display', 'block');
            $('input[name=calendar_start_time]').val('08:00:00');
            $('input[name=calendar_end_time]').val('17:00:00');
        }else{
            $('#custom_event').css('display', 'none');
        }
        
    });

});  