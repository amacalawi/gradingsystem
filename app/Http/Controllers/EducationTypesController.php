<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use App\Models\EducationType;
use Session;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Http\File;
use App\Components\FlashMessages;
use App\Helper\Helper;

class EducationTypesController extends Controller
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

    public function index()
    {   
        $this->is_permitted(1);
        $menus = $this->load_menus();
        return view('modules/components/schools/education-types/manage')->with(compact('menus'));
    }

    public function manage(Request $request)
    {   
        $this->is_permitted(1);
        $menus = $this->load_menus();
        return view('modules/components/schools/education-types/manage')->with(compact('menus'));
    }

    public function inactive(Request $request)
    {   
        $this->is_permitted(1);
        $menus = $this->load_menus();
        return view('modules/components/schools/education-types/inactive')->with(compact('menus'));
    }

    public function all_active(Request $request)
    {
        $res = EducationType::where('is_active', 1)->orderBy('id', 'DESC')->get();

        return $res->map(function($educationType) {
            return [
                'educationTypeID' => $educationType->id,
                'educationTypeCode' => $educationType->code,
                'educationTypeName' => $educationType->name,
                'educationTypeDescription' => $educationType->description,
                'educationTypeModified' => ($educationType->updated_at !== NULL) ? date('d-M-Y', strtotime($educationType->updated_at)).'<br/>'. date('h:i A', strtotime($educationType->updated_at)) : date('d-M-Y', strtotime($educationType->created_at)).'<br/>'. date('h:i A', strtotime($educationType->created_at))
            ];
        });
    }

    public function all_inactive(Request $request)
    {
        $res = EducationType::where('is_active', 0)->orderBy('id', 'DESC')->get();

        return $res->map(function($educationType) {
            return [
                'educationTypeID' => $educationType->id,
                'educationTypeCode' => $educationType->code,
                'educationTypeName' => $educationType->name,
                'educationTypeDescription' => $educationType->description,
                'educationTypeModified' => ($educationType->updated_at !== NULL) ? date('d-M-Y', strtotime($educationType->updated_at)).'<br/>'. date('h:i A', strtotime($educationType->updated_at)) : date('d-M-Y', strtotime($educationType->created_at)).'<br/>'. date('h:i A', strtotime($educationType->created_at))
            ];
        });
    }

    public function add(Request $request, $id = '')
    {   
        $this->is_permitted(0);
        $menus = $this->load_menus();
        $flashMessage = self::messages();
        $segment = request()->segment(4);
        $educationType = (new EducationType)->fetch($id);
        $types = (new EducationType)->all_education_types();
        return view('modules/components/schools/education-types/add')->with(compact('menus', 'educationType', 'types', 'segment'));
    }
    
    public function edit(Request $request, $id)
    {   
        $this->is_permitted(2);
        $menus = $this->load_menus();
        $flashMessage = self::messages();
        $segment = request()->segment(4);
        $educationType = (new EducationType)->fetch($id);
        $types = (new EducationType)->all_education_types();
        return view('modules/components/schools/education-types/edit')->with(compact('menus', 'educationType', 'types', 'segment'));
    }
    
    public function store(Request $request)
    {    
        $this->is_permitted(0); 
        $timestamp = date('Y-m-d H:i:s');

        $rows = EducationType::where([
            'code' => $request->code
        ])->count();

        if ($rows > 0) {
            $data = array(
                'title' => 'Oh snap!',
                'text' => 'You cannot create a education type with an existing code.',
                'type' => 'error',
                'class' => 'btn-danger'
            );
    
            echo json_encode( $data ); exit();
        }

        $educationType = EducationType::create([
            'code' => $request->code,
            'name' => $request->name,
            'description' => $request->description,
            'created_at' => $timestamp,
            'created_by' => Auth::user()->id
        ]);

        if (!$educationType) {
            throw new NotFoundHttpException();
        }

        $data = array(
            'title' => 'Well done!',
            'text' => 'The education type has been successfully saved.',
            'type' => 'success',
            'class' => 'btn-brand'
        );

        echo json_encode( $data ); exit();
    }

    public function update(Request $request, $id)
    {    
        $this->is_permitted(2);  
        $timestamp = date('Y-m-d H:i:s');
        $educationType = EducationType::find($id);

        if(!$educationType) {
            throw new NotFoundHttpException();
        }

        $educationType->code = $request->code;
        $educationType->name = $request->name;
        $educationType->description = $request->description;
        $educationType->updated_at = $timestamp;
        $educationType->updated_by = Auth::user()->id;

        if ($educationType->update()) {

            $data = array(
                'title' => 'Well done!',
                'text' => 'The education type has been successfully updated.',
                'type' => 'success',
                'class' => 'btn-brand'
            );
    
            echo json_encode( $data ); exit();
        }
    }

    public function update_status(Request $request, $id)
    {   
        $this->is_permitted(3);
        $timestamp = date('Y-m-d H:i:s');
        $action = $request->input('items')[0]['action'];

        if ($action == 'Remove') {
            $educationTypes = EducationType::where([
                'id' => $id,
            ])
            ->update([
                'updated_at' => $timestamp,
                'updated_by' => Auth::user()->id,
                'is_active' => 0
            ]);
            
            $data = array(
                'title' => 'Well done!',
                'text' => 'The education type has been successfully removed.',
                'type' => 'success',
                'class' => 'btn-brand'
            );
    
            echo json_encode( $data ); exit();
        }    
        else {
            $batches = EducationType::where([
                'id' => $id,
            ])
            ->update([
                'updated_at' => $timestamp,
                'updated_by' => Auth::user()->id,
                'is_active' => 1
            ]);
            
            $data = array(
                'title' => 'Well done!',
                'text' => 'The education type has been successfully activated.',
                'type' => 'success',
                'class' => 'btn-brand'
            );
    
            echo json_encode( $data ); exit();
        }   
    }

}
