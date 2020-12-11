<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Batch;
use App\Models\Enrollment;
use App\Models\Calendar;
use App\Models\Level;
use App\User;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {   
        $menus = $this->load_menus();
        return view('dashboard')->with(compact('menus'));
    }

    public function get_returned_students(Request $request)
    {
        $res = Enrollment::where([
            'batch_id' => (new Batch)->get_current_batch(),
            'is_new' => 0,
            'is_active' => 1
        ])
        ->orderBy('id', 'DESC')
        ->count();
        
        $data = array(
            'data' => $res,
            'title' => 'Well done!',
            'text' => 'The batch has been successfully saved.',
            'type' => 'success',
            'class' => 'btn-brand'
        );

        echo json_encode( $data ); exit();
    }

    public function get_new_students(Request $request)
    {
        $res = Enrollment::where([
            'batch_id' => (new Batch)->get_current_batch(),
            'is_new' => 1,
            'is_active' => 1
        ])
        ->orderBy('id', 'DESC')
        ->count();
        
        $data = array(
            'data' => $res,
            'title' => 'Well done!',
            'text' => 'The batch has been successfully saved.',
            'type' => 'success',
            'class' => 'btn-brand'
        );

        echo json_encode( $data ); exit();
    }

    public function get_active_users(Request $request)
    {
        $res = User::where([
            'is_active' => 1
        ])
        ->orderBy('id', 'DESC')
        ->count();
        
        $data = array(
            'data' => $res,
            'title' => 'Well done!',
            'text' => 'The batch has been successfully saved.',
            'type' => 'success',
            'class' => 'btn-brand'
        );

        echo json_encode( $data ); exit();
    }

    public function get_active_students_per_malefemale(Request $request)
    {   
        $res2 = Enrollment::select('*')
        ->where([
            'batch_id' => (new Batch)->get_current_batch(),
            'is_active' => 1
        ])
        ->orderBy('id', 'DESC')
        ->count();

        $res = Enrollment::selectRaw('count(*) as total, student_gender')
        ->where([
            'batch_id' => (new Batch)->get_current_batch(),
            'is_active' => 1
        ])
        ->orderBy('id', 'DESC')
        ->groupBy('student_gender')
        ->get();

        $res = $res->map(function($enroll) use ($res2) {
            return [
                'label' => $enroll->student_gender,
                'value' => number_format((($enroll->total / $res2) * 100), 0)
            ];
        });

        $data = array(
            'data' => $res,
            'title' => 'Well done!',
            'text' => 'The batch has been successfully saved.',
            'type' => 'success',
            'class' => 'btn-brand'
        );

        echo json_encode( $data ); exit();
    }

    public function get_calendar(Request $request)
    {
        $res = Calendar::select('*')
        ->where([
            'batch_id' => (new Batch)->get_current_batch(),
            'is_active' => 1
        ])
        ->orderBy('id', 'DESC')
        ->get();

        $res = $res->map(function($calendar) {
            return [
                'title' => $calendar->name,
                'start' => $calendar->start_date,
                'end' => $calendar->end_date,
                'className' => 'm-fc-event--light '.$calendar->color,
                'description' => $calendar->description
            ];
        });

        $data = array(
            'data' => $res,
            'title' => 'Well done!',
            'text' => 'The batch has been successfully saved.',
            'type' => 'success',
            'class' => 'btn-brand'
        );

        echo json_encode( $data ); exit();
    }

    public function get_active_students_per_level(Request $request)
    {
        $res = Level::select('*')
        ->where([
            'is_active' => 1
        ])
        ->orderBy('id', 'ASC')
        ->get();
        
        $res = $res->map(function($level) {
            return [
                'labels' => $level->name,
                'dataset' => Enrollment::where([
                    'level_id' => $level->id,
                    'batch_id' => (new Batch)->get_current_batch(),
                    'is_active' => 1
                ])->count()
            ];
        });

        $data = array(
            'data' => $res,
            'title' => 'Well done!',
            'text' => 'The batch has been successfully saved.',
            'type' => 'success',
            'class' => 'btn-brand'
        );

        echo json_encode( $data ); exit();
    }

    public function open_batches()
    {
        $batches1 = Batch::where(['status' => 'Open', 'is_active' => 1])->get();
        $batches2 = Batch::where(['status' => 'Current', 'is_active' => 1])->get();

        $arr1 = array();
        if ($batches1->count() > 0) {
            foreach ($batches1 as $batch) {
                $arr1[] = (object) array(
                    'id' => $batch->id,
                    'code' => strtoupper($batch->code)
                );
            }
        }

        $arr2 = array();
        if ($batches2->count() > 0) {
            foreach ($batches2 as $batch) {
                $arr2[] = (object) array(
                    'id' => $batch->id,
                    'code' => strtoupper($batch->code)
                );
            }
        }

        $data = array(
            'opened' => $arr1,
            'current' => $arr2
        );
        
        echo json_encode( $data ); exit();
    }

    public function update_current(Request $request, $id)
    {   
        $timestamp = date('Y-m-d H:i:s');

        $batches = Batch::where('id', '!=', $id)->where('status', '!=', 'Closed')
        ->update([
            'status' => 'Open',
            'updated_at' => $timestamp,
            'updated_by' => Auth::user()->id,
            'is_active' => 1
        ]);

        $batches = Batch::where([
            'id' => $id,
        ])
        ->update([
            'status' => 'Current',
            'updated_at' => $timestamp,
            'updated_by' => Auth::user()->id,
            'is_active' => 1
        ]);
        
        $data = array(
            'title' => 'Well done!',
            'text' => 'The current batch has been successfully changed.',
            'type' => 'success',
            'class' => 'btn-brand'
        );

        echo json_encode( $data ); exit();
    }
}
