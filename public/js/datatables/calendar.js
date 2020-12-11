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
        /*
        setTimeout(function(){     
            swal({
                title: "Success...",
                text: "Something went wrong! \nPlease fill the required fields to continue..",
                type: "sucess",
                showCancelButton: false,
                closeOnConfirm: true,
                timer: 500,
            }); 
        }, 1000);
        */
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

//== Class definition
var calendar = function() {

    var calendarInit = function() {
        if ($('#x_calendar').length === 0) {
            return;
        }
        
        var todayDate = moment().startOf('day');
        var YM = todayDate.format('YYYY-MM');
        var YESTERDAY = todayDate.clone().subtract(1, 'day').format('YYYY-MM-DD');
        var TODAY = todayDate.format('YYYY-MM-DD');
        var TOMORROW = todayDate.clone().add(1, 'day').format('YYYY-MM-DD');

        $('#x_calendar').fullCalendar({
            header: {
                left: 'prev,next today',
                center: 'title',
                right: 'month,agendaWeek,agendaDay,listWeek'
            },
            editable: true,
            eventLimit: true, // allow "more" link when too many events
            navLinks: true,
            defaultDate: moment().format("YYYY-MM-DD"),
            events: {
                url: base_url + 'components/calendars/get-calendar',
                error: function() {
                    $('#script-warning').show();
                },
                success: function(data){
                    
                }
            },
            
            dayClick: function(date, allDay, jsEvent, view) {
                $('#addNew-event').modal('show'); 
            },

            eventClick: function (calEvent, jsEvent, view, idEvent) {
                swal({
                    title: "Do you like to remove this now?",
                    text:  "The information will be removed to the database.",
                    type:  "warning",
                    confirmButtonText: "Yes, please!",
                    cancelButtonText: "No, thanks!",
                    showCancelButton: true,
                    closeOnConfirm: true,
                    confirmButtonClass: "btn btn-danger btn-focus m-btn m-btn--custom"
                }).then((confirmed) => {
                    if(confirmed.value){

                        $.ajax({
                            type: "GET",
                            url: base_url + 'components/calendars/remove/'+ calEvent.id,
                            success: function (data) { 
                                var data = $.parseJSON(data);   
                                console.log(data);
                            },
                            complete: function() {
                                window.onkeydown = null;
                                window.onfocus = null;
                                location.reload();
                            },
                            async: false
                        });
                    }
                });
            },

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
    }

    return {
        //== Init demos
        init: function() {
            // calendar
            calendarInit();
        }
    };
}();

//== Class initialization on page load
jQuery(document).ready(function() {
    calendar.init();

    $('body').on('click', '#addEvent', function(){
        var urls      = base_url + 'components/calendars/store';
        var form      = $('#EventForm');
        var error     = 0;
        var errors    = validate(form, error);

        if(errors != 0) { 
            swAlert('error', form);
        } else {                
            $.ajax({
                type: form.attr("method"),
                url: urls,
                data: form.serialize(),
                success: function (data) {
                    var data = $.parseJSON(data);
                    refresh(form);
                    $('#addNew-event').modal('hide');
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