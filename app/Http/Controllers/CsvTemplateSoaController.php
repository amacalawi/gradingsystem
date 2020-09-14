<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use App\Models\SoaTemplate01;
use Session;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Http\File;
use App\Components\FlashMessages;

class CsvTemplateSoaController extends Controller
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
        $menus = $this->load_menus();
        return view('modules/components/csv-management/soa-template-01/manage')->with(compact('menus'));
    }

    public function inactive(Request $request)
    {   
        $menus = $this->load_menus();
        return view('modules/components/csv-management/soa-template-01/inactive')->with(compact('menus'));
    }

    public function all_active(Request $request)
    {
        $res = SoaTemplate01::where('is_active', 1)->orderBy('id', 'DESC')->get();

        return $res->map(function($soa_template) {
            return [
                'soa_templateID' => $soa_template->id,
                'soa_templateStudentNo' => $soa_template->identification_no,
                'soa_templateFullname' => $soa_template->firstname.' '.$soa_template->middlename.' '.$soa_template->lastname,
                'soa_templateOutstandingBalance' => $soa_template->outstanding_balance,
                'soa_templateBillingPeriod' => $soa_template->billing_period,
                'soa_templateBillingDueDate' => date('d-M-Y', strtotime($soa_template->billing_due_date)),
                'soa_templateModified' => ($soa_template->updated_at !== NULL) ? date('d-M-Y', strtotime($soa_template->updated_at)).'<br/>'. date('h:i A', strtotime($soa_template->updated_at)) : date('d-M-Y', strtotime($soa_template->created_at)).'<br/>'. date('h:i A', strtotime($soa_template->created_at))
            ];
        });
    }

    public function all_inactive(Request $request)
    {
        $res = SoaTemplate01::where('is_active', 0)->orderBy('id', 'DESC')->get();

        return $res->map(function($soa_template) {
            return [
                'soa_templateID' => $soa_template->id,
                'soa_templateStudentNo' => $soa_template->identification_no,
                'soa_templateFullname' => $soa_template->firstname.' '.$soa_template->middlename.' '.$soa_template->lastname,
                'soa_templateOutstandingBalance' => $soa_template->outstanding_balance,
                'soa_templateBillingPeriod' => $soa_template->billing_period,
                'soa_templateBillingDueDate' => date('d-M-Y', strtotime($soa_template->billing_due_date)),
                'soa_templateModified' => ($soa_template->updated_at !== NULL) ? date('d-M-Y', strtotime($soa_template->updated_at)).'<br/>'. date('h:i A', strtotime($soa_template->updated_at)) : date('d-M-Y', strtotime($soa_template->created_at)).'<br/>'. date('h:i A', strtotime($soa_template->created_at))
            ];
        });
    }

    public function add(Request $request, $id = '')
    {   
        $menus = $this->load_menus();
        $segment = request()->segment(4);
        $template = (new SoaTemplate01)->fetch($id);
        return view('modules/components/csv-management/soa-template-01/add')->with(compact('menus', 'template', 'segment'));
    }
    
    public function edit(Request $request, $id)
    {   
        $menus = $this->load_menus();
        $segment = request()->segment(4);
        $template = (new SoaTemplate01)->fetch($id);
        return view('modules/components/csv-management/soa-template-01/edit')->with(compact('menus', 'template', 'segment'));
    }
    
    public function store(Request $request)
    {    
        $timestamp = date('Y-m-d H:i:s');

        $rows = SoaTemplate01::where([
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

        $soaTemplate01 = SoaTemplate01::create([
            'identification_no' => $request->identification_no,
            'firstname' => $request->firstname,
            'middlename' => $request->middlename,
            'lastname' => $request->lastname,
            'outstanding_balance' => floatval($request->outstanding_balance),
            'billing_period' => $request->billing_period,
            'billing_due_date' => date('Y-m-d', strtotime($request->billing_due_date)),
            'created_at' => $timestamp,
            'created_by' => Auth::user()->id
        ]);

        if (!$soaTemplate01) {
            throw new NotFoundHttpException();
        }

        $data = array(
            'title' => 'Well done!',
            'text' => 'The soa_template has been successfully saved.',
            'type' => 'success',
            'class' => 'btn-brand'
        );

        echo json_encode( $data ); exit();
    }

    public function update(Request $request, $id)
    {    
        $timestamp = date('Y-m-d H:i:s');
        $soaTemplate01 = SoaTemplate01::find($id);

        if(!$soaTemplate01) {
            throw new NotFoundHttpException();
        }

        $soaTemplate01->identification_no = $request->identification_no;
        $soaTemplate01->firstname = $request->firstname;
        $soaTemplate01->middlename = $request->middlename;
        $soaTemplate01->lastname = $request->lastname;
        $soaTemplate01->outstanding_balance = floatval($request->outstanding_balance);
        $soaTemplate01->billing_period = $request->billing_period;
        $soaTemplate01->billing_due_date = date('Y-m-d', strtotime($request->billing_due_date));
        $soaTemplate01->updated_at = $timestamp;
        $soaTemplate01->updated_by = Auth::user()->id;

        if ($soaTemplate01->update()) {
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
        $timestamp = date('Y-m-d H:i:s');
        $action = $request->input('items')[0]['action'];

        if ($action == 'Remove') {
            $soa_templates = SoaTemplate01::where([
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
            $batches = SoaTemplate01::where([
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
                            $exist = SoaTemplate01::where('identification_no', $data[0])->get();
                            if ($exist->count() > 0) {

                                $soaTemplate01 = SoaTemplate01::find($exist->first()->id);
                                $soaTemplate01->identification_no = $data[0];
                                $soaTemplate01->firstname = $data[1];
                                $soaTemplate01->middlename = $data[2];
                                $soaTemplate01->lastname = $data[3];
                                $soaTemplate01->outstanding_balance = floatval($data[4]);
                                $soaTemplate01->billing_period = $data[5];
                                $soaTemplate01->billing_due_date = date('Y-m-d', strtotime($data[6]));
                                $soaTemplate01->updated_at = $timestamp;
                                $soaTemplate01->updated_by = Auth::user()->id;
                                $soaTemplate01->is_active = 1;
                                
                                if (!($soaTemplate01->update())) {
                                    throw new NotFoundHttpException();
                                }
                            } else {
                                $soaTemplate01 = SoaTemplate01::create([
                                    'identification_no' => $data[0],
                                    'firstname' => $data[1],
                                    'middlename' => $data[2],
                                    'lastname' => $data[3],
                                    'outstanding_balance' => floatval($data[4]),
                                    'billing_period' => $data[5],
                                    'billing_due_date' => date('Y-m-d', strtotime($data[6])),
                                    'created_at' => $timestamp,
                                    'created_by' => Auth::user()->id
                                ]);
                        
                                if (!$soaTemplate01) {
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
