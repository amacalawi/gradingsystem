<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use App\Application;
use App\Applicant;
use App\Inventor;
use App\Category;
use App\AnnualFee;
use App\DauFee;
use Session;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

use Illuminate\Http\File;
class AppController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

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
        return view('modules/applications/views/manage');
    }

    public static function functionName() {
        return "Hello World!";
    }

    public function add()
    {   
        $categories = (new Category)->selectAll();
        $application = (new Application)->fetch('');
        return view('modules/applications/views/add')->with(compact('categories', 'application'));
    }

    public function edit(Request $request, $id)
    {   
        $categories = (new Category)->selectAll();
        $application = (new Application)->fetch($id);
        return view('modules/applications/views/edit')->with(compact('categories', 'application'));
    }   

    public function validate_patent_status($paper1 = '', $paper2 = '', $mailing1 = '', $mailing2 = '', $publish1 = '', $paper3 = '', $mailing3 = '', $paper4 = '', $mailing4 = '', $issuedate = '', $allowremarks = '', $completed = '')
    {   
        if ($completed == 'Yes') {
            $status = 6;
        } else if (!empty($issuedate) || !empty($allowremarks)) {
            $status = 5;
        } else if (!empty($paper3) || !empty($mailing3) || !empty($paper4) || !empty($mailing4)) {
            $status = 4;
        } else if (!empty($publish1)) {
            $status = 3;
        } else if (!empty($paper1) || !empty($paper2) || !empty($mailing1) || !empty($mailing2)) {
            $status = 2;
        } else {
            $status = 1;
        }

        return $status;
    }

    public function validate_utility_model_status($paper1 = '', $paper2 = '', $mailing1 = '', $mailing2 = '', $publish1 = '', $issuedate = '', $allowremarks = '', $completed = '')
    {   
        if ($completed == 'Yes') {
            $status = 6;
        } else if (!empty($issuedate) || !empty($allowremarks)) {
            $status = 5;
        } else if (!empty($publish1)) {
            $status = 3;
        } else if (!empty($paper1) || !empty($paper2) || !empty($mailing1) || !empty($mailing2)) {
            $status = 2;
        } else {
            $status = 1;
        }

        return $status;
    }

    public function validate_trademark_status($pubdate, $paper1, $paper2, $regdate, $completed)
    {
        if ($completed == 'Yes') {
            $status = 6;
        } else if (!empty($regdate)) {
            $status = 4;
        } else if (!empty($paper1) || !empty($paper2)) {
            $status = 3;
        } else if (!empty($pubdate)) {
            $status = 2;
        } else {
            $status = 1;
        }

        return $status;
    }

    public function validate_copyright_status($paper1 = '', $paper2 = '', $mailing1 = '', $mailing2 = '', $publish1 = '', $issuedate = '', $allowremarks = '', $completed = '')
    {   
        if ($completed == 'Yes') {
            $status = 6;
        } else if (!empty($issuedate) || !empty($allowremarks)) {
            $status = 5;
        } else if (!empty($publish1)) {
            $status = 3;
        } else if (!empty($paper1) || !empty($paper2) || !empty($mailing1) || !empty($mailing2)) {
            $status = 2;
        } else {
            $status = 1;
        }

        return $status;
    }

    public function validate_industrial_design_status($paper1 = '', $paper2 = '', $mailing1 = '', $mailing2 = '', $publish1 = '', $issuedate = '', $allowremarks = '', $completed = '')
    {   
        if ($completed == 'Yes') {
            $status = 6;
        } else if (!empty($issuedate) || !empty($allowremarks)) {
            $status = 5;
        } else if (!empty($publish1)) {
            $status = 3;
        } else if (!empty($paper1) || !empty($paper2) || !empty($mailing1) || !empty($mailing2)) {
            $status = 2;
        } else {
            $status = 1;
        }

        return $status;
    }

    public function store_applicants_inventors($applicants, $inventors, $appID, $timestamp)
    {
        if ($applicants !== NULL) {
            foreach ($applicants as $app) {
                $names = explode(' ', $app);
                $firstname = '';
                $lastname = end($names);
                $middlename = prev($names);
                $fullname = $app;

                for ($i=0; $i < (count($names) - 2); $i++) {
                    $firstname .= $names[$i].' ';
                }

                $applicant = Applicant::create([
                    'application_id' => $appID,
                    'firstname' => trim($firstname),
                    'middlename' => $middlename,
                    'lastname' => $lastname,
                    'fullname' => $fullname,
                    'created_at' => $timestamp,
                    'created_by' => Auth::user()->id
                ]);
            }
        }

        if ($inventors !== NULL) {
            foreach ($inventors as $inv) {
                $inventors = explode(' ', $inv);
                $firstname = '';
                $lastname = end($inventors);
                $middlename = prev($inventors);
                $fullname = $app;

                for ($i=0; $i < (count($inventors) - 2); $i++) {
                    $firstname .= $inventors[$i].' ';
                }

                $inventor = Inventor::create([
                    'application_id' => $appID,
                    'firstname' => trim($firstname),
                    'middlename' => $middlename,
                    'lastname' => $lastname,
                    'fullname' => $fullname,
                    'created_at' => $timestamp,
                    'created_by' => Auth::user()->id
                ]);
            }
        }

        return true;
    }

    public function update_applicants_inventors($applicants, $inventors, $appID, $timestamp)
    {   
        Applicant::where('application_id', $appID)->forceDelete();
        if ($applicants !== NULL) {
            foreach ($applicants as $app) {
                $names = explode(' ', $app);
                $firstname = '';
                $lastname = end($names);
                $middlename = prev($names);
                $fullname = $app;

                for ($i=0; $i < (count($names) - 2); $i++) {
                    $firstname .= $names[$i].' ';
                }

                $applicant = Applicant::create([
                    'application_id' => $appID,
                    'firstname' => trim($firstname),
                    'middlename' => $middlename,
                    'lastname' => $lastname,
                    'fullname' => $fullname,
                    'created_at' => $timestamp,
                    'created_by' => Auth::user()->id
                ]);
            }
        }

        Inventor::where('application_id', $appID)->forceDelete();
        if ($inventors !== NULL) {
            foreach ($inventors as $inv) {
                $names = explode(' ', $inv);
                $firstname = '';
                $lastname = end($names);
                $middlename = prev($names);
                $fullname = $inv;

                for ($i=0; $i < (count($names) - 2); $i++) {
                    $firstname .= $names[$i].' ';
                }

                $inventor = Inventor::create([
                    'application_id' => $appID,
                    'firstname' => trim($firstname),
                    'middlename' => $middlename,
                    'lastname' => $lastname,
                    'fullname' => $fullname,
                    'created_at' => $timestamp,
                    'created_by' => Auth::user()->id
                ]);
            }
        }

        return true;
    }

    public function uploads(Request $request)
    {   
        if ($request->get('id') != '') {
            $folderID = $request->get('id');
        } else {
            Storage::disk('local')->makeDirectory($request->get('files').'/'.(floatval(Application::all()->count()) + 1));
            $folderID = (floatval(Application::all()->count()) + 1);
        }

        $files = array();

        foreach($_FILES as $file)
        {   
            $filename = basename($file['name']);
            $files[] = Storage::put($request->get('files').'/'.$folderID.'/'.$filename, (string) file_get_contents($file['tmp_name']));
        }

        $data = array('files' => $files);
        echo json_encode( $data ); exit();
    }

    public function downloads(Request $request) {
        $folderID = $request->get('id');
        $filename = $request->get('filename');
        return response()->download(storage_path('app/public/uploads/'.$request->get('files').'/'.$folderID.'/'.$filename));
    }

    public function alldata(Request $request)
    {
        $res = Application::with([
            'applicants' =>  function($q) { 
                $q->select(['application_id', 'fullname']); 
            },
            'inventors' =>  function($q) { 
                $q->select(['application_id', 'fullname']); 
            }
        ])->orderBy('id', 'DESC')->groupBy('id')->get();

        return $res->map(function($app) {
            return [
                'AppID' => $app->id,
                'AppNo' => $app->application_no,
                'AppTitle' => $app->application_title,
                'Status' => $app->status_id,
                'Type' => $app->category_id,
                'AppApplicants' => $app->applicants->map(function($a) { return ' '.ucwords($a->fullname); }),
                'AppInventors' => $app->inventors->map(function($a) { return ' '.ucwords($a->fullname); }),
                'AppModified' => ($app->updated_at !== NULL) ? date('d-M-Y h:i A', strtotime($app->updated_at)) : date('d-M-Y h:i A', strtotime($app->created_at))
            ];
        });
    }

    public function patents(Request $request, $id = '')
    {
        $method = request()->segment(3);

        if ($method == 'add') {
            if ($request->session()->get('appID') !== '' && $request->session()->get('application') == 'patents') {
                $application = (new Application)->fetch($request->session()->get('appID'));
            } else {
                session()->put('appID', '');
                session()->put('application', '');
                session()->save();
                $application = (new Application)->fetch($id);
            }
            return view('modules/applications/patents/views/add')->with(compact('application'));
        } else if ($method == 'edit') {
            if ($request->session()->get('appID') !== '') { 
                session()->put('appID', '');
                session()->put('application', '');
                session()->save();
            }
            $application = (new Application)->fetch($id);
            return view('modules/applications/patents/views/edit')->with(compact('application'));
        } else if ($method == 'store') {
            if ($request->input('app_no') !== NULL) { 

                $status = $this->validate_patent_status(
                    $request->input('sub_paper_no1'), 
                    $request->input('sub_paper_no2'), 
                    $request->input('sub_mailing_date1'), 
                    $request->input('sub_mailing_date2'),
                    $request->input('publish_date'),
                    $request->input('subs_paper_no1'),
                    $request->input('subs_mailing_date1'),
                    $request->input('subs_paper_no2'),
                    $request->input('subs_mailing_date2'),
                    $request->input('issuance_date'),
                    $request->input('allow_remarks'),
                    $request->input('completed')
                );
    
                $timestamp = date('Y-m-d H:i:s');
                $application = Application::create([
                    'application_no' => $request->input('app_no'),
                    'category_id' => 1,
                    'status_id' => $status,
                    'application_filing_date' => ($request->input('app_filing_date') !== NULL) ? date('Y-m-d', strtotime($request->input('app_filing_date'))) : NULL,
                    'application_title' => ($request->input('app_title') !== NULL) ? $request->input('app_title') : NULL,
                    'application_amount' => ($request->input('app_amount') !== NULL) ? $request->input('app_amount') : NULL,
                    'application_contact_no' => ($request->input('app_contact') !== NULL) ? $request->input('app_contact') : NULL,
                    'application_address' => ($request->input('app_address') !== NULL) ? $request->input('app_address') : NULL,
                    'application_remarks' => ($request->input('app_remarks') !== NULL) ? $request->input('app_remarks') : NULL,
                    'application_file' => $request->get('file1'),

                    'fer_paper_no1' => ($request->input('sub_paper_no1') !== NULL) ? $request->input('sub_paper_no1') : NULL,
                    'fer_mailing_date1' => ($request->input('sub_mailing_date1') !== NULL) ? date('Y-m-d', strtotime($request->input('sub_mailing_date1'))) : NULL,
                    'fer_amount_file1' => ($request->input('sub_amount_file1') !== NULL) ? $request->input('sub_amount_file1') : NULL,
                    'fer_file1' => $request->get('file2'),
                    
                    'fer_yes_no' => ($request->input('fer_yes_no') == 'Yes') ? 1 : 0,
                    'fer_paper_no2' => ($request->input('sub_paper_no2') !== NULL) ? $request->input('sub_paper_no2') : NULL,
                    'fer_mailing_date2' => ($request->input('sub_mailing_date2') !== NULL) ? date('Y-m-d', strtotime($request->input('sub_mailing_date2'))) : NULL,
                    'fer_amount_file2' => ($request->input('sub_amount_file2') !== NULL) ? $request->input('sub_amount_file2') : NULL,
                    'fer_file2' => $request->get('file3'),
                    
                    'published_date' => ($request->input('pub_date') !== NULL) ? date('Y-m-d', strtotime($request->input('pub_date'))) : NULL,
                    'published_amount' => ($request->input('pub_amount') !== NULL) ? $request->input('pub_amount') : NULL,
                    'published_file' => $request->get('file4'),
                    
                    'ser_paper_no1' => ($request->input('subs_paper_no1') !== NULL) ? $request->input('subs_paper_no1') : NULL,
                    'ser_mailing_date1' => ($request->input('subs_mailing_date1') !== NULL) ? date('Y-m-d', strtotime($request->input('subs_mailing_date1'))) : NULL,
                    'ser_amount_file1' => ($request->input('subs_amount_file1') !== NULL) ? $request->input('subs_amount_file1') : NULL,
                    'ser_file1' => $request->get('file5'),

                    'ser_yes_no' => ($request->input('subsequent_checklist_form_4') == 'Yes') ? 1 : 0,
                    'ser_paper_no2' => ($request->input('subs_paper_no2') !== NULL) ? $request->input('subs_paper_no2') : NULL,
                    'ser_mailing_date2' => ($request->input('subs_mailing_date2') !== NULL) ? date('Y-m-d', strtotime($request->input('subs_mailing_date2'))) : NULL,
                    'ser_amount_file2' => ($request->input('subs_amount_file2') !== NULL) ? $request->input('subs_amount_file2') : NULL,
                    'ser_file2' => $request->get('file6'),
                    
                    
                    'issuance_date' => ($request->input('issuance_date') !== NULL) ? date('Y-m-d', strtotime($request->input('issuance_date'))) : NULL,
                    'allowance_remarks' => ($request->input('allow_remarks') !== NULL) ? $request->input('allow_remarks') : NULL,
                    'allowance_amount_file' => ($request->input('allow_amount_file') !== NULL) ? $request->input('allow_amount_file') : NULL,
                    'allowance_file' => $request->get('file7'),
                    'is_completed' => ($request->input('completed') == 'Yes') ? 1 : 0,

                    'professional_fee1' => ($request->input('professional_fee1') !== NULL) ? $request->input('professional_fee1') : NULL,
                    'professional_fee2_1' => ($request->input('professional_fee2_1') !== NULL) ? $request->input('professional_fee2_1') : NULL,
                    'professional_fee2_2' => ($request->input('professional_fee2_2') !== NULL) ? $request->input('professional_fee2_2') : NULL,
                    'professional_fee3' => ($request->input('professional_fee3') !== NULL) ? $request->input('professional_fee3') : NULL,
                    'professional_fee4_1' => ($request->input('professional_fee4_1') !== NULL) ? $request->input('professional_fee4_1') : NULL,
                    'professional_fee4_2' => ($request->input('professional_fee4_2') !== NULL) ? $request->input('professional_fee4_2') : NULL,
                    'professional_fee5' => ($request->input('professional_fee5') !== NULL) ? $request->input('professional_fee5') : NULL,
                    'created_at' => $timestamp,
                    'created_by' => Auth::user()->id
                ]);
                    
                $remove = AnnualFee::remove_active_annualfee($application->id);
                if ($remove) {
                    foreach ($request->input('annuity_identification') as $annuity) {
                        if ($annuity != '' && $annuity !== NULL) {
                            $annualfee = AnnualFee::where([
                                'application_id' => $application->id,
                                'due_date_year' => $annuity
                            ])
                            ->update([
                                'due_date' => $request->input('annuity_due_date_'. $annuity),
                                'due_date_year' => $annuity,
                                'due_date_fee' => ($request->input('annuity_fee_'. $annuity) !== NULL) ? $request->input('annuity_fee_'. $annuity) : NULL,
                                'due_date_is_paid' => ($request->input('annuity_paid_'. $annuity) !== NULL) ? $request->input('annuity_paid_'. $annuity) : 0,
                                'updated_at' => $timestamp,
                                'updated_by' => Auth::user()->id,
                                'is_active' => 1
                            ]);

                            if(!$annualfee){
                                $annuity_fee =  AnnualFee::create([
                                    'application_id' => $application->id,
                                    'due_date' => $request->input('annuity_due_date_'. $annuity),
                                    'due_date_year' => $annuity,
                                    'due_date_fee' => ($request->input('annuity_fee_'. $annuity) !== NULL) ? $request->input('annuity_fee_'. $annuity) : NULL,
                                    'due_date_is_paid' => ($request->input('annuity_paid_'. $annuity) !== NULL) ? $request->input('annuity_paid_'. $annuity) : 0,
                                    'created_at' => $timestamp,
                                    'created_by' => Auth::user()->id
                                ]);
                            }
                        }
                    }
                }

                $this->store_applicants_inventors($request->input('app_applicants'), $request->input('app_inventors'), $application->id, $timestamp);
              
                if (!$application) {
                    throw new NotFoundHttpException();
                }

                session()->put('appID', $application->id);
                session()->put('application', 'patents');
                session()->save();
    
                $data = array(
                    'id' => $application->id,
                    'message' => 'The information has been successfully saved.',
                    'type'    => 'success'
                );
                
                echo json_encode( $data ); exit();
            }
            else {
                throw new NotFoundHttpException();
            }
        } else if ($method == 'update') {

            $timestamp = date('Y-m-d H:i:s');
            $application = Application::find($id);

            if(!$application) {
                throw new NotFoundHttpException();
            }

            $status = $this->validate_patent_status(
                $request->input('sub_paper_no1'), 
                $request->input('sub_paper_no2'), 
                $request->input('sub_mailing_date1'), 
                $request->input('sub_mailing_date2'),
                $request->input('publish_date'),
                $request->input('subs_paper_no1'),
                $request->input('subs_mailing_date1'),
                $request->input('subs_paper_no2'),
                $request->input('subs_mailing_date2'),
                $request->input('issuance_date'),
                $request->input('allow_remarks'),
                $request->input('completed')
            );

            $application->application_no = $request->input('app_no');
            $application->category_id = 1;
            $application->status_id = $status;
            $application->application_filing_date = ($request->input('app_filing_date') !== NULL) ? date('Y-m-d', strtotime($request->input('app_filing_date'))) : NULL;
            $application->application_title = ($request->input('app_title') !== NULL) ? $request->input('app_title') : NULL;
            $application->application_remarks = ($request->input('app_remarks') !== NULL) ? $request->input('app_remarks') : NULL;
            $application->application_amount = ($request->input('app_amount') !== NULL) ? $request->input('app_amount') : NULL;
            $application->application_contact_no = ($request->input('app_contact') !== NULL) ? $request->input('app_contact') : NULL;
            $application->application_address = ($request->input('app_address') !== NULL) ? $request->input('app_address') : NULL;
            if ($request->get('file1') !== NULL) {
                $application->application_file = $request->get('file1');
            }

            $application->fer_paper_no1 = ($request->input('sub_paper_no1') !== NULL) ? $request->input('sub_paper_no1') : NULL;
            $application->fer_mailing_date1 = ($request->input('sub_mailing_date1') !== NULL) ? date('Y-m-d', strtotime($request->input('sub_mailing_date1'))) : NULL;
            $application->fer_amount_file1 = ($request->input('sub_amount_file1') !== NULL) ? $request->input('sub_amount_file1') : NULL;
            if ($request->get('file2') !== NULL) {
                $application->fer_file1 = $request->get('file2');
            }

            $application->fer_yes_no = ($request->input('fer_yes_no') == 'Yes') ? 1 : 0;
            $application->fer_paper_no2 = ($request->input('sub_paper_no2') !== NULL) ? $request->input('sub_paper_no2') : NULL;
            $application->fer_mailing_date2 = ($request->input('sub_mailing_date2') !== NULL) ? date('Y-m-d', strtotime($request->input('sub_mailing_date2'))) : NULL;
            $application->fer_amount_file2 = ($request->input('sub_amount_file2') !== NULL) ? $request->input('sub_amount_file2') : NULL;
            if ($request->get('file3') !== NULL) {
                $application->fer_file2 = $request->get('file3');
            }

            $application->published_date = ($request->input('pub_date') !== NULL) ? date('Y-m-d', strtotime($request->input('pub_date'))) : NULL;
            $application->published_amount = ($request->input('pub_amount') !== NULL) ? $request->input('pub_amount') : NULL;
            if ($request->get('file4') !== NULL) {
                $application->published_file = $request->get('file4');
            }

            $application->ser_paper_no1 = ($request->input('subs_paper_no1') !== NULL) ? $request->input('subs_paper_no1') : NULL;
            $application->ser_mailing_date1 = ($request->input('subs_mailing_date1') !== NULL) ? date('Y-m-d', strtotime($request->input('subs_mailing_date1'))) : NULL;
            $application->ser_amount_file1 = ($request->input('subs_amount_file1') !== NULL) ? $request->input('subs_amount_file1') : NULL;
            if ($request->get('file5') !== NULL) {
                $application->ser_file1 = $request->get('file5');
            }

            $application->ser_yes_no = ($request->input('subsequent_checklist_form_4') == 'Yes') ? 1 : 0;
            $application->ser_paper_no2 = ($request->input('subs_paper_no2') !== NULL) ? $request->input('subs_paper_no2') : NULL;
            $application->ser_mailing_date2 = ($request->input('subs_mailing_date2') !== NULL) ? date('Y-m-d', strtotime($request->input('subs_mailing_date2'))) : NULL;
            $application->ser_amount_file2 = ($request->input('subs_amount_file2') !== NULL) ? $request->input('subs_amount_file2') : NULL;
            if ($request->get('file6') !== NULL) {
                $application->ser_file2 = $request->get('file6');
            }

            $application->issuance_date = ($request->input('issuance_date') !== NULL) ? date('Y-m-d', strtotime($request->input('issuance_date'))) : NULL;
            $application->allowance_remarks = ($request->input('allow_remarks') !== NULL) ? $request->input('allow_remarks') : NULL;
            $application->allowance_amount_file = ($request->input('allow_amount_file') !== NULL) ? $request->input('allow_amount_file') : NULL;
            if ($request->get('file7') !== NULL) {
                $application->allowance_file = $request->get('file7');
            }
            $application->is_completed = ($request->input('completed') == 'Yes') ? 1 : 0;

            $application->professional_fee1 = ($request->input('professional_fee1') !== NULL) ? $request->input('professional_fee1') : NULL;
            $application->professional_fee2_1 = ($request->input('professional_fee2_1') !== NULL) ? $request->input('professional_fee2_1') : NULL;
            $application->professional_fee2_2 = ($request->input('professional_fee2_2') !== NULL) ? $request->input('professional_fee2_2') : NULL;
            $application->professional_fee3 = ($request->input('professional_fee3') !== NULL) ? $request->input('professional_fee3') : NULL;
            $application->professional_fee4_1 = ($request->input('professional_fee4_1') !== NULL) ? $request->input('professional_fee4_1') : NULL;
            $application->professional_fee4_2 = ($request->input('professional_fee4_2') !== NULL) ? $request->input('professional_fee4_2') : NULL;
            $application->professional_fee5 = ($request->input('professional_fee5') !== NULL) ? $request->input('professional_fee5') : NULL;

            $application->updated_at = $timestamp;
            $application->updated_by = Auth::user()->id;

            $remove = AnnualFee::remove_active_annualfee($application->id);
            if ($remove) {
                foreach ($request->input('annuity_identification') as $annuity) {
                    if ($annuity != '' && $annuity !== NULL) {
                        $annualfee = AnnualFee::where([
                            'application_id' => $application->id,
                            'due_date_year' => $annuity
                        ])
                        ->update([
                            'due_date' => $request->input('annuity_due_date_'. $annuity),
                            'due_date_year' => $annuity,
                            'due_date_fee' => ($request->input('annuity_fee_'. $annuity) !== NULL) ? $request->input('annuity_fee_'. $annuity) : NULL,
                            'due_date_is_paid' => ($request->input('annuity_paid_'. $annuity) !== NULL) ? $request->input('annuity_paid_'. $annuity) : 0,
                            'updated_at' => $timestamp,
                            'updated_by' => Auth::user()->id,
                            'is_active' => 1
                        ]);

                        if(!$annualfee){
                            $annuity_fee =  AnnualFee::create([
                                'application_id' => $application->id,
                                'due_date' => $request->input('annuity_due_date_'. $annuity),
                                'due_date_year' => $annuity,
                                'due_date_fee' => ($request->input('annuity_fee_'. $annuity) !== NULL) ? $request->input('annuity_fee_'. $annuity) : NULL,
                                'due_date_is_paid' => ($request->input('annuity_paid_'. $annuity) !== NULL) ? $request->input('annuity_paid_'. $annuity) : 0,
                                'created_at' => $timestamp,
                                'created_by' => Auth::user()->id
                            ]);
                        }
                    }
                }
            }

            if ($application->update()) {
                $this->update_applicants_inventors($request->input('app_applicants'), $request->input('app_inventors'), $application->id, $timestamp);

                $data = array(
                    'id' => $application->id,
                    'message' => 'The information has been successfully updated.',
                    'type'    => 'success'
                );

                echo json_encode( $data ); exit();
            }
        } else if ($method == 'all') {

            $res = Application::with([
                'applicants' =>  function($q) { 
                    $q->select(['application_id', 'fullname']); 
                },
                'inventors' =>  function($q) { 
                    $q->select(['application_id', 'fullname']); 
                }
            ])->where('category_id', '1')->orderBy('id', 'DESC')->get();
    
            return $res->map(function($app) {
                return [
                    'AppID' => $app->id,
                    'AppNo' => $app->application_no,
                    'AppTitle' => $app->application_title,
                    'Status' => $app->status_id,
                    'Type' => $app->category_id,
                    'FileDate' => ($app->application_filing_date !== NULL) ? date('d-M-Y h:i A', strtotime($app->application_filing_date)) : '',
                    'PubDate' => ($app->published_date !== NULL) ? date('d-M-Y h:i A', strtotime($app->published_date)) : '',
                    'RegDate' => ($app->registration_date !== NULL) ? date('d-M-Y h:i A', strtotime($app->registration_date)) : '',
                    'ExpDate' => ($app->application_filing_date) ? date('d-M-Y h:i A', strtotime("+20 years", strtotime($app->application_filing_date))) : '',
                    'AppApplicants' => $app->applicants->map(function($a) { return ' '.ucwords($a->fullname); }),
                    'AppInventors' => $app->inventors->map(function($a) { return ' '.ucwords($a->fullname); }),
                    'AppModified' => ($app->updated_at !== NULL) ? date('d-M-Y h:i A', strtotime($app->updated_at)) : date('d-M-Y h:i A', strtotime($app->created_at))
                ];
            });

        } else if ($method == '') {
            session()->put('appID', '');
            session()->put('application', '');
            session()->save();
            return view('modules/applications/patents/views/manage');
        }
    }

    public function trademarks(Request $request, $id = '')
    {   
        $method = request()->segment(3);

        if ($method == 'add') {
            if ($request->session()->get('appID') !== '' && $request->session()->get('application') == 'trademarks') {
                $application = (new Application)->fetch($request->session()->get('appID'));
            } else {
                session()->put('appID', '');
                session()->put('application', '');
                session()->save();
                $application = (new Application)->fetch($id);
            }
            return view('modules/applications/trademarks/views/add')->with(compact('application'));
        } else if ($method == 'edit') {
            if ($request->session()->get('appID') !== '') { 
                session()->put('appID', '');
                session()->put('application', '');
                session()->save();
            }
            $application = (new Application)->fetch($id);
            return view('modules/applications/trademarks/views/edit')->with(compact('application'));
        } else if ($method == 'store') {
            
            if ($request->input('app_no') !== NULL) { 

                $status = $this->validate_trademark_status(
                    $request->input('pub_date'),
                    $request->input('sub_paper_no1'),
                    $request->input('sub_paper_no2'),
                    $request->input('reg_date'),
                    $request->input('completed')
                );
    
                $timestamp = date('Y-m-d H:i:s');
                $application = Application::create([
                    'application_no' => $request->input('app_no'),
                    'category_id' => 3,
                    'status_id' => $status,
                    'application_filing_date' => ($request->input('app_filing_date') !== NULL) ? date('Y-m-d', strtotime($request->input('app_filing_date'))) : NULL,
                    'application_title' => ($request->input('app_title') !== NULL) ? $request->input('app_title') : NULL,
                    'application_amount' => ($request->input('app_amount') !== NULL) ? $request->input('app_amount') : NULL,
                    'application_contact_no' => ($request->input('app_contact') !== NULL) ? $request->input('app_contact') : NULL,
                    'application_address' => ($request->input('app_address') !== NULL) ? $request->input('app_address') : NULL,
                    'application_remarks' => ($request->input('app_remarks') !== NULL) ? $request->input('app_remarks') : NULL,
                    'application_file' => $request->get('file1'),
                    
                    'published_date' => ($request->input('pub_date') !== NULL) ? date('Y-m-d', strtotime($request->input('pub_date'))) : NULL,
                    'published_amount' => ($request->input('pub_amount') !== NULL) ? $request->input('pub_amount') : NULL,
                    'published_file' => $request->get('file2'),
                    
                    'fer_paper_no1' => ($request->input('sub_paper_no1') !== NULL) ? $request->input('sub_paper_no1') : NULL,
                    'fer_mailing_date1' => ($request->input('sub_mailing_date1') !== NULL) ? date('Y-m-d', strtotime($request->input('sub_mailing_date1'))) : NULL,
                    'fer_amount_file1' => ($request->input('sub_amount_file1') !== NULL) ? $request->input('sub_amount_file1') : NULL,
                    'fer_file1' => $request->get('file3'),
                    
                    'fer_yes_no' => ($request->input('fer_yes_no') == 'Yes') ? 1 : 0,
                    'fer_paper_no2' => ($request->input('sub_paper_no2') !== NULL) ? $request->input('sub_paper_no2') : NULL,
                    'fer_mailing_date2' => ($request->input('sub_mailing_date2') !== NULL) ? date('Y-m-d', strtotime($request->input('sub_mailing_date2'))) : NULL,
                    'fer_amount_file2' => ($request->input('sub_amount_file2') !== NULL) ? $request->input('sub_amount_file2') : NULL,
                    'fer_file2' => $request->get('file4'),

                    'registration_date' => ($request->input('reg_date') !== NULL) ? date('Y-m-d', strtotime($request->input('reg_date'))) : NULL,
                    'registration_amount' => ($request->input('reg_amount') !== NULL) ? $request->input('reg_amount') : NULL,
                    'registration_file' => $request->get('file5'),
                    'is_completed' => ($request->input('completed') == 'Yes') ? 1 : 0,

                    'professional_fee1' => ($request->input('professional_fee1') !== NULL) ? $request->input('professional_fee1') : NULL,
                    'professional_fee2_1' => ($request->input('professional_fee2_1') !== NULL) ? $request->input('professional_fee2_1') : NULL,
                    'professional_fee2_2' => ($request->input('professional_fee2_2') !== NULL) ? $request->input('professional_fee2_2') : NULL,
                    'professional_fee3' => ($request->input('professional_fee3') !== NULL) ? $request->input('professional_fee3') : NULL,
                    'professional_fee4_1' => ($request->input('professional_fee4_1') !== NULL) ? $request->input('professional_fee4_1') : NULL,
                    'professional_fee4_2' => ($request->input('professional_fee4_2') !== NULL) ? $request->input('professional_fee4_2') : NULL,
                    'professional_fee5' => ($request->input('professional_fee5') !== NULL) ? $request->input('professional_fee5') : NULL,

                    'created_at' => $timestamp,
                    'created_by' => Auth::user()->id
                ]);
                    
                foreach ($request->input('dau_identification') as $annuity) {
                    if ($annuity != '' && $annuity !== NULL) {

                        $renewal = $request->input('renewal_'. $annuity);
                        $daufee = DauFee::where([
                            'application_id' => $application->id,
                            'due_date_year' => $annuity,
                            'renewal' => $renewal,
                            'renewal_dau' => 0
                        ])
                        ->update([
                            'due_date' => $request->input('dau_due_date_'. $annuity),
                            'due_date_year' => $annuity,
                            'due_date_fee' => ($request->input('dau_fee_'. $annuity) !== NULL) ? $request->input('dau_fee_'. $annuity) : NULL,
                            'due_date_is_paid' => ($request->input('dau_paid_'. $annuity) !== NULL) ? $request->input('dau_paid_'. $annuity) : 0,
                            'renewal' => $renewal,
                            'renewal_dau' => 0,
                            'updated_at' => $timestamp,
                            'updated_by' => Auth::user()->id,
                            'is_active' => 1
                        ]);
                
                        if(!$daufee){
                            $daufee =  DauFee::create([
                                'application_id' => $application->id,
                                'due_date' => $request->input('dau_due_date_'. $annuity),
                                'due_date_year' => $annuity,
                                'due_date_fee' => ($request->input('dau_fee_'. $annuity) !== NULL) ? $request->input('dau_fee_'. $annuity) : NULL,
                                'due_date_is_paid' => ($request->input('dau_paid_'. $annuity) !== NULL) ? $request->input('dau_paid_'. $annuity) : 0,
                                'renewal' => $renewal,
                                'renewal_dau' => 0,
                                'created_at' => $timestamp,
                                'created_by' => Auth::user()->id
                            ]);
                        }
                    }
                }

                foreach ($request->input('renewal_dau_identification') as $annuity) {
                    if ($annuity != '' && $annuity !== NULL) {

                        $daufee = DauFee::where([
                            'application_id' => $application->id,
                            'due_date_year' => $annuity,
                            'renewal' => 0,
                            'renewal_dau' => 1,
                        ])
                        ->update([
                            'due_date' => $request->input('renewal_dau_due_date_'. $annuity),
                            'due_date_year' => $annuity,
                            'due_date_fee' => ($request->input('renewal_dau_fee_'. $annuity) !== NULL) ? $request->input('renewal_dau_fee_'. $annuity) : NULL,
                            'due_date_is_paid' => ($request->input('renewal_dau_paid_'. $annuity) !== NULL) ? $request->input('renewal_dau_paid_'. $annuity) : 0,
                            'renewal' => 0,
                            'renewal_dau' => 1,
                            'updated_at' => $timestamp,
                            'updated_by' => Auth::user()->id,
                            'is_active' => 1
                        ]);

                        if(!$daufee){
                            $daufee =  DauFee::create([
                                'application_id' => $application->id,
                                'due_date' => $request->input('renewal_dau_due_date_'. $annuity),
                                'due_date_year' => $annuity,
                                'due_date_fee' => ($request->input('renewal_dau_fee_'. $annuity) !== NULL) ? $request->input('renewal_dau_fee_'. $annuity) : NULL,
                                'due_date_is_paid' => ($request->input('renewal_dau_paid_'. $annuity) !== NULL) ? $request->input('renewal_dau_paid_'. $annuity) : 0,
                                'renewal' => 0,
                                'renewal_dau' => 1,
                                'created_at' => $timestamp,
                                'created_by' => Auth::user()->id
                            ]);
                        }
                    }
                }

                $this->store_applicants_inventors($request->input('app_applicants'), NULL, $application->id, $timestamp);
    
                if (!$application) {
                    throw new NotFoundHttpException();
                }
                
                session()->put('appID', $application->id);
                session()->put('application', 'trademarks');
                session()->save();

                $data = array(
                    'id' => $application->id,
                    'message' => 'The information has been successfully saved.',
                    'type'    => 'success'
                );
                
                echo json_encode( $data ); exit();
            }
            else {
                throw new NotFoundHttpException();
            }
        } else if ($method == 'update') {

            $timestamp = date('Y-m-d H:i:s');
            $application = Application::find($id);

            if(!$application) {
                throw new NotFoundHttpException();
            }

            $status = $this->validate_trademark_status(
                $request->input('pub_date'),
                $request->input('sub_paper_no1'),
                $request->input('sub_paper_no2'),
                $request->input('reg_date'),
                $request->input('completed')
            );
            
            $application->application_no = $request->input('app_no');
            $application->status_id = $status;
            $application->application_filing_date = ($request->input('app_filing_date') !== NULL) ? date('Y-m-d', strtotime($request->input('app_filing_date'))) : NULL;
            $application->application_title = ($request->input('app_title') !== NULL) ? $request->input('app_title') : NULL;
            $application->application_amount = ($request->input('app_amount') !== NULL) ? $request->input('app_amount') : NULL;
            $application->application_contact_no = ($request->input('app_contact') !== NULL) ? $request->input('app_contact') : NULL;
            $application->application_address = ($request->input('app_address') !== NULL) ? $request->input('app_address') : NULL;
            $application->application_remarks = ($request->input('app_remarks') !== NULL) ? $request->input('app_remarks') : NULL;
            if ($request->get('file1') !== NULL) {
                $application->application_file = $request->get('file1');
            }

            $application->published_date = ($request->input('pub_date') !== NULL) ? date('Y-m-d', strtotime($request->input('pub_date'))) : NULL;
            $application->published_amount = ($request->input('pub_amount') !== NULL) ? $request->input('pub_amount') : NULL;
            if ($request->get('file2') !== NULL) {
                $application->published_file = $request->get('file2');
            }

            $application->fer_paper_no1 = ($request->input('sub_paper_no1') !== NULL) ? $request->input('sub_paper_no1') : NULL;
            $application->fer_mailing_date1 = ($request->input('sub_mailing_date1') !== NULL) ? date('Y-m-d', strtotime($request->input('sub_mailing_date1'))) : NULL;
            $application->fer_amount_file1 = ($request->input('sub_amount_file1') !== NULL) ? $request->input('sub_amount_file1') : NULL;
            if ($request->get('file3') !== NULL) {
                $application->fer_file1 = $request->get('file3');
            }

            $application->fer_yes_no = ($request->input('fer_yes_no') == 'Yes') ? 1 : 0;
            $application->fer_paper_no2 = ($request->input('sub_paper_no2') !== NULL) ? $request->input('sub_paper_no2') : NULL;
            $application->fer_mailing_date2 = ($request->input('sub_mailing_date2') !== NULL) ? date('Y-m-d', strtotime($request->input('sub_mailing_date2'))) : NULL;
            $application->fer_amount_file2 = ($request->input('sub_amount_file2') !== NULL) ? $request->input('sub_amount_file2') : NULL;
            if ($request->get('file4') !== NULL) {
                $application->fer_file2 = $request->get('file4');
            }

            $application->registration_date = ($request->input('reg_date') !== NULL) ? date('Y-m-d', strtotime($request->input('reg_date'))) : NULL;
            $application->registration_amount = ($request->input('reg_amount') !== NULL) ? $request->input('reg_amount') : NULL;
            if ($request->get('file5') !== NULL) {
                $application->registration_file = $request->get('file5');
            }

            $application->is_completed = ($request->input('completed') == 'Yes') ? 1 : 0;
            $application->updated_at = $timestamp;
            $application->updated_by = Auth::user()->id;

            $remove = DauFee::remove_active_dau($application->id);
            if ($remove) {
                foreach ($request->input('dau_identification') as $annuity) {
                    if ($annuity != '' && $annuity !== NULL) {

                        $renewal = $request->input('renewal_'. $annuity);
                        $daufee = DauFee::where([
                            'application_id' => $application->id,
                            'due_date_year' => $annuity,
                            'renewal' => $renewal,
                            'renewal_dau' => 0
                        ])
                        ->update([
                            'due_date' => $request->input('dau_due_date_'. $annuity),
                            'due_date_year' => $annuity,
                            'due_date_fee' => ($request->input('dau_fee_'. $annuity) !== NULL) ? $request->input('dau_fee_'. $annuity) : NULL,
                            'due_date_is_paid' => ($request->input('dau_paid_'. $annuity) !== NULL) ? $request->input('dau_paid_'. $annuity) : 0,
                            'renewal' => $renewal,
                            'renewal_dau' => 0,
                            'updated_at' => $timestamp,
                            'updated_by' => Auth::user()->id,
                            'is_active' => 1
                        ]);
                
                        if(!$daufee){
                            $daufee =  DauFee::create([
                                'application_id' => $application->id,
                                'due_date' => $request->input('dau_due_date_'. $annuity),
                                'due_date_year' => $annuity,
                                'due_date_fee' => ($request->input('dau_fee_'. $annuity) !== NULL) ? $request->input('dau_fee_'. $annuity) : NULL,
                                'due_date_is_paid' => ($request->input('dau_paid_'. $annuity) !== NULL) ? $request->input('dau_paid_'. $annuity) : 0,
                                'renewal' => $renewal,
                                'renewal_dau' => 0,
                                'created_at' => $timestamp,
                                'created_by' => Auth::user()->id
                            ]);
                        }
                    }
                }

                foreach ($request->input('renewal_dau_identification') as $annuity) {
                    if ($annuity != '' && $annuity !== NULL) {

                        $daufee = DauFee::where([
                            'application_id' => $application->id,
                            'due_date_year' => $annuity,
                            'renewal' => 0,
                            'renewal_dau' => 1,
                        ])
                        ->update([
                            'due_date' => $request->input('renewal_dau_due_date_'. $annuity),
                            'due_date_year' => $annuity,
                            'due_date_fee' => ($request->input('renewal_dau_fee_'. $annuity) !== NULL) ? $request->input('renewal_dau_fee_'. $annuity) : NULL,
                            'due_date_is_paid' => ($request->input('renewal_dau_paid_'. $annuity) !== NULL) ? $request->input('renewal_dau_paid_'. $annuity) : 0,
                            'renewal' => 0,
                            'renewal_dau' => 1,
                            'updated_at' => $timestamp,
                            'updated_by' => Auth::user()->id,
                            'is_active' => 1
                        ]);

                        if(!$daufee){
                            $daufee =  DauFee::create([
                                'application_id' => $application->id,
                                'due_date' => $request->input('renewal_dau_due_date_'. $annuity),
                                'due_date_year' => $annuity,
                                'due_date_fee' => ($request->input('renewal_dau_fee_'. $annuity) !== NULL) ? $request->input('renewal_dau_fee_'. $annuity) : NULL,
                                'due_date_is_paid' => ($request->input('renewal_dau_paid_'. $annuity) !== NULL) ? $request->input('renewal_dau_paid_'. $annuity) : 0,
                                'renewal' => 0,
                                'renewal_dau' => 1,
                                'created_at' => $timestamp,
                                'created_by' => Auth::user()->id
                            ]);
                        }
                    }
                }
            }

            if ($application->update()) {
                $this->update_applicants_inventors($request->input('app_applicants'), NULL, $application->id, $timestamp);

                $data = array(
                    'id' => $request->input('publish_date'),
                    'message' => 'The information has been successfully updated.',
                    'type'    => 'success'
                );

                echo json_encode( $data ); exit();
            }
        } else if ($method == 'all') {

            $res = Application::with([
                'applicants' =>  function($q) { 
                    $q->select(['application_id', 'fullname']); 
                },
                'inventors' =>  function($q) { 
                    $q->select(['application_id', 'fullname']); 
                }
            ])->where('category_id', '3')->orderBy('id', 'DESC')->groupBy('id')->get();
    
            return $res->map(function($app) {
                return [
                    'AppID' => $app->id,
                    'AppNo' => $app->application_no,
                    'AppTitle' => $app->application_title,
                    'Status' => $app->status_id,
                    'Type' => $app->category_id,
                    'FileDate' => ($app->application_filing_date !== NULL) ? date('d-M-Y h:i A', strtotime($app->application_filing_date)) : '',
                    'PubDate' => ($app->published_date !== NULL) ? date('d-M-Y h:i A', strtotime($app->published_date)) : '',
                    'RegDate' => ($app->registration_date !== NULL) ? date('d-M-Y h:i A', strtotime($app->registration_date)) : '',
                    'AppApplicants' => $app->applicants->map(function($a) { return ' '.ucwords($a->fullname); }),
                    'AppInventors' => $app->inventors->map(function($a) { return ' '.ucwords($a->fullname); }),
                    'AppModified' => ($app->updated_at !== NULL) ? date('d-M-Y h:i A', strtotime($app->updated_at)) : date('d-M-Y h:i A', strtotime($app->created_at))
                ];
            });

        } else if ($method == '') {
            session()->put('appID', '');
            session()->put('application', '');
            session()->save();
            return view('modules/applications/trademarks/views/manage');
        }
    }

    public function utility_models(Request $request, $id = '')
    {
        $method = request()->segment(3);

        if ($method == 'add') {
            if ($request->session()->get('appID') !== '') {
                return redirect('applications/utility-models/edit/'.$request->session()->get('appID'));
            } else {
                $application = (new Application)->fetch($id);
            }
            return view('modules/applications/utility-models/views/add')->with(compact('application'));
        } else if ($method == 'edit') {
            if ($request->session()->get('appID') !== '') { 
                session()->put('appID', '');
                session()->save();
            }
            $application = (new Application)->fetch($id);
            return view('modules/applications/utility-models/views/edit')->with(compact('application'));
        } else if ($method == 'store') {
            if ($request->input('app_no') !== NULL) { 

                $status = $this->validate_utility_model_status(
                    $request->input('sub_paper_no1'), 
                    $request->input('sub_paper_no2'), 
                    $request->input('sub_mailing_date1'), 
                    $request->input('sub_mailing_date2'),
                    $request->input('publish_date'),
                    $request->input('issuance_date'),
                    $request->input('allow_remarks'),
                    $request->input('completed')
                );
    
                $timestamp = date('Y-m-d H:i:s');
                $application = Application::create([
                    'application_no' => $request->input('app_no'),
                    'category_id' => 2,
                    'status_id' => $status,
                    'application_filing_date' => ($request->input('app_filing_date') !== NULL) ? date('Y-m-d', strtotime($request->input('app_filing_date'))) : NULL,
                    'application_title' => ($request->input('app_title') !== NULL) ? $request->input('app_title') : NULL,
                    'application_amount' => ($request->input('app_amount') !== NULL) ? $request->input('app_amount') : NULL,
                    'application_contact_no' => ($request->input('app_contact') !== NULL) ? $request->input('app_contact') : NULL,
                    'application_address' => ($request->input('app_address') !== NULL) ? $request->input('app_address') : NULL,
                    'application_remarks' => ($request->input('app_remarks') !== NULL) ? $request->input('app_remarks') : NULL,
                    'application_file' => $request->get('file1'),

                    'fer_paper_no1' => ($request->input('sub_paper_no1') !== NULL) ? $request->input('sub_paper_no1') : NULL,
                    'fer_mailing_date1' => ($request->input('sub_mailing_date1') !== NULL) ? date('Y-m-d', strtotime($request->input('sub_mailing_date1'))) : NULL,
                    'fer_amount_file1' => ($request->input('sub_amount_file1') !== NULL) ? $request->input('sub_amount_file1') : NULL,
                    'fer_file1' => $request->get('file2'),
                    
                    'fer_yes_no' => ($request->input('fer_yes_no') == 'Yes') ? 1 : 0,
                    'fer_paper_no2' => ($request->input('sub_paper_no2') !== NULL) ? $request->input('sub_paper_no2') : NULL,
                    'fer_mailing_date2' => ($request->input('sub_mailing_date2') !== NULL) ? date('Y-m-d', strtotime($request->input('sub_mailing_date2'))) : NULL,
                    'fer_amount_file2' => ($request->input('sub_amount_file2') !== NULL) ? $request->input('sub_amount_file2') : NULL,
                    'fer_file2' => $request->get('file3'),
                    
                    'published_date' => ($request->input('pub_date') !== NULL) ? date('Y-m-d', strtotime($request->input('pub_date'))) : NULL,
                    'published_amount' => ($request->input('pub_amount') !== NULL) ? $request->input('pub_amount') : NULL,
                    'published_file' => $request->get('file4'),
                    
                    'issuance_date' => ($request->input('issuance_date') !== NULL) ? date('Y-m-d', strtotime($request->input('issuance_date'))) : NULL,
                    'allowance_remarks' => ($request->input('allow_remarks') !== NULL) ? $request->input('allow_remarks') : NULL,
                    'allowance_amount_file' => ($request->input('allow_amount_file') !== NULL) ? $request->input('allow_amount_file') : NULL,
                    'allowance_file' => $request->get('file7'),
                    'is_completed' => ($request->input('completed') == 'Yes') ? 1 : 0,

                    'professional_fee1' => ($request->input('professional_fee1') !== NULL) ? $request->input('professional_fee1') : NULL,
                    'professional_fee2_1' => ($request->input('professional_fee2_1') !== NULL) ? $request->input('professional_fee2_1') : NULL,
                    'professional_fee2_2' => ($request->input('professional_fee2_2') !== NULL) ? $request->input('professional_fee2_2') : NULL,
                    'professional_fee3' => ($request->input('professional_fee3') !== NULL) ? $request->input('professional_fee3') : NULL,
                    'professional_fee4_1' => ($request->input('professional_fee4_1') !== NULL) ? $request->input('professional_fee4_1') : NULL,
                    'professional_fee4_2' => ($request->input('professional_fee4_2') !== NULL) ? $request->input('professional_fee4_2') : NULL,
                    'professional_fee5' => ($request->input('professional_fee5') !== NULL) ? $request->input('professional_fee5') : NULL,
                    'created_at' => $timestamp,
                    'created_by' => Auth::user()->id
                ]);
    
                $this->store_applicants_inventors($request->input('app_applicants'), $request->input('app_inventors'), $application->id, $timestamp);
    
                if (!$application) {
                    throw new NotFoundHttpException();
                }
                
                session()->put('appID', $application->id);
                session()->save();
    
                $data = array(
                    'id' => $application->id,
                    'message' => 'The information has been successfully saved.',
                    'type'    => 'success'
                );
                
                echo json_encode( $data ); exit();
            }
            else {
                throw new NotFoundHttpException();
            }
        } else if ($method == 'update') {

            $timestamp = date('Y-m-d H:i:s');
            $application = Application::find($id);

            if(!$application) {
                throw new NotFoundHttpException();
            }

            $status = $this->validate_utility_model_status(
                $request->input('sub_paper_no1'), 
                $request->input('sub_paper_no2'), 
                $request->input('sub_mailing_date1'), 
                $request->input('sub_mailing_date2'),
                $request->input('publish_date'),
                $request->input('issuance_date'),
                $request->input('allow_remarks'),
                $request->input('completed')
            );

            $application->application_no = $request->input('app_no');
            $application->category_id = 2;
            $application->status_id = $status;
            $application->application_filing_date = ($request->input('app_filing_date') !== NULL) ? date('Y-m-d', strtotime($request->input('app_filing_date'))) : NULL;
            $application->application_title = ($request->input('app_title') !== NULL) ? $request->input('app_title') : NULL;
            $application->application_remarks = ($request->input('app_remarks') !== NULL) ? $request->input('app_remarks') : NULL;
            $application->application_amount = ($request->input('app_amount') !== NULL) ? $request->input('app_amount') : NULL;
            $application->application_contact_no = ($request->input('app_contact') !== NULL) ? $request->input('app_contact') : NULL;
            $application->application_address = ($request->input('app_address') !== NULL) ? $request->input('app_address') : NULL;
            if ($request->get('file1') !== NULL) {
                $application->application_file = $request->get('file1');
            }

            $application->fer_paper_no1 = ($request->input('sub_paper_no1') !== NULL) ? $request->input('sub_paper_no1') : NULL;
            $application->fer_mailing_date1 = ($request->input('sub_mailing_date1') !== NULL) ? date('Y-m-d', strtotime($request->input('sub_mailing_date1'))) : NULL;
            $application->fer_amount_file1 = ($request->input('sub_amount_file1') !== NULL) ? $request->input('sub_amount_file1') : NULL;
            if ($request->get('file2') !== NULL) {
                $application->fer_file1 = $request->get('file2');
            }

            $application->fer_yes_no = ($request->input('fer_yes_no') == 'Yes') ? 1 : 0;
            $application->fer_paper_no2 = ($request->input('sub_paper_no2') !== NULL) ? $request->input('sub_paper_no2') : NULL;
            $application->fer_mailing_date2 = ($request->input('sub_mailing_date2') !== NULL) ? date('Y-m-d', strtotime($request->input('sub_mailing_date2'))) : NULL;
            $application->fer_amount_file2 = ($request->input('sub_amount_file2') !== NULL) ? $request->input('sub_amount_file2') : NULL;
            if ($request->get('file3') !== NULL) {
                $application->fer_file2 = $request->get('file3');
            }

            $application->published_date = ($request->input('pub_date') !== NULL) ? date('Y-m-d', strtotime($request->input('pub_date'))) : NULL;
            $application->published_amount = ($request->input('pub_amount') !== NULL) ? $request->input('pub_amount') : NULL;
            if ($request->get('file4') !== NULL) {
                $application->published_file = $request->get('file4');
            }

            $application->issuance_date = ($request->input('issuance_date') !== NULL) ? date('Y-m-d', strtotime($request->input('issuance_date'))) : NULL;
            $application->allowance_remarks = ($request->input('allow_remarks') !== NULL) ? $request->input('allow_remarks') : NULL;
            $application->allowance_amount_file = ($request->input('allow_amount_file') !== NULL) ? $request->input('allow_amount_file') : NULL;
            if ($request->get('file7') !== NULL) {
                $application->allowance_file = $request->get('file7');
            }
            $application->is_completed = ($request->input('completed') == 'Yes') ? 1 : 0;

            $application->professional_fee1 = ($request->input('professional_fee1') !== NULL) ? $request->input('professional_fee1') : NULL;
            $application->professional_fee2_1 = ($request->input('professional_fee2_1') !== NULL) ? $request->input('professional_fee2_1') : NULL;
            $application->professional_fee2_2 = ($request->input('professional_fee2_2') !== NULL) ? $request->input('professional_fee2_2') : NULL;
            $application->professional_fee3 = ($request->input('professional_fee3') !== NULL) ? $request->input('professional_fee3') : NULL;
            $application->professional_fee4_1 = ($request->input('professional_fee4_1') !== NULL) ? $request->input('professional_fee4_1') : NULL;
            $application->professional_fee4_2 = ($request->input('professional_fee4_2') !== NULL) ? $request->input('professional_fee4_2') : NULL;
            $application->professional_fee5 = ($request->input('professional_fee5') !== NULL) ? $request->input('professional_fee5') : NULL;

            $application->updated_at = $timestamp;
            $application->updated_by = Auth::user()->id;

            if ($application->update()) {
                $this->update_applicants_inventors($request->input('app_applicants'), $request->input('app_inventors'), $application->id, $timestamp);

                $data = array(
                    'id' => $application->id,
                    'message' => 'The information has been successfully updated.',
                    'type'    => 'success'
                );

                echo json_encode( $data ); exit();
            }
        } else if ($method == 'all') {

            $res = Application::with([
                'applicants' =>  function($q) { 
                    $q->select(['application_id', 'fullname']); 
                },
                'inventors' =>  function($q) { 
                    $q->select(['application_id', 'fullname']); 
                }
            ])->where('category_id', '2')->orderBy('id', 'DESC')->groupBy('id')->get();
    
            return $res->map(function($app) {
                $filing_date = ($app->application_filing_date !== NULL) ? date('d-M-Y h:i A', strtotime($app->application_filing_date)) : '';
                $expiration_date = ($app->application_filing_date) ? date('d-M-Y h:i A', strtotime("+7 years", strtotime($app->application_filing_date))) : '';
                return [
                    'AppID' => $app->id,
                    'AppNo' => $app->application_no,
                    'AppTitle' => $app->application_title,
                    'Status' => $app->status_id,
                    'Type' => $app->category_id,
                    'FileDate' => $filing_date ? $filing_date.' / '.$expiration_date : '',
                    'PubDate' => ($app->published_date !== NULL) ? date('d-M-Y h:i A', strtotime($app->published_date)) : '',
                    'IssueDate' => ($app->issuance_date !== NULL) ? date('d-M-Y h:i A', strtotime($app->issuance_date)) : '',
                    'RegDate' => ($app->registration_date !== NULL) ? date('d-M-Y h:i A', strtotime($app->registration_date)) : '',
                    'AppApplicants' => $app->applicants->map(function($a) { return ' '.ucwords($a->fullname); }),
                    'AppInventors' => $app->inventors->map(function($a) { return ' '.ucwords($a->fullname); }),
                    'AppModified' => ($app->updated_at !== NULL) ? date('d-M-Y h:i A', strtotime($app->updated_at)) : date('d-M-Y h:i A', strtotime($app->created_at))
                ];
            });

        } else if ($method == '') {
            session()->put('appID', '');
            session()->save();
            return view('modules/applications/utility-models/views/manage');
        }
    }

    public function copyrights(Request $request, $id = '')
    {
        $method = request()->segment(3);

        if ($method == 'add') {
            if ($request->session()->get('appID') !== '') {
                return redirect('applications/copyrights/edit/'.$request->session()->get('appID'));
            } else {
                $application = (new Application)->fetch($id);
            }
            return view('modules/applications/copyrights/views/add')->with(compact('application'));
        } else if ($method == 'edit') {
            if ($request->session()->get('appID') !== '') { 
                session()->put('appID', '');
                session()->save();
            }
            $application = (new Application)->fetch($id);
            return view('modules/applications/copyrights/views/edit')->with(compact('application'));
        } else if ($method == 'store') {
            if ($request->input('app_no') !== NULL) { 

                $status = $this->validate_copyright_status(
                    $request->input('sub_paper_no1'), 
                    $request->input('sub_paper_no2'), 
                    $request->input('sub_mailing_date1'), 
                    $request->input('sub_mailing_date2'),
                    $request->input('publish_date'),
                    $request->input('issuance_date'),
                    $request->input('allow_remarks'),
                    $request->input('completed')
                );
    
                $timestamp = date('Y-m-d H:i:s');
                $application = Application::create([
                    'application_no' => $request->input('app_no'),
                    'category_id' => 4,
                    'status_id' => $status,
                    'application_filing_date' => ($request->input('app_filing_date') !== NULL) ? date('Y-m-d', strtotime($request->input('app_filing_date'))) : NULL,
                    'application_title' => ($request->input('app_title') !== NULL) ? $request->input('app_title') : NULL,
                    'application_amount' => ($request->input('app_amount') !== NULL) ? $request->input('app_amount') : NULL,
                    'application_contact_no' => ($request->input('app_contact') !== NULL) ? $request->input('app_contact') : NULL,
                    'application_address' => ($request->input('app_address') !== NULL) ? $request->input('app_address') : NULL,
                    'application_remarks' => ($request->input('app_remarks') !== NULL) ? $request->input('app_remarks') : NULL,
                    'application_file' => $request->get('file1'),

                    'fer_paper_no1' => ($request->input('sub_paper_no1') !== NULL) ? $request->input('sub_paper_no1') : NULL,
                    'fer_mailing_date1' => ($request->input('sub_mailing_date1') !== NULL) ? date('Y-m-d', strtotime($request->input('sub_mailing_date1'))) : NULL,
                    'fer_amount_file1' => ($request->input('sub_amount_file1') !== NULL) ? $request->input('sub_amount_file1') : NULL,
                    'fer_file1' => $request->get('file2'),
                    
                    'fer_yes_no' => ($request->input('fer_yes_no') == 'Yes') ? 1 : 0,
                    'fer_paper_no2' => ($request->input('sub_paper_no2') !== NULL) ? $request->input('sub_paper_no2') : NULL,
                    'fer_mailing_date2' => ($request->input('sub_mailing_date2') !== NULL) ? date('Y-m-d', strtotime($request->input('sub_mailing_date2'))) : NULL,
                    'fer_amount_file2' => ($request->input('sub_amount_file2') !== NULL) ? $request->input('sub_amount_file2') : NULL,
                    'fer_file2' => $request->get('file3'),
                    
                    'published_date' => ($request->input('pub_date') !== NULL) ? date('Y-m-d', strtotime($request->input('pub_date'))) : NULL,
                    'published_amount' => ($request->input('pub_amount') !== NULL) ? $request->input('pub_amount') : NULL,
                    'published_file' => $request->get('file4'),
                    
                    'issuance_date' => ($request->input('issuance_date') !== NULL) ? date('Y-m-d', strtotime($request->input('issuance_date'))) : NULL,
                    'allowance_remarks' => ($request->input('allow_remarks') !== NULL) ? $request->input('allow_remarks') : NULL,
                    'allowance_amount_file' => ($request->input('allow_amount_file') !== NULL) ? $request->input('allow_amount_file') : NULL,
                    'allowance_file' => $request->get('file7'),
                    'is_completed' => ($request->input('completed') == 'Yes') ? 1 : 0,

                    'professional_fee1' => ($request->input('professional_fee1') !== NULL) ? $request->input('professional_fee1') : NULL,
                    'professional_fee2_1' => ($request->input('professional_fee2_1') !== NULL) ? $request->input('professional_fee2_1') : NULL,
                    'professional_fee2_2' => ($request->input('professional_fee2_2') !== NULL) ? $request->input('professional_fee2_2') : NULL,
                    'professional_fee3' => ($request->input('professional_fee3') !== NULL) ? $request->input('professional_fee3') : NULL,
                    'professional_fee4_1' => ($request->input('professional_fee4_1') !== NULL) ? $request->input('professional_fee4_1') : NULL,
                    'professional_fee4_2' => ($request->input('professional_fee4_2') !== NULL) ? $request->input('professional_fee4_2') : NULL,
                    'professional_fee5' => ($request->input('professional_fee5') !== NULL) ? $request->input('professional_fee5') : NULL,
                    'created_at' => $timestamp,
                    'created_by' => Auth::user()->id
                ]);
    
                $this->store_applicants_inventors($request->input('app_applicants'), $request->input('app_inventors'), $application->id, $timestamp);
    
                if (!$application) {
                    throw new NotFoundHttpException();
                }
                
                session()->put('appID', $application->id);
                session()->save();
    
                $data = array(
                    'id' => $application->id,
                    'message' => 'The information has been successfully saved.',
                    'type'    => 'success'
                );
                
                echo json_encode( $data ); exit();
            }
            else {
                throw new NotFoundHttpException();
            }
        } else if ($method == 'update') {

            $timestamp = date('Y-m-d H:i:s');
            $application = Application::find($id);

            if(!$application) {
                throw new NotFoundHttpException();
            }

            $status = $this->validate_copyright_status(
                $request->input('sub_paper_no1'), 
                $request->input('sub_paper_no2'), 
                $request->input('sub_mailing_date1'), 
                $request->input('sub_mailing_date2'),
                $request->input('publish_date'),
                $request->input('issuance_date'),
                $request->input('allow_remarks'),
                $request->input('completed')
            );

            $application->application_no = $request->input('app_no');
            $application->category_id = 4;
            $application->status_id = $status;
            $application->application_filing_date = ($request->input('app_filing_date') !== NULL) ? date('Y-m-d', strtotime($request->input('app_filing_date'))) : NULL;
            $application->application_title = ($request->input('app_title') !== NULL) ? $request->input('app_title') : NULL;
            $application->application_remarks = ($request->input('app_remarks') !== NULL) ? $request->input('app_remarks') : NULL;
            $application->application_amount = ($request->input('app_amount') !== NULL) ? $request->input('app_amount') : NULL;
            $application->application_contact_no = ($request->input('app_contact') !== NULL) ? $request->input('app_contact') : NULL;
            $application->application_address = ($request->input('app_address') !== NULL) ? $request->input('app_address') : NULL;
            if ($request->get('file1') !== NULL) {
                $application->application_file = $request->get('file1');
            }

            $application->fer_paper_no1 = ($request->input('sub_paper_no1') !== NULL) ? $request->input('sub_paper_no1') : NULL;
            $application->fer_mailing_date1 = ($request->input('sub_mailing_date1') !== NULL) ? date('Y-m-d', strtotime($request->input('sub_mailing_date1'))) : NULL;
            $application->fer_amount_file1 = ($request->input('sub_amount_file1') !== NULL) ? $request->input('sub_amount_file1') : NULL;
            if ($request->get('file2') !== NULL) {
                $application->fer_file1 = $request->get('file2');
            }

            $application->fer_yes_no = ($request->input('fer_yes_no') == 'Yes') ? 1 : 0;
            $application->fer_paper_no2 = ($request->input('sub_paper_no2') !== NULL) ? $request->input('sub_paper_no2') : NULL;
            $application->fer_mailing_date2 = ($request->input('sub_mailing_date2') !== NULL) ? date('Y-m-d', strtotime($request->input('sub_mailing_date2'))) : NULL;
            $application->fer_amount_file2 = ($request->input('sub_amount_file2') !== NULL) ? $request->input('sub_amount_file2') : NULL;
            if ($request->get('file3') !== NULL) {
                $application->fer_file2 = $request->get('file3');
            }

            $application->published_date = ($request->input('pub_date') !== NULL) ? date('Y-m-d', strtotime($request->input('pub_date'))) : NULL;
            $application->published_amount = ($request->input('pub_amount') !== NULL) ? $request->input('pub_amount') : NULL;
            if ($request->get('file4') !== NULL) {
                $application->published_file = $request->get('file4');
            }

            $application->issuance_date = ($request->input('issuance_date') !== NULL) ? date('Y-m-d', strtotime($request->input('issuance_date'))) : NULL;
            $application->allowance_remarks = ($request->input('allow_remarks') !== NULL) ? $request->input('allow_remarks') : NULL;
            $application->allowance_amount_file = ($request->input('allow_amount_file') !== NULL) ? $request->input('allow_amount_file') : NULL;
            if ($request->get('file7') !== NULL) {
                $application->allowance_file = $request->get('file7');
            }
            $application->is_completed = ($request->input('completed') == 'Yes') ? 1 : 0;

            $application->professional_fee1 = ($request->input('professional_fee1') !== NULL) ? $request->input('professional_fee1') : NULL;
            $application->professional_fee2_1 = ($request->input('professional_fee2_1') !== NULL) ? $request->input('professional_fee2_1') : NULL;
            $application->professional_fee2_2 = ($request->input('professional_fee2_2') !== NULL) ? $request->input('professional_fee2_2') : NULL;
            $application->professional_fee3 = ($request->input('professional_fee3') !== NULL) ? $request->input('professional_fee3') : NULL;
            $application->professional_fee4_1 = ($request->input('professional_fee4_1') !== NULL) ? $request->input('professional_fee4_1') : NULL;
            $application->professional_fee4_2 = ($request->input('professional_fee4_2') !== NULL) ? $request->input('professional_fee4_2') : NULL;
            $application->professional_fee5 = ($request->input('professional_fee5') !== NULL) ? $request->input('professional_fee5') : NULL;

            $application->updated_at = $timestamp;
            $application->updated_by = Auth::user()->id;

            if ($application->update()) {
                $this->update_applicants_inventors($request->input('app_applicants'), $request->input('app_inventors'), $application->id, $timestamp);

                $data = array(
                    'id' => $application->id,
                    'message' => 'The information has been successfully updated.',
                    'type'    => 'success'
                );

                echo json_encode( $data ); exit();
            }
        } else if ($method == 'all') {

            $res = Application::with([
                'applicants' =>  function($q) { 
                    $q->select(['application_id', 'fullname']); 
                },
                'inventors' =>  function($q) { 
                    $q->select(['application_id', 'fullname']); 
                }
            ])->where('category_id', '4')->orderBy('id', 'DESC')->groupBy('id')->get();
    
            return $res->map(function($app) {
                $filing_date = ($app->application_filing_date !== NULL) ? date('d-M-Y h:i A', strtotime($app->application_filing_date)) : '';
                $expiration_date = ($app->application_filing_date) ? date('d-M-Y h:i A', strtotime("+7 years", strtotime($app->application_filing_date))) : '';
                return [
                    'AppID' => $app->id,
                    'AppNo' => $app->application_no,
                    'AppTitle' => $app->application_title,
                    'Status' => $app->status_id,
                    'Type' => $app->category_id,
                    'FileDate' => $filing_date ? $filing_date.' / '.$expiration_date : '',
                    'PubDate' => ($app->published_date !== NULL) ? date('d-M-Y h:i A', strtotime($app->published_date)) : '',
                    'IssueDate' => ($app->issuance_date !== NULL) ? date('d-M-Y h:i A', strtotime($app->issuance_date)) : '',
                    'RegDate' => ($app->registration_date !== NULL) ? date('d-M-Y h:i A', strtotime($app->registration_date)) : '',
                    'AppApplicants' => $app->applicants->map(function($a) { return ' '.ucwords($a->fullname); }),
                    'AppInventors' => $app->inventors->map(function($a) { return ' '.ucwords($a->fullname); }),
                    'AppModified' => ($app->updated_at !== NULL) ? date('d-M-Y h:i A', strtotime($app->updated_at)) : date('d-M-Y h:i A', strtotime($app->created_at))
                ];
            });

        } else if ($method == '') {
            session()->put('appID', '');
            session()->save();
            return view('modules/applications/copyrights/views/manage');
        }
    }

    public function industrial_designs(Request $request, $id = '')
    {
        $method = request()->segment(3);

        if ($method == 'add') {
            if ($request->session()->get('appID') !== '') {
                return redirect('applications/industrial-designs/edit/'.$request->session()->get('appID'));
            } else {
                $application = (new Application)->fetch($id);
            }
            return view('modules/applications/industrial-designs/views/add')->with(compact('application'));
        } else if ($method == 'edit') {
            if ($request->session()->get('appID') !== '') { 
                session()->put('appID', '');
                session()->save();
            }
            $application = (new Application)->fetch($id);
            return view('modules/applications/industrial-designs/views/edit')->with(compact('application'));
        } else if ($method == 'store') {
            if ($request->input('app_no') !== NULL) { 

                $status = $this->validate_industrial_design_status(
                    $request->input('sub_paper_no1'), 
                    $request->input('sub_paper_no2'), 
                    $request->input('sub_mailing_date1'), 
                    $request->input('sub_mailing_date2'),
                    $request->input('publish_date'),
                    $request->input('issuance_date'),
                    $request->input('allow_remarks'),
                    $request->input('completed')
                );
    
                $timestamp = date('Y-m-d H:i:s');
                $application = Application::create([
                    'application_no' => $request->input('app_no'),
                    'category_id' => 5,
                    'status_id' => $status,
                    'application_filing_date' => ($request->input('app_filing_date') !== NULL) ? date('Y-m-d', strtotime($request->input('app_filing_date'))) : NULL,
                    'application_title' => ($request->input('app_title') !== NULL) ? $request->input('app_title') : NULL,
                    'application_amount' => ($request->input('app_amount') !== NULL) ? $request->input('app_amount') : NULL,
                    'application_contact_no' => ($request->input('app_contact') !== NULL) ? $request->input('app_contact') : NULL,
                    'application_address' => ($request->input('app_address') !== NULL) ? $request->input('app_address') : NULL,
                    'application_remarks' => ($request->input('app_remarks') !== NULL) ? $request->input('app_remarks') : NULL,
                    'application_file' => $request->get('file1'),

                    'fer_paper_no1' => ($request->input('sub_paper_no1') !== NULL) ? $request->input('sub_paper_no1') : NULL,
                    'fer_mailing_date1' => ($request->input('sub_mailing_date1') !== NULL) ? date('Y-m-d', strtotime($request->input('sub_mailing_date1'))) : NULL,
                    'fer_amount_file1' => ($request->input('sub_amount_file1') !== NULL) ? $request->input('sub_amount_file1') : NULL,
                    'fer_file1' => $request->get('file2'),
                    
                    'fer_yes_no' => ($request->input('fer_yes_no') == 'Yes') ? 1 : 0,
                    'fer_paper_no2' => ($request->input('sub_paper_no2') !== NULL) ? $request->input('sub_paper_no2') : NULL,
                    'fer_mailing_date2' => ($request->input('sub_mailing_date2') !== NULL) ? date('Y-m-d', strtotime($request->input('sub_mailing_date2'))) : NULL,
                    'fer_amount_file2' => ($request->input('sub_amount_file2') !== NULL) ? $request->input('sub_amount_file2') : NULL,
                    'fer_file2' => $request->get('file3'),
                    
                    'published_date' => ($request->input('pub_date') !== NULL) ? date('Y-m-d', strtotime($request->input('pub_date'))) : NULL,
                    'published_amount' => ($request->input('pub_amount') !== NULL) ? $request->input('pub_amount') : NULL,
                    'published_file' => $request->get('file4'),
                    
                    'issuance_date' => ($request->input('issuance_date') !== NULL) ? date('Y-m-d', strtotime($request->input('issuance_date'))) : NULL,
                    'allowance_remarks' => ($request->input('allow_remarks') !== NULL) ? $request->input('allow_remarks') : NULL,
                    'allowance_amount_file' => ($request->input('allow_amount_file') !== NULL) ? $request->input('allow_amount_file') : NULL,
                    'allowance_file' => $request->get('file7'),
                    'is_completed' => ($request->input('completed') == 'Yes') ? 1 : 0,

                    'professional_fee1' => ($request->input('professional_fee1') !== NULL) ? $request->input('professional_fee1') : NULL,
                    'professional_fee2_1' => ($request->input('professional_fee2_1') !== NULL) ? $request->input('professional_fee2_1') : NULL,
                    'professional_fee2_2' => ($request->input('professional_fee2_2') !== NULL) ? $request->input('professional_fee2_2') : NULL,
                    'professional_fee3' => ($request->input('professional_fee3') !== NULL) ? $request->input('professional_fee3') : NULL,
                    'professional_fee4_1' => ($request->input('professional_fee4_1') !== NULL) ? $request->input('professional_fee4_1') : NULL,
                    'professional_fee4_2' => ($request->input('professional_fee4_2') !== NULL) ? $request->input('professional_fee4_2') : NULL,
                    'professional_fee5' => ($request->input('professional_fee5') !== NULL) ? $request->input('professional_fee5') : NULL,
                    'created_at' => $timestamp,
                    'created_by' => Auth::user()->id
                ]);
    
                $this->store_applicants_inventors($request->input('app_applicants'), $request->input('app_inventors'), $application->id, $timestamp);
    
                if (!$application) {
                    throw new NotFoundHttpException();
                }
                
                session()->put('appID', $application->id);
                session()->save();
    
                $data = array(
                    'id' => $application->id,
                    'message' => 'The information has been successfully saved.',
                    'type'    => 'success'
                );
                
                echo json_encode( $data ); exit();
            }
            else {
                throw new NotFoundHttpException();
            }
        } else if ($method == 'update') {

            $timestamp = date('Y-m-d H:i:s');
            $application = Application::find($id);

            if(!$application) {
                throw new NotFoundHttpException();
            }

            $status = $this->validate_industrial_design_status(
                $request->input('sub_paper_no1'), 
                $request->input('sub_paper_no2'), 
                $request->input('sub_mailing_date1'), 
                $request->input('sub_mailing_date2'),
                $request->input('publish_date'),
                $request->input('issuance_date'),
                $request->input('allow_remarks'),
                $request->input('completed')
            );

            $application->application_no = $request->input('app_no');
            $application->category_id = 5;
            $application->status_id = $status;
            $application->application_filing_date = ($request->input('app_filing_date') !== NULL) ? date('Y-m-d', strtotime($request->input('app_filing_date'))) : NULL;
            $application->application_title = ($request->input('app_title') !== NULL) ? $request->input('app_title') : NULL;
            $application->application_remarks = ($request->input('app_remarks') !== NULL) ? $request->input('app_remarks') : NULL;
            $application->application_amount = ($request->input('app_amount') !== NULL) ? $request->input('app_amount') : NULL;
            $application->application_contact_no = ($request->input('app_contact') !== NULL) ? $request->input('app_contact') : NULL;
            $application->application_address = ($request->input('app_address') !== NULL) ? $request->input('app_address') : NULL;
            if ($request->get('file1') !== NULL) {
                $application->application_file = $request->get('file1');
            }

            $application->fer_paper_no1 = ($request->input('sub_paper_no1') !== NULL) ? $request->input('sub_paper_no1') : NULL;
            $application->fer_mailing_date1 = ($request->input('sub_mailing_date1') !== NULL) ? date('Y-m-d', strtotime($request->input('sub_mailing_date1'))) : NULL;
            $application->fer_amount_file1 = ($request->input('sub_amount_file1') !== NULL) ? $request->input('sub_amount_file1') : NULL;
            if ($request->get('file2') !== NULL) {
                $application->fer_file1 = $request->get('file2');
            }

            $application->fer_yes_no = ($request->input('fer_yes_no') == 'Yes') ? 1 : 0;
            $application->fer_paper_no2 = ($request->input('sub_paper_no2') !== NULL) ? $request->input('sub_paper_no2') : NULL;
            $application->fer_mailing_date2 = ($request->input('sub_mailing_date2') !== NULL) ? date('Y-m-d', strtotime($request->input('sub_mailing_date2'))) : NULL;
            $application->fer_amount_file2 = ($request->input('sub_amount_file2') !== NULL) ? $request->input('sub_amount_file2') : NULL;
            if ($request->get('file3') !== NULL) {
                $application->fer_file2 = $request->get('file3');
            }

            $application->published_date = ($request->input('pub_date') !== NULL) ? date('Y-m-d', strtotime($request->input('pub_date'))) : NULL;
            $application->published_amount = ($request->input('pub_amount') !== NULL) ? $request->input('pub_amount') : NULL;
            if ($request->get('file4') !== NULL) {
                $application->published_file = $request->get('file4');
            }

            $application->issuance_date = ($request->input('issuance_date') !== NULL) ? date('Y-m-d', strtotime($request->input('issuance_date'))) : NULL;
            $application->allowance_remarks = ($request->input('allow_remarks') !== NULL) ? $request->input('allow_remarks') : NULL;
            $application->allowance_amount_file = ($request->input('allow_amount_file') !== NULL) ? $request->input('allow_amount_file') : NULL;
            if ($request->get('file7') !== NULL) {
                $application->allowance_file = $request->get('file7');
            }
            $application->is_completed = ($request->input('completed') == 'Yes') ? 1 : 0;

            $application->professional_fee1 = ($request->input('professional_fee1') !== NULL) ? $request->input('professional_fee1') : NULL;
            $application->professional_fee2_1 = ($request->input('professional_fee2_1') !== NULL) ? $request->input('professional_fee2_1') : NULL;
            $application->professional_fee2_2 = ($request->input('professional_fee2_2') !== NULL) ? $request->input('professional_fee2_2') : NULL;
            $application->professional_fee3 = ($request->input('professional_fee3') !== NULL) ? $request->input('professional_fee3') : NULL;
            $application->professional_fee4_1 = ($request->input('professional_fee4_1') !== NULL) ? $request->input('professional_fee4_1') : NULL;
            $application->professional_fee4_2 = ($request->input('professional_fee4_2') !== NULL) ? $request->input('professional_fee4_2') : NULL;
            $application->professional_fee5 = ($request->input('professional_fee5') !== NULL) ? $request->input('professional_fee5') : NULL;

            $application->updated_at = $timestamp;
            $application->updated_by = Auth::user()->id;

            if ($application->update()) {
                $this->update_applicants_inventors($request->input('app_applicants'), $request->input('app_inventors'), $application->id, $timestamp);

                $data = array(
                    'id' => $application->id,
                    'message' => 'The information has been successfully updated.',
                    'type'    => 'success'
                );

                echo json_encode( $data ); exit();
            }
        } else if ($method == 'all') {

            $res = Application::with([
                'applicants' =>  function($q) { 
                    $q->select(['application_id', 'fullname']); 
                },
                'inventors' =>  function($q) { 
                    $q->select(['application_id', 'fullname']); 
                }
            ])->where('category_id', '5')->orderBy('id', 'DESC')->groupBy('id')->get();
    
            return $res->map(function($app) {
                $filing_date = ($app->application_filing_date !== NULL) ? date('d-M-Y h:i A', strtotime($app->application_filing_date)) : '';
                $expiration_date = ($app->application_filing_date) ? date('d-M-Y h:i A', strtotime("+7 years", strtotime($app->application_filing_date))) : '';
                return [
                    'AppID' => $app->id,
                    'AppNo' => $app->application_no,
                    'AppTitle' => $app->application_title,
                    'Status' => $app->status_id,
                    'Type' => $app->category_id,
                    'FileDate' => $filing_date ? $filing_date.' / '.$expiration_date : '',
                    'PubDate' => ($app->published_date !== NULL) ? date('d-M-Y h:i A', strtotime($app->published_date)) : '',
                    'IssueDate' => ($app->issuance_date !== NULL) ? date('d-M-Y h:i A', strtotime($app->issuance_date)) : '',
                    'RegDate' => ($app->registration_date !== NULL) ? date('d-M-Y h:i A', strtotime($app->registration_date)) : '',
                    'AppApplicants' => $app->applicants->map(function($a) { return ' '.ucwords($a->fullname); }),
                    'AppInventors' => $app->inventors->map(function($a) { return ' '.ucwords($a->fullname); }),
                    'AppModified' => ($app->updated_at !== NULL) ? date('d-M-Y h:i A', strtotime($app->updated_at)) : date('d-M-Y h:i A', strtotime($app->created_at))
                ];
            });

        } else if ($method == '') {
            session()->put('appID', '');
            session()->save();
            return view('modules/applications/industrial-designs/views/manage');
        }
    }

    public function fetchAnnualFee($annuityYear, $applicationID, $publicationDate, $column)
    {
        return (new AnnualFee)->fetchAnnualFee($annuityYear, $applicationID, $publicationDate, $column);
    }
    
    public function fetchDauFee($annuityYear, $applicationID, $regDate, $column, $renewal, $renewal_dau) 
    {
        return (new DauFee)->fetchDauFee($annuityYear, $applicationID, $regDate, $column, $renewal, $renewal_dau);
    }

    public function fetchRenewalDauFee($applicationID, $renewal, $renewal_dau) 
    {
        return (new DauFee)->fetchRenewalDauFee($applicationID, $renewal, $renewal_dau);
    }
}
