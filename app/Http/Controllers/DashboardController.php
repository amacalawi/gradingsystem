<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Batch;

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
