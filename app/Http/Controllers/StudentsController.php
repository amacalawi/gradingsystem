<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use App\Models\Member;
use Session;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Http\File;
use App\Components\FlashMessages;

class StudentsController extends Controller
{   
    use FlashMessages;
    private $models;

    public function __construct()
    {   
        date_default_timezone_set('Asia/Manila');
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('modules/schools/batches/manage');
    }

    public function manage(Request $request)
    {   
        return view('modules/schools/batches/manage');
    }

    public function active(Request $request)
    {
        $res = Batch::orderBy('id', 'DESC')->get();

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
        $flashMessage = self::messages();
        $segment = request()->segment(3);
        $student = (count($flashMessage) && $flashMessage[0]['module'] == 'student') ? (new Member)->fetch($flashMessage[0]['id']) : (new Member)->fetch($id);
        $civils = (new Member)->marital_status();
        return view('modules/memberships/students/add')->with(compact('student', 'civils', 'segment', 'flashMessage'));
    }
    
    public function edit(Request $request, $id)
    {   
        $flashMessage = self::messages();
        $segment = request()->segment(3);
        $student = (new Member)->fetch($id);
        $civils = (new Member)->marital_status();
        return view('modules/memberships/students/edit')->with(compact('student', 'civils', 'segment', 'flashMessage'));
    }
    
    public function store(Request $request)
    {    
        $timestamp = date('Y-m-d H:i:s');

        $rows = Member::where([
            'identification_no' => $request->identification_no
        ])->count();

        if ($rows > 0) {
            self::message('', 'student', 'danger', 'la la-warning', 'Oh snap!', 'The identificatio number is already taken.');
            return redirect()->route('students.'.$request->method);
        }

        $student = Member::create([
            'members_type_id' => 1,
            'identification_no' => $request->identification_no,
            'firstname' => $request->firstname,
            'middlename' => $request->middlename,
            'lastname' => $request->lastname,
            'suffix' => $request->suffix,
            'gender' => $request->gender,
            'marital_status' => $request->marital_status,
            'birthdate' => date('Y-m-d', strtotime($request->birthdate)),
            'admitted_date' => date('Y-m-d', strtotime($request->admitted_date)),
            'is_guardian' => ($request->is_guardian !== NULL) ? 1 : 0,
            'is_sibling' => ($request->is_sibling !== NULL) ? 1 : 0,
            'created_at' => $timestamp,
            'created_by' => Auth::user()->id
        ]);

        if (!$student) {
            throw new NotFoundHttpException();
            self::message('', 'student', 'danger', 'la la-warning', 'Oh snap!', 'Something went wrong, the information were not been saved.');
            return redirect()->route('students.'.$request->method);
        }

        self::message($student->id, 'student', 'brand', 'la la-warning', 'Well done!', 'You have successfully saved the information.');

        return redirect()->route('students.'.$request->method);
    }

    public function update(Request $request, $id)
    {    
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

            self::message($batch->id, 'batch', 'brand', 'la la-warning', 'Well done!', 'You have successfully saved the information.');

            if ($request->method == 'edit') {
                return redirect('schools/batches/edit/'.$batch->id);
            } else {
                return redirect()->route('batches.'.$request->method);
            }
        }
    }

    public function update_status(Request $request, $id)
    {   
        $timestamp = date('Y-m-d H:i:s');
        $action = $request->input('items')[0]['action'];

        if ($action == 'Current') {
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
