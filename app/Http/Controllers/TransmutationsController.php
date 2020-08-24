<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use App\Models\Transmutation;
use App\Models\TransmutationElement;
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
        $flashMessage = self::messages();
        $segment = request()->segment(4);
        if (count($flashMessage) && $flashMessage[0]['module'] == 'trans') {
            $trans = (new Header)->fetch($flashMessage[0]['id']);
        } else {
            $trans = (new Header)->fetch($id);
        }
        return view('modules/academics/gradingsheets/transmutations/add')->with(compact('menus', 'trans', 'segment', 'flashMessage'));
    }
    
    public function edit(Request $request, $id)
    {   
        $menus = $this->load_menus();
        $flashMessage = self::messages();
        $segment = request()->segment(4);
        $trans = (new Header)->find($id);
        return view('modules/academics/gradingsheets/transmutations/edit')->with(compact('menus', 'trans', 'segment', 'flashMessage'));
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

        $count = Transmutation::all()->count() + 1;

        $trans = Transmutation::create([
            'code' => $request->code,
            'name' => $request->name,
            'description' => $request->description,
            'slug' => str_replace(' ', '-', strtolower($request->name)),
            'order' => $count,
            'created_at' => $timestamp,
            'created_by' => Auth::user()->id
        ]);

        if (!$trans) {
            throw new NotFoundHttpException();
        }

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
        $trans->slug = str_replace(' ', '-', strtolower($request->name));
        $trans->updated_at = $timestamp;
        $trans->updated_by = Auth::user()->id;

        if ($trans->update()) {

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
            
            $data = array(
                'title' => 'Well done!',
                'text' => 'The trans has been successfully removed.',
                'type' => 'success',
                'class' => 'btn-brand'
            );
    
            echo json_encode( $data ); exit();
        } 
        else if ($action == 'Up') {
            $transs = Transmutation::find($id);

            $transs2 = Transmutation::where([
                'order' => ($transs->order - 1),
            ])
            ->update([
                'order' => $transs->order,
                'updated_at' => $timestamp,
                'updated_by' => Auth::user()->id
            ]);

            $transs->order = ($transs->order - 1);
            $transs->updated_at = $timestamp;
            $transs->updated_by = Auth::user()->id;
            $transs->update();
            
            $data = array(
                'title' => 'Well done!',
                'text' => 'The trans has been successfully removed.',
                'type' => 'success',
                'class' => 'btn-brand'
            );
    
            echo json_encode( $data ); exit();
        } 
        else if ($action == 'Down') {
            $transs = Transmutation::find($id);

            $transs2 = Transmutation::where([
                'order' => ($transs->order + 1),
            ])
            ->update([
                'order' => $transs->order,
                'updated_at' => $timestamp,
                'updated_by' => Auth::user()->id
            ]);

            $transs->order = ($transs->order + 1);
            $transs->updated_at = $timestamp;
            $transs->updated_by = Auth::user()->id;
            $transs->update();
            
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
            
            $data = array(
                'title' => 'Well done!',
                'text' => 'The trans has been successfully activated.',
                'type' => 'success',
                'class' => 'btn-brand'
            );
    
            echo json_encode( $data ); exit();
        }   
    }

}
