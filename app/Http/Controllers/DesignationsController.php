<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use App\Models\Designation;
use Session;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Http\File;
use App\Components\FlashMessages;

class DesignationsController extends Controller
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
        return view('modules/schools/designations/manage');
    }

    public function manage(Request $request)
    {   
        return view('modules/schools/designations/manage');
    }

    public function inactive(Request $request)
    {   
        return view('modules/schools/designations/inactive');
    }

    public function all_active(Request $request)
    {
        $res = Designation::where('is_active', 1)->orderBy('id', 'DESC')->get();

        return $res->map(function($designation) {
            return [
                'designationID' => $designation->id,
                'designationCode' => $designation->code,
                'designationName' => $designation->name,
                'designationDescription' => $designation->description,
                'designationType' => $designation->type,
                'designationModified' => ($designation->updated_at !== NULL) ? date('d-M-Y', strtotime($designation->updated_at)).'<br/>'. date('h:i A', strtotime($designation->updated_at)) : date('d-M-Y', strtotime($designation->created_at)).'<br/>'. date('h:i A', strtotime($designation->created_at))
            ];
        });
    }

    public function all_inactive(Request $request)
    {
        $res = Designation::where('is_active', 0)->orderBy('id', 'DESC')->get();

        return $res->map(function($designation) {
            return [
                'designationID' => $designation->id,
                'designationCode' => $designation->code,
                'designationName' => $designation->name,
                'designationDescription' => $designation->description,
                'designationType' => $designation->type,
                'designationModified' => ($designation->updated_at !== NULL) ? date('d-M-Y', strtotime($designation->updated_at)).'<br/>'. date('h:i A', strtotime($designation->updated_at)) : date('d-M-Y', strtotime($designation->created_at)).'<br/>'. date('h:i A', strtotime($designation->created_at))
            ];
        });
    }

    public function add(Request $request, $id = '')
    {   
        $flashMessage = self::messages();
        $segment = request()->segment(3);
        if (count($flashMessage) && $flashMessage[0]['module'] == 'designation') {
            $designation = (new designation)->fetch($flashMessage[0]['id']);
        } else {
            $designation = (new designation)->fetch($id);
        }
        $types = (new designation)->types();
        return view('modules/schools/designations/add')->with(compact('designation', 'types', 'segment', 'flashMessage'));
    }
    
    public function edit(Request $request, $id)
    {   
        $flashMessage = self::messages();
        $segment = request()->segment(3);
        $designation = (new designation)->find($id);
        $types = (new designation)->types();
        return view('modules/schools/designations/edit')->with(compact('designation', 'types', 'segment', 'flashMessage'));
    }
    
    public function store(Request $request)
    {    
        $timestamp = date('Y-m-d H:i:s');

        $rows = Designation::where([
            'code' => $request->code
        ])->count();

        if ($rows > 0) {
            $data = array(
                'title' => 'Oh snap!',
                'text' => 'You cannot create a designation with an existing code.',
                'type' => 'error',
                'class' => 'btn-danger'
            );
    
            echo json_encode( $data ); exit();
        }

        $designation = Designation::create([
            'code' => $request->code,
            'name' => $request->name,
            'description' => $request->description,
            'type' => $request->type,
            'created_at' => $timestamp,
            'created_by' => Auth::user()->id
        ]);

        if (!$designation) {
            throw new NotFoundHttpException();
        }

        $data = array(
            'title' => 'Well done!',
            'text' => 'The designation has been successfully saved.',
            'type' => 'success',
            'class' => 'btn-brand'
        );

        echo json_encode( $data ); exit();
    }

    public function update(Request $request, $id)
    {    
        $timestamp = date('Y-m-d H:i:s');
        $designation = Designation::find($id);

        if(!$designation) {
            throw new NotFoundHttpException();
        }

        $designation->code = $request->code;
        $designation->name = $request->name;
        $designation->description = $request->description;
        $designation->type = $request->type;
        $designation->updated_at = $timestamp;
        $designation->updated_by = Auth::user()->id;

        if ($designation->update()) {

            $data = array(
                'title' => 'Well done!',
                'text' => 'The designation has been successfully updated.',
                'type' => 'success',
                'class' => 'btn-brand'
            );
    
            echo json_encode( $data ); exit();
        }
    }

    public function update_status(Request $request, $id)
    {   
        $timestamp = date('Y-m-d H:i:s');
        $action = $request->input('items')[0]['action'];

        if ($action == 'Remove') {
            $designations = Designation::where([
                'id' => $id,
            ])
            ->update([
                'updated_at' => $timestamp,
                'updated_by' => Auth::user()->id,
                'is_active' => 0
            ]);
            
            $data = array(
                'title' => 'Well done!',
                'text' => 'The designation has been successfully removed.',
                'type' => 'success',
                'class' => 'btn-brand'
            );
    
            echo json_encode( $data ); exit();
        }    
        else {
            $batches = Designation::where([
                'id' => $id,
            ])
            ->update([
                'updated_at' => $timestamp,
                'updated_by' => Auth::user()->id,
                'is_active' => 1
            ]);
            
            $data = array(
                'title' => 'Well done!',
                'text' => 'The designation has been successfully activated.',
                'type' => 'success',
                'class' => 'btn-brand'
            );
    
            echo json_encode( $data ); exit();
        }   
    }

}
