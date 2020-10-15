<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use App\Models\GradingsheetTemplate01;
use App\Models\Level;
use App\Models\Section;
use Session;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Http\File;
use App\Components\FlashMessages;
use App\Helper\Helper;

class CsvTemplateGradingsheetController extends Controller
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
        return view('modules/components/csv-management/gradingsheet-template-01/manage')->with(compact('menus'));
    }

    public function inactive(Request $request)
    {   
        $this->is_permitted(1);
        $menus = $this->load_menus();
        return view('modules/components/csv-management/gradingsheet-template-01/inactive')->with(compact('menus'));
    }

    public function all_active(Request $request)
    {
        $res = GradingsheetTemplate01::where('is_active', 1)->orderBy('id', 'DESC')->get();

        return $res->map(function($gradingsheet_template) {
            return [
                'gradingsheet_templateID' => $gradingsheet_template->id,
                'gradingsheet_templateStudentNo' => $gradingsheet_template->identification_no,
                'gradingsheet_templateFullname' => $gradingsheet_template->firstname.' '.$gradingsheet_template->middlename.' '.$gradingsheet_template->lastname,
                'gradingsheet_templateGradeLevel' => $gradingsheet_template->grade_level,
                'gradingsheet_templateSection' => $gradingsheet_template->section,
                'gradingsheet_templateAdviser' => $gradingsheet_template->adviser,
                'gradingsheet_templateAcademicStatus' => $gradingsheet_template->academics_status,
                'gradingsheet_templateEligibility' => $gradingsheet_template->eligibility,
                'gradingsheet_templateRemarks' => $gradingsheet_template->remarks,
                'gradingsheet_templateModified' => ($gradingsheet_template->updated_at !== NULL) ? date('d-M-Y', strtotime($gradingsheet_template->updated_at)).'<br/>'. date('h:i A', strtotime($gradingsheet_template->updated_at)) : date('d-M-Y', strtotime($gradingsheet_template->created_at)).'<br/>'. date('h:i A', strtotime($gradingsheet_template->created_at))
            ];
        });
    }

    public function all_inactive(Request $request)
    {
        $res = GradingsheetTemplate01::where('is_active', 0)->orderBy('id', 'DESC')->get();

        return $res->map(function($gradingsheet_template) {
            return [
                'gradingsheet_templateID' => $gradingsheet_template->id,
                'gradingsheet_templateStudentNo' => $gradingsheet_template->identification_no,
                'gradingsheet_templateFullname' => $gradingsheet_template->firstname.' '.$gradingsheet_template->middlename.' '.$gradingsheet_template->lastname,
                'gradingsheet_templateGradeLevel' => $gradingsheet_template->grade_level,
                'gradingsheet_templateSection' => $gradingsheet_template->section,
                'gradingsheet_templateAdviser' => $gradingsheet_template->adviser,
                'gradingsheet_templateAcademicStatus' => $gradingsheet_template->academics_status,
                'gradingsheet_templateEligibility' => $gradingsheet_template->eligibility,
                'gradingsheet_templateRemarks' => $gradingsheet_template->remarks,
                'gradingsheet_templateModified' => ($gradingsheet_template->updated_at !== NULL) ? date('d-M-Y', strtotime($gradingsheet_template->updated_at)).'<br/>'. date('h:i A', strtotime($gradingsheet_template->updated_at)) : date('d-M-Y', strtotime($gradingsheet_template->created_at)).'<br/>'. date('h:i A', strtotime($gradingsheet_template->created_at))
            ];
        });
    }

    public function add(Request $request, $id = '')
    {   
        $this->is_permitted(0);
        $menus = $this->load_menus();
        $segment = request()->segment(4);
        $template = (new GradingsheetTemplate01)->fetch($id);
        $levels = (new Level)->get_all_levels_type();
        $sections = (new Section)->get_all_sections_type();
        return view('modules/components/csv-management/gradingsheet-template-01/add')->with(compact('menus', 'template', 'segment', 'levels', 'sections'));
    }
    
    public function edit(Request $request, $id)
    {   
        $this->is_permitted(2);
        $menus = $this->load_menus();
        $segment = request()->segment(4);
        $template = (new GradingsheetTemplate01)->fetch($id);
        $levels = (new Level)->get_all_levels_type();
        $sections = (new Section)->get_all_sections_type();
        return view('modules/components/csv-management/gradingsheet-template-01/edit')->with(compact('menus', 'template', 'segment', 'levels', 'sections'));
    }
    
    public function store(Request $request)
    {    
        $this->is_permitted(0);  
        $timestamp = date('Y-m-d H:i:s');

        $rows = GradingsheetTemplate01::where([
            'identification_no' => $request->identification_no
        ])->count();

        if ($rows > 0) {
            $data = array(
                'title' => 'Oh snap!',
                'text' => 'You cannot create a soa template with an id number.',
                'type' => 'error',
                'class' => 'btn-danger'
            );
    
            echo json_encode( $data ); exit();
        }

        $level = Level::find($request->grade_level);
        $section = Section::find($request->section);

        if(!$level || !$section) {
            throw new NotFoundHttpException();
        }

        $gradingTemplate01 = GradingsheetTemplate01::create([
            'identification_no' => $request->identification_no,
            'firstname' => $request->firstname,
            'middlename' => $request->middlename,
            'lastname' => $request->lastname,
            'grade_level' => $level->name,
            'section' => $section->name,
            'adviser' => $request->adviser,
            'academics_status' => $request->academics_status,
            'eligibility' => $request->eligibility,
            'remarks' => $request->remarks,
            'created_at' => $timestamp,
            'created_by' => Auth::user()->id
        ]);

        if (!$gradingTemplate01) {
            throw new NotFoundHttpException();
        }

        $data = array(
            'title' => 'Well done!',
            'text' => 'The gradingsheet_template has been successfully saved.',
            'type' => 'success',
            'class' => 'btn-brand'
        );

        echo json_encode( $data ); exit();
    }

    public function update(Request $request, $id)
    {    
        $this->is_permitted(2);
        $timestamp = date('Y-m-d H:i:s');
        $gradingTemplate01 = GradingsheetTemplate01::find($id);

        if(!$gradingTemplate01) {
            throw new NotFoundHttpException();
        }

        $level = Level::find($request->grade_level);
        $section = Section::find($request->section);

        if(!$level || !$section) {
            throw new NotFoundHttpException();
        }
        
        $gradingTemplate01->identification_no = $request->identification_no;
        $gradingTemplate01->firstname = $request->firstname;
        $gradingTemplate01->middlename = $request->middlename;
        $gradingTemplate01->lastname = $request->lastname;
        $gradingTemplate01->grade_level = $level->name;
        $gradingTemplate01->section = $section->name;
        $gradingTemplate01->adviser = $request->adviser;
        $gradingTemplate01->academics_status = $request->academics_status;
        $gradingTemplate01->eligibility = $request->eligibility;
        $gradingTemplate01->remarks = $request->remarks;
        $gradingTemplate01->updated_at = $timestamp;
        $gradingTemplate01->updated_by = Auth::user()->id;

        if ($gradingTemplate01->update()) {
            $data = array(
                'title' => 'Well done!',
                'text' => 'The soa template has been successfully updated.',
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
            $gradingsheet_templates = GradingsheetTemplate01::where([
                'id' => $id,
            ])
            ->update([
                'updated_at' => $timestamp,
                'updated_by' => Auth::user()->id,
                'is_active' => 0
            ]);
            
            $data = array(
                'title' => 'Well done!',
                'text' => 'The soa template has been successfully removed.',
                'type' => 'success',
                'class' => 'btn-brand'
            );
    
            echo json_encode( $data ); exit();
        }    
        else {
            $batches = GradingsheetTemplate01::where([
                'id' => $id,
            ])
            ->update([
                'updated_at' => $timestamp,
                'updated_by' => Auth::user()->id,
                'is_active' => 1
            ]);
            
            $data = array(
                'title' => 'Well done!',
                'text' => 'The soa template has been successfully activated.',
                'type' => 'success',
                'class' => 'btn-brand'
            );
    
            echo json_encode( $data ); exit();
        }   
    }

    public function import(Request $request)
    {   
        $this->is_permitted(0); 
        foreach($_FILES as $file)
        {   
            $row = 0; $timestamp = date('Y-m-d H:i:s'); $datas = '';
            if (($files = fopen($file['tmp_name'], "r")) !== FALSE) 
            {
                while (($data = fgetcsv($files, 3000, ",")) !== FALSE) 
                {
                    $row++; 
                    if ($row > 1) {   
                        if ($data[0] !== '') {
                            $exist = GradingsheetTemplate01::where('identification_no', $data[0])->get();
                            if ($exist->count() > 0) {

                                $gradingTemplate01 = GradingsheetTemplate01::find($exist->first()->id);
                                $gradingTemplate01->identification_no = $data[0];
                                $gradingTemplate01->firstname = $data[1];
                                $gradingTemplate01->middlename = $data[2];
                                $gradingTemplate01->lastname = $data[3];
                                $gradingTemplate01->grade_level = $data[4];
                                $gradingTemplate01->section = $data[5];
                                $gradingTemplate01->adviser = $data[6];
                                $gradingTemplate01->academics_status = $data[7];
                                $gradingTemplate01->eligibility = $data[8];
                                $gradingTemplate01->remarks = $data[9];
                                $gradingTemplate01->updated_at = $timestamp;
                                $gradingTemplate01->updated_by = Auth::user()->id;
                                $gradingTemplate01->is_active = 1;
                                
                                if (!($gradingTemplate01->update())) {
                                    throw new NotFoundHttpException();
                                }
                            } else {
                                $gradingTemplate01 = GradingsheetTemplate01::create([
                                    'identification_no' => $data[0],
                                    'firstname' => $data[1],
                                    'middlename' => $data[2],
                                    'lastname' => $data[3],
                                    'grade_level' => $data[4],
                                    'section' => $data[5],
                                    'adviser' => $data[6],
                                    'academics_status' => $data[7],
                                    'eligibility' => $data[8],
                                    'remarks' => $data[9],
                                    'created_at' => $timestamp,
                                    'created_by' => Auth::user()->id
                                ]);
                        
                                if (!$gradingTemplate01) {
                                    throw new NotFoundHttpException();
                                }  
                            }
                        }
                    } // close for if $row > 1 condition                    
                }
                fclose($files);
            }
        }

        $data = array(
            'message' => 'success'
        );

        echo json_encode( $data );

        exit();
    }
}
