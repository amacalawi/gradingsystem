<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use App\Models\Transmutation;
use App\Models\TransmutationElement;
use App\Models\AuditLog;
use Session;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Http\File;
use App\Components\FlashMessages;

class TransmutationsController extends Controller
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
        return view('modules/academics/gradingsheets/transmutations/manage')->with(compact('menus'));
    }

    public function manage(Request $request)
    {   
        $menus = $this->load_menus();
        return view('modules/academics/gradingsheets/transmutations/manage')->with(compact('menus'));
    }

    public function inactive(Request $request)
    {   
        $menus = $this->load_menus();
        return view('modules/academics/gradingsheets/transmutations/inactive')->with(compact('menus'));
    }

    public function all_active(Request $request)
    {
        $res = Transmutation::where('is_active', 1)->orderBy('id', 'ASC')->get();

        return $res->map(function($trans) {
            return [
                'transID' => $trans->id,
                'transCode' => $trans->code,
                'transName' => $trans->name,
                'transDescription' => $trans->description,
                'transElement' => 'has '.(new TransmutationElement)->where('transmutation_id', $trans->id)->count().' elements',
                'transModified' => ($trans->updated_at !== NULL) ? date('d-M-Y', strtotime($trans->updated_at)).'<br/>'. date('h:i A', strtotime($trans->updated_at)) : date('d-M-Y', strtotime($trans->created_at)).'<br/>'. date('h:i A', strtotime($trans->created_at))
            ];
        });
    }

    public function all_inactive(Request $request)
    {
        $res = Transmutation::where('is_active', 0)->orderBy('order', 'ASC')->get();

        return $res->map(function($trans) {
            return [
                'transID' => $trans->id,
                'transCode' => $trans->code,
                'transName' => $trans->name,
                'transDescription' => $trans->description,
                'transSlug' => $trans->slug,
                'transOrder' => $trans->order,
                'transModified' => ($trans->updated_at !== NULL) ? date('d-M-Y', strtotime($trans->updated_at)).'<br/>'. date('h:i A', strtotime($trans->updated_at)) : date('d-M-Y', strtotime($trans->created_at)).'<br/>'. date('h:i A', strtotime($trans->created_at))
            ];
        });
    }

    public function add(Request $request, $id = '')
    {   
        $menus = $this->load_menus();
        $segment = request()->segment(4);
        $trans = (new Transmutation)->fetch($id);
        return view('modules/academics/gradingsheets/transmutations/add')->with(compact('menus', 'trans', 'segment'));
    }
    
    public function edit(Request $request, $id)
    {   
        $menus = $this->load_menus();
        $segment = request()->segment(4);
        $trans = (new Transmutation)->find($id);
        return view('modules/academics/gradingsheets/transmutations/edit')->with(compact('menus', 'trans', 'segment'));
    }
    
    public function store(Request $request)
    {    
        $timestamp = date('Y-m-d H:i:s');

        $rows = Transmutation::where([
            'code' => $request->code
        ])->count();

        if ($rows > 0) {
            $data = array(
                'title' => 'Oh snap!',
                'text' => 'You cannot create a trans with an existing code.',
                'type' => 'error',
                'class' => 'btn-danger'
            );
    
            echo json_encode( $data ); exit();
        }

        $trans = Transmutation::create([
            'code' => $request->code,
            'name' => $request->name,
            'description' => $request->description,
            'education_type_id' => $request->education_type_id,
            'created_at' => $timestamp,
            'created_by' => Auth::user()->id
        ]);

        if (!$trans) {
            throw new NotFoundHttpException();
        }

        $iteration = 0;
        foreach ($request->element_score as $score) {
            if ($request->element_score[$iteration] !== NULL) {
                $transmutation_element = TransmutationElement::create([
                    'trransmutation_id' => $trans->id,
                    'score' => ($request->element_score[$iteration] !== NULL) ? $request->element_score[$iteration] : NULL,
                    'equivalent' => ($request->element_equivalent[$iteration] !== NULL) ? $request->element_equivalent[$iteration] : NULL,
                    'created_at' => $timestamp,
                    'created_by' => Auth::user()->id
                ]);
                $this->audit_logs('transmutations_elements', $transmutation_element->id, 'has inserted a new transmutation element.', TransmutationElement::find($transmutation_element->id), $timestamp, Auth::user()->id);
            }
            $iteration++;
        }

        $this->audit_logs('transmutations', $trans->id, 'has inserted a new department.', Transmutation::find($trans->id), $timestamp, Auth::user()->id);

        $data = array(
            'title' => 'Well done!',
            'text' => 'The trans has been successfully saved.',
            'type' => 'success',
            'class' => 'btn-brand'
        );

        echo json_encode( $data ); exit();
    }

    public function update(Request $request, $id)
    {    
        $timestamp = date('Y-m-d H:i:s');
        $trans = Transmutation::find($id);

        if(!$trans) {
            throw new NotFoundHttpException();
        }

        $trans->code = $request->code;
        $trans->name = $request->name;
        $trans->description = $request->description;
        $trans->education_type_id = $request->education_type_id;
        $trans->updated_at = $timestamp;
        $trans->updated_by = Auth::user()->id;

        if ($trans->update()) {

            $iteration = 0;
            foreach ($request->element_score as $score) {
                if ($request->element_score[$iteration] !== NULL) {
                    $transmutation_element = TransmutationElement::where(['transmutation_id' => $id, 'score' => $score])
                    ->update([
                        'score' => ($request->element_score[$iteration] !== NULL) ? $request->element_score[$iteration] : NULL,
                        'equivalent' => ($request->element_equivalent[$iteration] !== NULL) ? $request->element_equivalent[$iteration] : NULL,
                        'updated_at' => $timestamp,
                        'updated_by' => Auth::user()->id
                    ]);
                    $transmutation_element = TransmutationElement::where(['transmutation_id' => $id, 'score' => $score])->get();
                    if ($transmutation_element->count() > 0) {
                        $this->audit_logs('transmutations_elements', $transmutation_element->first()->id, 'has modified a transmutation element.', TransmutationElement::find($transmutation_element->first()->id), $timestamp, Auth::user()->id);
                    } else {
                        $transmutation_element = TransmutationElement::create([
                            'trransmutation_id' => $id,
                            'score' => ($request->element_score[$iteration] !== NULL) ? $request->element_score[$iteration] : NULL,
                            'equivalent' => ($request->element_equivalent[$iteration] !== NULL) ? $request->element_equivalent[$iteration] : NULL,
                            'created_at' => $timestamp,
                            'created_by' => Auth::user()->id
                        ]);
                        $this->audit_logs('transmutations_elements', $transmutation_element->id, 'has inserted a new transmutation element.', TransmutationElement::find($transmutation_element->id), $timestamp, Auth::user()->id);
                    }
                }
                $iteration++;
            }

            $this->audit_logs('transmutations', $id, 'has modified a transmutation.', Department::find($id), $timestamp, Auth::user()->id);

            $data = array(
                'title' => 'Well done!',
                'text' => 'The trans has been successfully updated.',
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
            $transs = Transmutation::where([
                'id' => $id,
            ])
            ->update([
                'updated_at' => $timestamp,
                'updated_by' => Auth::user()->id,
                'is_active' => 0
            ]);
            $this->audit_logs('transmutations', $id, 'has removed a transmutation.', Transmutation::find($id), $timestamp, Auth::user()->id);
            
            $data = array(
                'title' => 'Well done!',
                'text' => 'The trans has been successfully removed.',
                'type' => 'success',
                'class' => 'btn-brand'
            );
    
            echo json_encode( $data ); exit();
        }   
        else {
            $batches = Transmutation::where([
                'id' => $id,
            ])
            ->update([
                'updated_at' => $timestamp,
                'updated_by' => Auth::user()->id,
                'is_active' => 1
            ]);
            $this->audit_logs('transmutations', $id, 'has removed a transmutation.', Transmutation::find($id), $timestamp, Auth::user()->id);
            
            $data = array(
                'title' => 'Well done!',
                'text' => 'The trans has been successfully activated.',
                'type' => 'success',
                'class' => 'btn-brand'
            );
    
            echo json_encode( $data ); exit();
        }   
    }

    public function audit_logs($entity, $entity_id, $description, $data, $timestamp, $user)
    {
        $auditLogs = AuditLog::create([
            'entity' => $entity,
            'entity_id' => $entity_id,
            'description' => $description,
            'data' => json_encode($data),
            'created_at' => $timestamp,
            'created_by' => $user
        ]);

        return true;
    }
}
