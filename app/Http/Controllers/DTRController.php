<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use App\Models\Admission;
use App\Models\Batch;
use App\Models\Student;
use App\Models\Staff;
use App\Models\Calendar;
use App\Models\CalendarSection;
use App\Models\CalendarSetting;
use App\Models\Enrollment;
use App\Models\Dtr;
use App\Models\Dtrlog;
use App\Models\DtrTimeSetting;
use App\Models\DtrSendingConfig;
use App\Models\PresetMessage;
use App\Models\Prefix;
use Session;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Http\File;
use App\Components\FlashMessages;
use App\Helper\Helper;

class DTRController extends Controller
{   
    use FlashMessages;
    private $models;

    public function __construct()
    {   
        date_default_timezone_set('Asia/Manila');
    }

    public function dtr() 
    {
		$id_no = $this->input->get('stud_no');
		$e_date = $this->input->get('e_date');
		$e_time = $this->input->get('e_time');
		$e_mode = $this->input->get('e_mode');
		$e_tid = $this->input->get('e_tid') ? $this->input->get('e_tid') : '';
		$timelog = date("Y-m-d H:i:s", strtotime($e_date . " " . $e_time));
		$dt = strtotime($e_date);
        $day = date("D", $dt);
        $timestamp = date('Y-m-d H:i:s');
        $full_day = $this->change_date($day);
        
        $res = Student::where('identification_no', $id_no)->get();

        if ($res->count() > 0) {
            echo "-- STUDENT IS REGISTERED --"; 
            echo "\n<br>";
            
            $student = $res->first();
            $calendar = 0; $section = 0; $calendarOverwrite = 0;
            $date = date("Y-m-d", strtotime($e_date));
            $time = date("H:i:s", strtotime($e_time));

            $calendarRow = Calendar::where('name', 'like', '%' . $date . '%')
            ->where([
                'batch_id' => (new Batch)->get_current_batch(),
                'is_active' => 1
            ]) 
            ->get();

            if ($calendarRow->count() > 0) {
                $calendar = 1;
                $calendarRow = $calendarRow->first();
                $calendar_sectionRows = CalendarSection::where([
                    'calendar_id', $calendarRow->id
                ])
                ->get();

                if ($calendar_sectionRows->count() > 0) {
                    foreach ($calendar_sectionRows as $calendar_sectionRow) {
                        Admission::where([
                            'batch_id' => (new Batch)->get_current_batch(),
                            'section_info_id' => $calendar_sectionRow->section_info_id,
                            'student_id' => $student->id
                        ])
                        ->get();
                    }
                }
            } 

            if($calendar > 0 && $section > 0)
            {   
                $calendarOverwrite = 1;
                $calendar_id = Calendar::where([
                    'is_active' => 1,
                    'type' => 0,
                    'specification' => 'custom-day'
                ])
                ->where('start_date', 'like', '%' . $date . '%')
                ->get();

				if ($calendar_id->count() > 0){
                    $calendar_settingRow = CalendarSetting::where([
                        'calendar_id' => $calendar_id->first()->id,
                        'is_active' => 1,
                    ])
                    ->where('time_from', '<=', $time)
                    ->where('time_to', '>=', $time)
                    ->get();

                    if ($calendar_settingRow->count() > 0) {
                        $status = $calendar_settingRow->first()->name;
                    } else {
                        $status = 0;
                    }

				} else {
                    $enrollmentRow = Enrollment::select('dtr_time_settings.name')
                    ->join('schedules', function($join)
                    {
                        $join->on('sched.id', '=', 'enrollments.schedule_id');
                    })
                    ->join('dtr_time_settings', function($join)
                    {
                        $join->on('sched.id', '=', 'dtr_time_settings.schedule_id');
                    })
                    ->join('dtr_time_days', function($join)
                    {
                        $join->on('dtr_time_settings.id', '=', 'dtr_time_days.dtr_time_settings_id');
                    })
                    ->where('dtr_time_days.time_from', '<=', $timed_in)
                    ->where('dtr_time_days.time_to', '>=', $timed_in)
                    ->where([
                        'enrollments.batch_id' => (new Batch)->get_current_batch(),
                        'dtr_time_days.day' => $day,
                        'dtr_time_days.mode' => $mode,
                        'enrollments.student_no' => $student->identification_no
                    ])
                    ->get();

                    if ($enrollmentRow->count() > 0) {
                        $status = $enrollmentRow->first()->name;
                    } else {
                        $status = 'GENERIC';
                    }
				}
            }
            else
            {
                $enrollmentRow = Enrollment::select('dtr_time_settings.name')
                ->join('schedules', function($join)
                {
                    $join->on('sched.id', '=', 'enrollments.schedule_id');
                })
                ->join('dtr_time_settings', function($join)
                {
                    $join->on('sched.id', '=', 'dtr_time_settings.schedule_id');
                })
                ->join('dtr_time_days', function($join)
                {
                    $join->on('dtr_time_settings.id', '=', 'dtr_time_days.dtr_time_settings_id');
                })
                ->where('dtr_time_days.time_from', '<=', $timed_in)
                ->where('dtr_time_days.time_to', '>=', $timed_in)
                ->where([
                    'enrollments.batch_id' => (new Batch)->get_current_batch(),
                    'dtr_time_days.day' => $day,
                    'dtr_time_days.mode' => $mode,
                    'enrollments.student_no' => $student->identification_no
                ])
                ->get();

                if ($enrollmentRow->count() > 0) {
                    $status = $enrollmentRow->first()->name;
                } else {
                    $status = 'GENERIC';
                }
            }

            $dtr = Dtrlog::create([
                'user_id' => $res->user_id,
                'timelog' => $timelog,
                'mode' => $e_mode,
                'status' => $status,
                'created_at' => $timestamp
            ]);

            $status_req = $this->in_out_status($status);
            $is_timein=false;
			$is_timeout=false;

            $dtr = Dtr::where([
                'user_id' => $res->user_id,
                'datein' => date('Y-m-d')
            ])
            ->get();

            if ($dtr->count() > 0) {
                if($dtr->count() > 0 && $e_mode == 0)
                {
                    $dtr = $dtr->first()->id;
                    $dateout = date("Y-m-d", strtotime($e_date));
                    $timeout = date("H:i:s", strtotime($e_time));
                    $totallate = 0;
                    $default_time = strtotime('00:00:00');

                    $dtr_check = Dtrlog::select('timelog')
                    ->where([
                        'mode' => 1,
                        'user_id' => $res->user_id
                    ])
                    ->where('timelog', 'like', '%' . $dateout . '%')
                    ->orderBy('id')
                    ->get();
                
                    $in = ($check->count() > 0) ? date('H:i:s', strtotime($dtr_check->first()->timelog)) : 0;
                    if ($in != 0) {
                        $time_in_hr = Date("H",strtotime($in))* 60 ;
                        $time_in_min  = Date("i",strtotime($in));

                        $reg_in_hr = Date('H', strtotime($this->get_scheduled_latein($res->identification_no, $day))) * 60;
                        $reg_in_min  = Date('i', strtotime($this->get_scheduled_latein($res->identification_no, $day))) - 1;

                        if ($time_in_hr > $reg_in_hr) {
                            $minutes = ($time_in_hr + $time_in_min) - ($reg_in_hr + $reg_in_min);
                            $totallate = floatval($totallate) + floatval($minutes);

                        } else if (($time_in_hr == ($reg_in_hr)) && $time_in_min > 0) {
                            $totallate = floatval($totallate) + floatval($time_in_min);
                        }	
                    }

                    Dtr::where('id', $dtr)
                    ->update([
                        'dateout' => $dateout,
                        'timeout' => $timeout,
                        'total_late' => date('H:i', strtotime( ( $totallate > 0) ? date('H:i', strtotime('+'.$totallate.' minutes', $default_time)) : '00:00:00' ))
                    ]);
                    $is_timeout = true;
                }
                else
                {
                    $dtr = -1;
                } 
            } else {
                $is_timein = true;
                $time_field = 'timein';
                $date_field = 'datein';

                if($status_req == 'in'){
                    $time_field = 'timein';
                    $date_field = 'datein';
                    $time = date("H:i:s", strtotime($e_time));
                    $date = date("Y-m-d", strtotime($e_date));
                }
                else if($status_req == 'out'){
                    $time_field = 'timeout';
                    $date_field = 'dateout';
                    $time = date("H:i:s", strtotime($e_time));
                    $date = date("Y-m-d", strtotime($e_date));			    	
                }

                $dtr = Dtr::create([
                    'user_id' => $res->user_id,
                    $date_field => $date,
                    $time_field => $time,
                    'created_at' => $timestamp
                ]);
            }

            $msisdns = str_replace(' ','',$this->Member->find($stud_no, "stud_no", "msisdn")->msisdn);

			$send_data = array(
			    "stud_no" => $res->identification_no,
			    "stud_name" => $res->firstname.' '.$res->lastname,
			    "mode" => $e_mode,
			    "date" => date("M-d-y", strtotime($e_date)),
			    "time" => date("H:i:s", strtotime($e_time)),
			    "msisdn" => $res->mobile_no,
			    "is_timein" => $is_timein,
			    "is_timeout" => $is_timeout,
			    "full_day" => $full_day,
                "schedule_id" => (new Enrollment)->where(['batch_id' => (new Batch)->get_current_batch(), 'student_no' => $res->identification_no, 'is_active' => 1])->pluck('schedule_id'),
			    "calendarOverwrite" => $calendarOverwrite
			);

            echo $this->execute($send_data);
            
        } else {
            $res2 = Staff::where('identification_no', $id_no);
            
            if ($res2->count() > 0) {

            } else {
                echo "**!! ID No. IS NOT REGISTERED !!**"; exit();
            }
        } 
    }

    public function execute($data=null)
    {
		$e_time = $data['time'];
		$e_mode = $data['mode'];
		$e_date = $data['date'];
		$e_full_day = $data['full_day'];
		$calendarOverwrite = $data['calendarOverwrite'];
		$schedule_id = (null != $data['schedule_id'] && 0 != $data['schedule_id']) ? $data['schedule_id'] : 1;

		if ($e_mode == 1) {
			// Time in
			/*$times = $this->db->query("SELECT * FROM dtr_time_settings 
            JOIN dtr_time_days ON dtr_time_days.dtrts_id = dtr_time_settings.id 
            WHERE dtr_time_settings.mode = '$e_mode' 
            AND name LIKE '%IN%' 
            AND schedule_id = $schedule_id 
            AND dtr_time_days.day = '$e_full_day' 
            AND '$e_time' BETWEEN dtr_time_days.time_from 
            AND dtr_time_days.time_to LIMIT 1")->row();*/

            $times = DtrTimeSetting::select('*')
            ->join('dtr_time_days', function($join)
            {
                $join->on('dtr_time_days.dtr_time_settings_id', '=', 'dtr_time_settings.id');
            })
            ->where('dtr_time_settings.name', 'like', '%IN%')
            ->where([
                'dtr_time_settings.mode' => $e_mode,
                'dtr_time_settings.schedule_id' => $schedule_id,
                'dtr_time_days.day' =>  $e_full_day,
                'dtr_time_settings.is_active' => 1
            ])
            ->where(''.$e_time.' BETWEEN dtr_time_days.time_from AND dtr_time_days.time_to LIMIT 1')
            ->first();

			//var_dump("asdasd------------", $e_time); die();
		} else {
			// Time out
			/*$times = $this->db->query("SELECT * FROM dtr_time_settings 
            JOIN dtr_time_days ON dtr_time_days.dtrts_id = dtr_time_settings.id 
            WHERE dtr_time_settings.mode = '$e_mode' 
            AND name LIKE '%OUT%' 
            AND schedule_id = $schedule_id 
            AND dtr_time_days.day = '$e_full_day' 
            AND '$e_time' BETWEEN dtr_time_days.time_from 
            AND dtr_time_days.time_to LIMIT 1")->row();*/

            $times = DtrTimeSetting::select('*')
            ->join('dtr_time_days', function($join)
            {
                $join->on('dtr_time_days.dtr_time_settings_id', '=', 'dtr_time_settings.id');
            })
            ->where('dtr_time_settings.name', 'like', '%OUT%')
            ->where([
                'dtr_time_settings.mode' => $e_mode,
                'dtr_time_settings.schedule_id' => $schedule_id,
                'dtr_time_days.day' =>  $e_full_day,
                'dtr_time_settings.is_active' => 1
            ])
            ->where(''.$e_time.' BETWEEN dtr_time_days.time_from AND dtr_time_days.time_to LIMIT 1')
            ->first();
		}
		///*
		//Added by Jin
		if($calendarOverwrite > 0){
			if ($e_mode == 1) {
				/*$times = $this->db->query("SELECT * FROM calendar_time_settings 
                JOIN calendar ON calendar.calendar_id = calendar_time_settings.id 
                WHERE calendar_time_settings.mode = '$e_mode' 
                AND name LIKE '%IN%' AND '$e_time' 
                BETWEEN calendar_time_settings.time_from 
                AND calendar_time_settings.time_to LIMIT 1")->row();*/

                $times = CalendarSetting::select('*')
                ->join('calendars', function($join)
                {
                    $join->on('calendars.id', '=', 'calendars_settings.calendar_id');
                })
                ->where('calendars_settings.name', 'like', '%IN%')
                ->where([
                    'calendars_settings.mode' => $e_mode,
                    'calendars_settings.is_active' => 1
                ])
                ->where(''.$e_time.' BETWEEN calendars_settings.time_from AND calendars_settings.time_to LIMIT 1')
                ->first();

			} else {
				/*$times = $this->db->query("SELECT * FROM calendar_time_settings 
                JOIN calendar ON calendar.dtrts_id = calendar_time_settings.id 
                WHERE calendar_time_settings.mode = '$e_mode' 
                AND name LIKE '%OUT%' AND '$e_time' 
                BETWEEN calendar_time_settings.time_from 
                AND calendar_time_settings.time_to LIMIT 1")->row();*/

                $times = CalendarSetting::select('*')
                ->join('calendars', function($join)
                {
                    $join->on('calendars.id', '=', 'calendars_settings.calendar_id');
                })
                ->where('calendars_settings.name', 'like', '%OUT%')
                ->where([
                    'calendars_settings.mode' => $e_mode,
                    'calendars_settings.is_active' => 1
                ])
                ->where(''.$e_time.' BETWEEN calendars_settings.time_from AND calendars_settings.time_to LIMIT 1')
                ->first();
			}			
		}
		//*/
		if (empty($times)) {
			echo "WARNING | Out too Early | Must have been a double tap. No Message will be sent."; exit();
		}

        // $template = $this->db->query("SELECT * FROM preset_messages WHERE id='$times->presetmsg_id'")->row();
        
        $template = PresetMessage::select('*')
        ->where([
            'id', $times->presetmsg_id,
            'is_active' => 1
        ])
        ->first();

		$detokenized = $this->Message->detokenize($template->name, $data);
		$body = $detokenized;
		$msisdns = explode(',', $data['msisdn']);

		foreach ($msisdns as $msisdn) 
		{
			# Check table str_sending_config which config is enabled
			# for sending
            // $sending = $this->db->select('config')->where('enabled', 1)
            // ->limit(1)->get('dtr_sending_config')->row();

            $sending = DtrSendingConfig::select('config')
            ->where([
                'is_enabled' => 1,
                'is_active' => 1
            ])
            ->first();

			echo isset($sending->config) ? "$sending->config | $times->name | $body\n<br>" : 'NO MODE |';
			// echo "$sending->config | $times->name | $body";
			$message_id = null;

			if ($sending && !empty($sending->config)) {
				# Compose message
				$messages = array(
                    'messages' => $body,
                    'message_type_id' => 4,
                    'created_at' => $timestamp
                );
                
				switch ($sending->config) {
                    case 'A':
                        $message = Message::create($messages);
                        $message_id = $message->id;
						// $message_id = $this->Message->insert($message);
						echo "MODE A | A message will be sent\n<br>";
						break;

					case 'B':
						$today_is_a_weekend = in_array(date('D'), array('Sat', 'Sun')) ? 1 : 0;
						$time_inLate_or_outEarly = in_array($times->name, array('LATE_IN', 'LATE_OUT', 'EARLY_OUT')) ? 1 : 0;
						if (1 == $today_is_a_weekend || 1 == $time_inLate_or_outEarly) {
                            $message = Message::create($messages);
                            $message_id = $message->id;
							// $message_id = $this->Message->insert($message);
							echo "MODE B was used. A message will be sent...\n<br>";
						} else {
							echo "MODE B | NORMAL_IN/OUT so we did not send any messages\n<br>";
						}
						break;

					case 'C':
                        echo "Mode C | All card tap are sent.\n<br>";
                        $message = Message::create($messages);
                        $message_id = $message->id;
						// $message_id = $this->Message->insert($message);
						break;

					# default here is actually useless & just for completion
					# since we've checked that $sending->config
					# should not be empty.
					default:
						echo "No Mode\n<br>";
						exit();
						break;
				}
			} else {
				echo "No Mode/config was found/specified. No messages will be sent upon tapping card.\n<br>";
				exit();
			}

			# Send to $msisdn if we have a message
			if (null != $message_id) 
			{	
                $batch = (new Batch)->get_current_batch();
                $network = (new Prefix)->get_network($msisdn);
                $members = Student::select('*')
                ->join('enrollments', function($join)
                {
                    $join->on('enrollments.student_no', '=', 'students.identification_no');
                })
                ->where([
                    'students.identification_no' => $data['stud_no'],
                    'students.mobile_no' => $data['msisdn'],
                    'enrollments.batch_id' => $batch,
                    'enrollments.is_active' => 1
                ])
                ->get();
                
                // $this->Member->find_member_via_msisdn2($data['msisdn'], $data['stud_no'], $school_year);

				foreach ($members as $member) {
                    $outbox = Outbox::create([
                        'message_id' => $message_id,
                        'batch_id' => $batch,
                        'msisdn' => $msisdn,
                        'status' => 'pending',
                        'smsc' => $network,
                        'created_at' => $timestamp,
                        'created_by' => 0
                    ]);

                    $messages = (new Message)->sendItem($outbox->id, $msisdn, $network, $message->messages);

				    // $outbox = array(
				    // 	'message_id' => $message_id,
					// 	'msisdn' => $msisdn,
					// 	'status' => 'pending',
					// 	'member_id' => $member->id,
					// 	'smsc' => $this->Message->get_network($msisdn),
					// 	'is_attendance' => 1,
					// 	'schoolyear_id' => $school_year,
					// 	'created_by' => 0
			   	    // );
				    // $outbox_id = $this->Outbox->insert($outbox);
				    // $this->Message->send($outbox_id, $msisdn, $this->Message->get_network($msisdn), $body);
				    echo "Message was sent to $msisdn\n<br>";
				}
			}
		}
    }

    public function in_out_status($status)
    {
    	if( (strpos($status, 'EARLY_IN')) || (strpos($status, 'NORMAL_IN')) || (strpos($status, 'LATE_IN')) || (strpos($status, 'GENERIC')) ){
    		return 'in';
    	}
    	else if( (strpos($status, 'EARLY_OUT')) || (strpos($status, 'NORMAL_OUT')) || (strpos($status, 'LATE_OUT')) ){
    		return 'out';
    	}
    	else {
    		return 'in';
    	}
    }

    public function get_scheduled_latein($studentNo, $day)
    {
        switch ($day) {
            case 'Mon':
                $day = 'monday';
                break;
            
            case 'Tue':
                $day = 'tuesday';
                break;

            case 'Wed':
                $day = 'wednesday';
                break;

            case 'Thu':
                $day = 'thursday';
                break;
            
            case 'Fri':
                $day = 'friday';
                break;

            case 'Sat':
                $day = 'saturday';
                break;

            case 'Sun':
                $day = 'sunday';
                break;  

            default:
                $day = $day;
                break;
        }

        $query = Enrollment::select('DISTINCT(dtr_time_days.time_from)')
        ->join('schedules', function($join)
        {
            $join->on('schedules.id', '=', 'enrollments.schedule_id');
        })
        ->join('dtr_time_settings', function($join)
        {
            $join->on('schedules.id', '=', 'dtr_time_settings.schedule_id');
        })
        ->join('dtr_time_days', function($join)
        {
            $join->on('dtr_time_settings.id', '=', 'dtr_time_days.dtr_time_settings_id');
        })
        ->where([
            'enrollments.batch_id' => (new Batch)->get_current_batch(),
            'dtr_time_days.day' => $day,
            'dtr_time_settings.name' => 'LATE_IN', 
            'enrollments.student_no' => $studentNo
        ])
        ->get();

        $results = 0;
        if($query->count() > 0) {
            $results = $query->first()->time_from;
        }
        return $results; 
    }
}
