<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use App\Models\Batch;
use Session;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Http\File;
use App\Components\FlashMessages;
use App\Helper\Helper;

class BatchesController extends Controller
{   
    use FlashMessages;
    private $models;

    public function __construct()
    {   
        date_default_timezone_set('Asia/Manila');
        $this->middleware('auth');
    }

    public function is_permitted($permission)
    {
        $privileges = explode(',', strtolower(Helper::get_privileges()));
        if (!$privileges[$permission] == 1) {
            return abort(404);
        }
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {   
        $this->is_permitted(1);
        $menus = $this->load_menus();
        return view('modules/components/schools/batches/manage')->with(compact('menus'));
    }

    public function manage(Request $request)
    {   
        $this->is_permitted(1);
        $menus = $this->load_menus();
        return view('modules/components/schools/batches/manage')->with(compact('menus'));
    }

    public function inactive(Request $request)
    {   
        $this->is_permitted(1);
        $menus = $this->load_menus();
        return view('modules/components/schools/batches/inactive')->with(compact('menus'));
    }

    public function all_active(Request $request)
    {
        $res = Batch::where('is_active', 1)->orderBy('id', 'DESC')->get();

        return $res->map(function($batch) {
            return [
                'batchID' => $batch->id,
                'batchCode' => $batch->code,
                'batchName' => $batch->name,
                'batchDescription' => $batch->description,
                'batchStart' => date('d-M-Y', strtotime($batch->date_start)),
                'batchEnd' => date('d-M-Y', strtotime($batch->date_end)),
                'batchStatus' => $batch->status,
                'batchModified' => ($batch->updated_at !== NULL) ? date('d-M-Y', strtotime($batch->updated_at)).'<br/>'. date('h:i A', strtotime($batch->updated_at)) : date('d-M-Y', strtotime($batch->created_at)).'<br/>'. date('h:i A', strtotime($batch->created_at))
            ];
        });
    }

    public function all_inactive(Request $request)
    {
        $res = Batch::where('is_active', 0)->orderBy('id', 'DESC')->get();

        return $res->map(function($batch) {
            return [
                'batchID' => $batch->id,
                'batchCode' => $batch->code,
                'batchName' => $batch->name,
                'batchDescription' => $batch->description,
                'batchStart' => date('d-M-Y', strtotime($batch->date_start)),
                'batchEnd' => date('d-M-Y', strtotime($batch->date_end)),
                'batchStatus' => $batch->status,
                'batchModified' => ($batch->updated_at !== NULL) ? date('d-M-Y', strtotime($batch->updated_at)).'<br/>'. date('h:i A', strtotime($batch->updated_at)) : date('d-M-Y', strtotime($batch->created_at)).'<br/>'. date('h:i A', strtotime($batch->created_at))
            ];
        });
    }

    public function add(Request $request, $id = '')
    {   
        $this->is_permitted(0);
        $menus = $this->load_menus();
        $flashMessage = self::messages();
        $segment = request()->segment(4);
        $batch = (new Batch)->fetch($id);
        return view('modules/components/schools/batches/add')->with(compact('menus', 'batch', 'segment'));
    }
    
    public function edit(Request $request, $id)
    {   
        $this->is_permitted(2);
        $menus = $this->load_menus();
        $flashMessage = self::messages();
        $segment = request()->segment(4);
        $batch = (new Batch)->find($id);
        return view('modules/components/schools/batches/edit')->with(compact('menus', 'batch', 'segment'));
    }
    
    public function store(Request $request)
    {    
        $this->is_permitted(0);
        $timestamp = date('Y-m-d H:i:s');

        $rows = Batch::where([
            'status' => 'Open',
            'is_active' => 1
        ])->count();

        if ($rows > 0) {
            $data = array(
                'title' => 'Oh snap!',
                'text' => 'You cannot create a batch with an existing Open status.',
                'type' => 'error',
                'class' => 'btn-danger'
            );
    
            echo json_encode( $data ); exit();

            // self::message('', 'batch', 'danger', 'la la-warning', 'Oh snap!', 'You cannot create a multiple batch with an Open status.');
            // return redirect()->route('batches.'.$request->method);
        }

        $batch = Batch::create([
            'code' => $request->code,
            'name' => $request->name,
            'description' => $request->description,
            'date_start' => date('Y-m-d', strtotime($request->date_start)),
            'date_end' => date('Y-m-d', strtotime($request->date_end)),
            'created_at' => $timestamp,
            'created_by' => Auth::user()->id
        ]);

        if (!$batch) {
            throw new NotFoundHttpException();
        }

        $data = array(
            'title' => 'Well done!',
            'text' => 'The batch has been successfully saved.',
            'type' => 'success',
            'class' => 'btn-brand'
        );

        echo json_encode( $data ); exit();

        // self::message($batch->id, 'batch', 'brand', 'la la-warning', 'Well done!', 'You have successfully saved the information.');

        // return redirect()->route('batches.'.$request->method);
    }

    public function update(Request $request, $id)
    {    
        $this->is_permitted(2);
        $timestamp = date('Y-m-d H:i:s');
        $batch = Batch::find($id);

        if(!$batch) {
            throw new NotFoundHttpException();
        }

        $batch->code = $request->code;
        $batch->name = $request->name;
        $batch->description = $request->description;
        $batch->date_start = date('Y-m-d', strtotime($request->date_start));
        $batch->date_end = date('Y-m-d', strtotime($request->date_end));
        $batch->updated_at = $timestamp;
        $batch->updated_by = Auth::user()->id;

        if ($batch->update()) {

            $data = array(
                'title' => 'Well done!',
                'text' => 'The batch has been successfully updated.',
                'type' => 'success',
                'class' => 'btn-brand'
            );

            echo json_encode( $data ); exit();

            // self::message($batch->id, 'batch', 'brand', 'la la-warning', 'Well done!', 'You have successfully saved the information.');

            // if ($request->method == 'edit') {
            //     return redirect('schools/batches/edit/'.$batch->id);
            // } else {
            //     return redirect()->route('batches.'.$request->method);
            // }
        }
    }

    public function update_status(Request $request, $id)
    {   
        $this->is_permitted(3);
        $timestamp = date('Y-m-d H:i:s');
        $action = $request->input('items')[0]['action'];

        if ($action == 'Remove') {
            $batches = Batch::where([
                'id' => $id,
            ])
            ->update([
                'updated_at' => $timestamp,
                'updated_by' => Auth::user()->id,
                'is_active' => 0
            ]);
            
            $data = array(
                'title' => 'Well done!',
                'text' => 'The batch status has been successfully removed.',
                'type' => 'success',
                'class' => 'btn-brand'
            );
    
            echo json_encode( $data ); exit();
        }
        else if ($action == 'Active') {
            $batches = Batch::where([
                'id' => $id,
            ])
            ->update([
                'updated_at' => $timestamp,
                'updated_by' => Auth::user()->id,
                'is_active' => 1
            ]);
            
            $data = array(
                'title' => 'Well done!',
                'text' => 'The batch status has been successfully activated.',
                'type' => 'success',
                'class' => 'btn-brand'
            );
    
            echo json_encode( $data ); exit();
        }    
        else if ($action == 'Current') {
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
                'status' => $request->input('items')[0]['action'],
                'updated_at' => $timestamp,
                'updated_by' => Auth::user()->id,
                'is_active' => 1
            ]);
            
            $data = array(
                'title' => 'Well done!',
                'text' => 'The batch status has been successfully changed.',
                'type' => 'success',
                'class' => 'btn-brand'
            );
    
            echo json_encode( $data ); exit();
        }
        else if ($action == 'Open') {
            $rows = Batch::where('id', '!=', $id)->where([
                'status' => 'Open',
                'is_active' => 1
            ])->count();
                
            if ($rows > 0) {
                $data = array(
                    'title' => 'Oh snap!',
                    'text' => 'Only one (Open Status) can be changed at a time.',
                    'type' => 'warning',
                    'class' => 'btn-danger'
                );
        
                echo json_encode( $data ); exit();
            } else {
                $batches = Batch::where([
                    'id' => $id,
                ])
                ->update([
                    'status' => $request->input('items')[0]['action'],
                    'updated_at' => $timestamp,
                    'updated_by' => Auth::user()->id,
                    'is_active' => 1
                ]);

                $data = array(
                    'title' => 'Well done!',
                    'text' => 'The batch status has been successfully changed.',
                    'type' => 'success',
                    'class' => 'btn-brand'
                );

                echo json_encode( $data ); exit();
            }
        }
        else {
            $rows = Batch::where('id', '!=', $id)->where([
                'status' => 'Open',
                'is_active' => 1
            ])->count();

            if ($rows == 1) {
                $batches = Batch::where('id', '!=', $id)->where([
                    'status' => 'Open',
                    'is_active' => 1
                ])
                ->update([
                    'status' => 'Current',
                    'updated_at' => $timestamp,
                    'updated_by' => Auth::user()->id,
                    'is_active' => 1
                ]);
            }

            $batches = Batch::where([
                'id' => $id,
            ])
            ->update([
                'status' => $request->input('items')[0]['action'],
                'updated_at' => $timestamp,
                'updated_by' => Auth::user()->id,
                'is_active' => 1
            ]);

            $data = array(
                'title' => 'Well done!',
                'text' => 'The batch status has been successfully changed.',
                'type' => 'success',
                'class' => 'btn-brand'
            );

            echo json_encode( $data ); exit();
        }
    }

}
