<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use App\Models\Quarter;
use App\Models\EducationType;
use Session;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Http\File;
use App\Components\FlashMessages;

class QuartersController extends Controller
{   
    use FlashMessages;
    private $models;

    public function __construct()
    {   
        date_default_timezone_set('Asia/Manila');
        $this->middleware('auth');
    }

    public function index()
    {
        $menus = $this->load_menus();
        return view('modules/components/schools/quarters/manage')->with(compact('menus'));
    }

    public function manage(Request $request)
    {   
        $menus = $this->load_menus();
        return view('modules/components/schools/quarters/manage')->with(compact('menus'));
    }

    public function inactive(Request $request)
    {   
        $menus = $this->load_menus();
        return view('modules/components/schools/quarters/inactive')->with(compact('menus'));
    }

    public function all_active(Request $request)
    {
        $res = Quarter::
        with([
            'edtype' =>  function($q) { 
                $q->select(['id', 'name']); 
            },
            'quarters.quarter' => function($q) { 
                $q->select(['component_id','name']); 
            },
        ])
        ->where('is_active', 1)->orderBy('id', 'DESC')->get();

        return $res->map(function($quarter) {
            return [
                'quarterID' => $quarter->id,
                'quarterCode' => $quarter->code,
                'quarterName' => $quarter->name,
                'quarterDescription' => $quarter->description,
                'quarterStart' => date('d-M-Y', strtotime($quarter->date_start)),
                'quarterEnd' => date('d-M-Y', strtotime($quarter->date_end)),
                'quarterTypeID' => $quarter->edtype->id,
                'quarterType' => $quarter->edtype->name,
                'quarterModified' => ($quarter->updated_at !== NULL) ? date('d-M-Y', strtotime($quarter->updated_at)).'<br/>'. date('h:i A', strtotime($quarter->updated_at)) : date('d-M-Y', strtotime($quarter->created_at)).'<br/>'. date('h:i A', strtotime($quarter->created_at))
            ];
        });
    }

    public function all_inactive(Request $request)
    {
        $res = Quarter::
        with([
            'edtype' =>  function($q) { 
                $q->select(['id', 'name']); 
            }
        ])
        ->where('is_active', 0)->orderBy('id', 'DESC')->get();

        return $res->map(function($quarter) {
            return [
                'quarterID' => $quarter->id,
                'quarterCode' => $quarter->code,
                'quarterName' => $quarter->name,
                'quarterDescription' => $quarter->description,
                'quarterStart' => date('d-M-Y', strtotime($quarter->date_start)),
                'quarterEnd' => date('d-M-Y', strtotime($quarter->date_end)),
                'quarterTypeID' => $quarter->edtype->id,
                'quarterType' => $quarter->edtype->name,
                'quarterModified' => ($quarter->updated_at !== NULL) ? date('d-M-Y', strtotime($quarter->updated_at)).'<br/>'. date('h:i A', strtotime($quarter->updated_at)) : date('d-M-Y', strtotime($quarter->created_at)).'<br/>'. date('h:i A', strtotime($quarter->created_at))
            ];
        });
    }

    public function add(Request $request, $id = '')
    {   
        $menus = $this->load_menus();
        $flashMessage = self::messages();
        $segment = request()->segment(4);
        $quarter = (new Quarter)->fetch($id);
        $types = (new EducationType)->all_education_types();
        return view('modules/components/schools/quarters/add')->with(compact('menus', 'quarter', 'types', 'segment'));
    }
    
    public function edit(Request $request, $id)
    {   
        $menus = $this->load_menus();
        $flashMessage = self::messages();
        $segment = request()->segment(4);
        $quarter = (new Quarter)->fetch($id);
        $types = (new EducationType)->all_education_types();
        return view('modules/components/schools/quarters/edit')->with(compact('menus', 'quarter', 'types', 'segment'));
    }
    
    public function store(Request $request)
    {    
        $timestamp = date('Y-m-d H:i:s');

        $rows = Quarter::where([
            'code' => $request->code,
            'education_type_id' => $request->education_type_id
        ])->count();

        if ($rows > 0) {
            $data = array(
                'title' => 'Oh snap!',
                'text' => 'You cannot create a quarter with an existing code.',
                'type' => 'error',
                'class' => 'btn-danger'
            );
    
            echo json_encode( $data ); exit();
        }

        $quarter = Quarter::create([
            'code' => $request->code,
            'name' => $request->name,
            'description' => $request->description,
            'education_type_id' => $request->education_type_id,
            'date_start' => date('Y-m-d', strtotime($request->date_start)),
            'date_end' => date('Y-m-d', strtotime($request->date_end)),
            'created_at' => $timestamp,
            'created_by' => Auth::user()->id
        ]);

        if (!$quarter) {
            throw new NotFoundHttpException();
        }

        $data = array(
            'title' => 'Well done!',
            'text' => 'The quarter has been successfully saved.',
            'type' => 'success',
            'class' => 'btn-brand'
        );

        echo json_encode( $data ); exit();
    }

    public function update(Request $request, $id)
    {    
        $timestamp = date('Y-m-d H:i:s');
        $quarter = Quarter::find($id);

        if(!$quarter) {
            throw new NotFoundHttpException();
        }

        $quarter->code = $request->code;
        $quarter->name = $request->name;
        $quarter->description = $request->description;
        $quarter->education_type_id = $request->education_type_id;
        $quarter->date_start = date('Y-m-d', strtotime($request->date_start));
        $quarter->date_end = date('Y-m-d', strtotime($request->date_end));
        $quarter->updated_at = $timestamp;
        $quarter->updated_by = Auth::user()->id;

        if ($quarter->update()) {

            $data = array(
                'title' => 'Well done!',
                'text' => 'The quarter has been successfully updated.',
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
            $quarters = Quarter::where([
                'id' => $id,
            ])
            ->update([
                'updated_at' => $timestamp,
                'updated_by' => Auth::user()->id,
                'is_active' => 0
            ]);
            
            $data = array(
                'title' => 'Well done!',
                'text' => 'The quarter has been successfully removed.',
                'type' => 'success',
                'class' => 'btn-brand'
            );
    
            echo json_encode( $data ); exit();
        }    
        else {
            $batches = Quarter::where([
                'id' => $id,
            ])
            ->update([
                'updated_at' => $timestamp,
                'updated_by' => Auth::user()->id,
                'is_active' => 1
            ]);
            
            $data = array(
                'title' => 'Well done!',
                'text' => 'The quarter has been successfully activated.',
                'type' => 'success',
                'class' => 'btn-brand'
            );
    
            echo json_encode( $data ); exit();
        }   
    }

}
