function dtr_settings_load(arr_days, arr_in_out, arr_default_time)
{
    var time = 0;

    for(var x=0; x<arr_days.length; x++)
    {
        var dtr_date  = "<tr>";
            dtr_date += "<td><input type='checkbox' name='check_day[]' value='"+arr_days[x]+"' checked></td><td><input type='text' name='days[]' value='"+arr_days[x]+"' hidden>"+arr_days[x]+"</td><td>-</td>";
            time = 0;

        for(var y=0; y<arr_in_out.length; y++)
        {   
            dtr_date += "<td>"+"<input type='time' value='"+arr_default_time[time]+"' name='"+arr_days[x]+"_"+arr_in_out[y]+"_from"+"'>"+"</td>"; time++; //from 
            dtr_date += "<td>"+"<input type='time' value='"+arr_default_time[time]+"' name='"+arr_days[x]+"_"+arr_in_out[y]+"_to"+"'>"+"</td>";  time++; //to
        }

            dtr_date += "</tr>";
            $("#dtr_table" ).append(dtr_date);
    }
}

function dtr_settings_load_db(arr_days, arr_in_out, schedule_id)
{
    $.ajax({
        type: 'GET', 
        url: base_url + 'components/schedules/get-this-schedule/'+schedule_id,
        success: function(response) {
            var data = $.parseJSON(response); 
            var z = 0;
            //console.log(key+'=>'+value.id+', ');
            for(var x=0; x<arr_days.length; x++){

                var dtr_date  = "<tr>";
                    z = x;
                for(var y=0; y<arr_in_out.length; y++){
                    
                    $.each(data, function(key, value){   
                        if((arr_days[x]+'_'+arr_in_out[y]+'_from') == (value.day+'_'+value.name+'_from') ){
                            if(value.time_from != '00:00:00'){
                                if( x == z ){
                                    dtr_date += "<td><input type='checkbox' name='check_day[]' value='"+arr_days[x]+"' checked></td><td><input type='text' name='days[]' value='"+arr_days[x]+"' hidden>"+arr_days[x]+"</td><td>-</td>";
                                    z++;
                                }
                                dtr_date += "<td>"+"<input type='time' value='"+value.time_from+"' name='"+arr_days[x]+"_"+arr_in_out[y]+"_from"+"'>"+"</td>"; //from
                            } else {
                                if( x == z ){
                                    dtr_date += "<td><input type='checkbox' name='check_day[]' value='"+arr_days[x]+"' ></td><td><input type='text' name='days[]' value='"+arr_days[x]+"' hidden>"+arr_days[x]+"</td><td>-</td>";
                                    z++;
                                }
                                dtr_date += "<td>"+"<input type='time' value='' name='"+arr_days[x]+"_"+arr_in_out[y]+"_from"+"' disabled>"+"</td>"; //from
                            }
                        }
                        if((arr_days[x]+'_'+arr_in_out[y]+'_to') == (value.day+'_'+value.name+'_to') ){
                            if(value.time_to != '00:00:00'){
                                if( x == z ){
                                    dtr_date += "<td><input type='checkbox' name='check_day[]' value='"+arr_days[x]+"' checked></td><td><input type='text' name='days[]' value='"+arr_days[x]+"' hidden>"+arr_days[x]+"</td><td>-</td>";
                                    z++;
                                }
                                dtr_date += "<td>"+"<input type='time' value='"+value.time_to+"' name='"+arr_days[x]+"_"+arr_in_out[y]+"_to"+"'>"+"</td>"; //to
                            } else {
                                if( x == z ){
                                    dtr_date += "<td><input type='checkbox' name='check_day[]' value='"+arr_days[x]+"' ></td><td><input type='text' name='days[]' value='"+arr_days[x]+"' hidden>"+arr_days[x]+"</td><td>-</td>";
                                    z++;
                                }
                                dtr_date += "<td>"+"<input type='time' value='' name='"+arr_days[x]+"_"+arr_in_out[y]+"_to"+"' disabled>"+"</td>"; //to
                            }
                        }
                    });
                }
                    dtr_date += "</tr>";
                    $("#dtr_table" ).append(dtr_date);
            }
        }, 
        complete: function() {
            window.onkeydown = null;
            window.onfocus = null;
        }
    });
}

jQuery(document).ready(function () {
    
    var arr_days = ['mon', 'tue', 'wed', 'thu', 'fri', 'sat', 'sun'];
    var arr_in_out = ['normal_in', 'normal_out', 'late_in', 'late_out', 'early_in', 'early_out'];
    var arr_default_time = ['07:00:00','08:00:00', '16:00:00', '17:00:00', '08:01:00', '09:00:00', '17:01:00', '18:00:00', '06:00:00', '06:59:00', '11:00:00', '11:59:00',];
    var schedule_id =  $("input[name=schedule_id]").val();

    if($("input[name=method]").val() == 'add'){
        dtr_settings_load(arr_days, arr_in_out, arr_default_time);
    } else {
        dtr_settings_load_db(arr_days, arr_in_out, schedule_id);
    }

    $('#dtr_table').on('change','input[name=check_day\\[\\]]',function(e){
        e.preventDefault();
        if($(this).is(':checked')) {
            for(var x=0; x<arr_days.length; x++){
                for(var y=0; y<arr_in_out.length; y++){
                    if(arr_days[x] == $(this).val()){
                        $("input[name="+arr_days[x]+"_"+arr_in_out[y]+"_from]").prop('disabled', false);
                        $("input[name="+arr_days[x]+"_"+arr_in_out[y]+"_to]").prop('disabled', false);
                    }
                }
            }
        }else {
            for(var x=0; x<arr_days.length; x++){
                for(var y=0; y<arr_in_out.length; y++){
                    if(arr_days[x] == $(this).val()){
                        $("input[name="+arr_days[x]+"_"+arr_in_out[y]+"_from]").prop('disabled', true);
                        $("input[name="+arr_days[x]+"_"+arr_in_out[y]+"_to]").prop('disabled', true);
                    }
                }
            }
        }
    });

    $("#clear_dtr").click(function(e){
        e.preventDefault();
        swal({
            title: "Warning",
            text:  "Do you really want to clear time settings?",
            type:  "warning",
            showCancelButton: true,
            closeOnConfirm: true,
            confirmButtonClass: "btn btn-danger btn-focus m-btn m-btn--custom"
        }).then((confirmed) => {
            if(confirmed.value)
            {
                for(var x=0; x<arr_days.length; x++){
                    for(var y=0; y<arr_in_out.length; y++){
                        $("input[name="+arr_days[x]+"_"+arr_in_out[y]+"_from]").val('');
                        $("input[name="+arr_days[x]+"_"+arr_in_out[y]+"_to]").val('');
                    }
                }
            }
        });
    });

    $("#restore_dtr").click(function(e){
        e.preventDefault();
        swal({
            title: "Warning",
            text:  "Do you want to restore default time settings?",
            type:  "warning",
            showCancelButton: true,
            closeOnConfirm: true,
            confirmButtonClass: "btn btn-danger btn-focus m-btn m-btn--custom"
        }).then((confirmed) => {
            if(confirmed.value)
            {
                for(var x=0; x<arr_days.length; x++){
                    time = 0;
                    for(var y=0; y<arr_in_out.length; y++){
                        $("input[name="+arr_days[x]+"_"+arr_in_out[y]+"_from]").val(arr_default_time[time]); time++;
                        $("input[name="+arr_days[x]+"_"+arr_in_out[y]+"_to]").val(arr_default_time[time]); time++;
                    }
                }
            }
        });
    });

});