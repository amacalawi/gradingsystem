<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use App\Models\Header;
use App\Models\AuditLog;
use Session;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Http\File;
use App\Components\FlashMessages;
use App\Helper\Helper;

class HeadersController extends Controller
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
        return view('modules/components/menus/headers/manage')->with(compact('menus'));
    }

    public function manage(Request $request)
    {   
        $this->is_permitted(1);
        $menus = $this->load_menus();
        return view('modules/components/menus/headers/manage')->with(compact('menus'));
    }

    public function inactive(Request $request)
    {   
        $this->is_permitted(1);
        $menus = $this->load_menus();
        return view('modules/components/menus/headers/inactive')->with(compact('menus'));
    }

    public function all_active(Request $request)
    {
        $res = Header::where('is_active', 1)->orderBy('order', 'ASC')->get();

        return $res->map(function($header) {
            return [
                'headerID' => $header->id,
                'headerCode' => $header->code,
                'headerName' => $header->name,
                'headerDescription' => $header->description,
                'headerSlug' => $header->slug,
                'headerOrder' => $header->order,
                'headerModified' => ($header->updated_at !== NULL) ? date('d-M-Y', strtotime($header->updated_at)).'<br/>'. date('h:i A', strtotime($header->updated_at)) : date('d-M-Y', strtotime($header->created_at)).'<br/>'. date('h:i A', strtotime($header->created_at))
            ];
        });
    }

    public function all_inactive(Request $request)
    {
        $res = Header::where('is_active', 0)->orderBy('order', 'ASC')->get();

        return $res->map(function($header) {
            return [
                'headerID' => $header->id,
                'headerCode' => $header->code,
                'headerName' => $header->name,
                'headerDescription' => $header->description,
                'headerSlug' => $header->slug,
                'headerOrder' => $header->order,
                'headerModified' => ($header->updated_at !== NULL) ? date('d-M-Y', strtotime($header->updated_at)).'<br/>'. date('h:i A', strtotime($header->updated_at)) : date('d-M-Y', strtotime($header->created_at)).'<br/>'. date('h:i A', strtotime($header->created_at))
            ];
        });
    }

    public function add(Request $request, $id = '')
    {   
        $this->is_permitted(0);
        $menus = $this->load_menus();
        $flashMessage = self::messages();
        $segment = request()->segment(4);
        if (count($flashMessage) && $flashMessage[0]['module'] == 'header') {
            $header = (new Header)->fetch($flashMessage[0]['id']);
        } else {
            $header = (new Header)->fetch($id);
        }
        return view('modules/components/menus/headers/add')->with(compact('menus', 'header', 'segment', 'flashMessage'));
    }
    
    public function edit(Request $request, $id)
    {   
        $this->is_permitted(2);
        $menus = $this->load_menus();
        $flashMessage = self::messages();
        $segment = request()->segment(4);
        $header = (new Header)->find($id);
        return view('modules/components/menus/headers/edit')->with(compact('menus', 'header', 'segment', 'flashMessage'));
    }
    
    public function store(Request $request)
    {    
        $this->is_permitted(0);
        $timestamp = date('Y-m-d H:i:s');

        $rows = Header::where([
            'code' => $request->code
        ])->count();

        if ($rows > 0) {
            $data = array(
                'title' => 'Oh snap!',
                'text' => 'You cannot create a header with an existing code.',
                'type' => 'error',
                'class' => 'btn-danger'
            );
    
            echo json_encode( $data ); exit();
        }

        $count = Header::all()->count() + 1;

        $header = Header::create([
            'code' => $request->code,
            'name' => $request->name,
            'description' => $request->description,
            'slug' => str_replace(' ', '-', strtolower($request->name)),
            'order' => $count,
            'created_at' => $timestamp,
            'created_by' => Auth::user()->id
        ]);

        if (!$header) {
            throw new NotFoundHttpException();
        }

        $auditLogs = AuditLog::create([
            'entity' => 'headers',
            'entity_id' => $header->id,
            'description' => 'has inserted a new header.',
            'data' => json_encode(Header::find($header->id)),
            'created_at' => $timestamp,
            'created_by' => Auth::user()->id
        ]);

        $data = array(
            'title' => 'Well done!',
            'text' => 'The header has been successfully saved.',
            'type' => 'success',
            'class' => 'btn-brand'
        );

        echo json_encode( $data ); exit();
    }

    public function update(Request $request, $id)
    {    
        $this->is_permitted(2);
        $timestamp = date('Y-m-d H:i:s');
        $header = Header::find($id);

        if(!$header) {
            throw new NotFoundHttpException();
        }

        $header->code = $request->code;
        $header->name = $request->name;
        $header->description = $request->description;
        $header->slug = str_replace(' ', '-', strtolower($request->name));
        $header->updated_at = $timestamp;
        $header->updated_by = Auth::user()->id;

        if ($header->update()) {

            $auditLogs = AuditLog::create([
                'entity' => 'headers',
                'entity_id' => $id,
                'description' => 'has modified a header.',
                'data' => json_encode(Header::find($id)),
                'created_at' => $timestamp,
                'created_by' => Auth::user()->id
            ]);

            $data = array(
                'title' => 'Well done!',
                'text' => 'The header has been successfully updated.',
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
            $headers = Header::where([
                'id' => $id,
            ])
            ->update([
                'updated_at' => $timestamp,
                'updated_by' => Auth::user()->id,
                'is_active' => 0
            ]);

            $auditLogs = AuditLog::create([
                'entity' => 'headers',
                'entity_id' => $id,
                'description' => 'has removed a header.',
                'data' => json_encode(Header::find($id)),
                'created_at' => $timestamp,
                'created_by' => Auth::user()->id
            ]);
            
            $data = array(
                'title' => 'Well done!',
                'text' => 'The header has been successfully removed.',
                'type' => 'success',
                'class' => 'btn-brand'
            );
    
            echo json_encode( $data ); exit();
        } 
        else if ($action == 'Up') {
            $headers = Header::find($id);

            $headers2 = Header::where([
                'order' => ($headers->order - 1),
            ])
            ->update([
                'order' => $headers->order,
                'updated_at' => $timestamp,
                'updated_by' => Auth::user()->id
            ]);

            $headers->order = ($headers->order - 1);
            $headers->updated_at = $timestamp;
            $headers->updated_by = Auth::user()->id;
            $headers->update();

            $auditLogs = AuditLog::create([
                'entity' => 'headers',
                'entity_id' => $id,
                'description' => 'has modified the header order up.',
                'data' => json_encode(Header::find($id)),
                'created_at' => $timestamp,
                'created_by' => Auth::user()->id
            ]);
            
            $data = array(
                'title' => 'Well done!',
                'text' => 'The header has been successfully removed.',
                'type' => 'success',
                'class' => 'btn-brand'
            );
    
            echo json_encode( $data ); exit();
        } 
        else if ($action == 'Down') {
            $headers = Header::find($id);

            $headers2 = Header::where([
                'order' => ($headers->order + 1),
            ])
            ->update([
                'order' => $headers->order,
                'updated_at' => $timestamp,
                'updated_by' => Auth::user()->id
            ]);

            $headers->order = ($headers->order + 1);
            $headers->updated_at = $timestamp;
            $headers->updated_by = Auth::user()->id;
            $headers->update();
            
            $auditLogs = AuditLog::create([
                'entity' => 'headers',
                'entity_id' => $id,
                'description' => 'has modified the header order down.',
                'data' => json_encode(Header::find($id)),
                'created_at' => $timestamp,
                'created_by' => Auth::user()->id
            ]);
            
            $data = array(
                'title' => 'Well done!',
                'text' => 'The header has been successfully removed.',
                'type' => 'success',
                'class' => 'btn-brand'
            );

            echo json_encode( $data ); exit();
        }         
        else {
            $batches = Header::where([
                'id' => $id,
            ])
            ->update([
                'updated_at' => $timestamp,
                'updated_by' => Auth::user()->id,
                'is_active' => 1
            ]);
            
            $auditLogs = AuditLog::create([
                'entity' => 'headers',
                'entity_id' => $id,
                'description' => 'has retrieved a header.',
                'data' => json_encode(Header::find($id)),
                'created_at' => $timestamp,
                'created_by' => Auth::user()->id
            ]);
            
            $data = array(
                'title' => 'Well done!',
                'text' => 'The header has been successfully activated.',
                'type' => 'success',
                'class' => 'btn-brand'
            );
    
            echo json_encode( $data ); exit();
        }   
    }

}
