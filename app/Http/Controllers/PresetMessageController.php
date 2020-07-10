<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PresetMessage;
use Illuminate\Support\Facades\Auth;

class PresetMessageController extends Controller
{
    private $models;

    public function __construct()
    {   
        date_default_timezone_set('Asia/Manila');
        $this->middleware('auth');
    }

    public function index()
    {   
        $menus = $this->load_menus();
        return view('modules/schedules/presetmsg/manage')->with(compact('menus'));
    }

    public function manage(Request $request)
    {   
        $menus = $this->load_menus();
        return view('modules/schedules/presetmsg/manage')->with(compact('menus'));
    }

    public function inactive(Request $request)
    {   
        $menus = $this->load_menus();
        return view('modules/schedules/presetmsg/inactive')->with(compact('menus'));
    }

    public function all_active(Request $request)
    {
        $res = PresetMessage::where('is_active', 1)->orderBy('id', 'DESC')->get();

        return $res->map(function($presetmsg) {
            return [
                'presetmsgID' => $presetmsg->id,
                'presetmsgMessage' => $presetmsg->message,
                'presetmsgModified' => ($presetmsg->updated_at !== NULL) ? date('d-M-Y', strtotime($presetmsg->updated_at)).'<br/>'. date('h:i A', strtotime($presetmsg->updated_at)) : date('d-M-Y', strtotime($presetmsg->created_at)).'<br/>'. date('h:i A', strtotime($presetmsg->created_at)),
            ];
        });
    }

    public function all_inactive(Request $request)
    {
        $res = PresetMessage::where('is_active', 0)->orderBy('id', 'DESC')->get();

        return $res->map(function($presetmsg) {
            return [
                'presetmsgID' => $presetmsg->id,
                'presetmsgMessage' => $presetmsg->message,
                'presetmsgModified' => ($presetmsg->updated_at !== NULL) ? date('d-M-Y', strtotime($presetmsg->updated_at)).'<br/>'. date('h:i A', strtotime($presetmsg->updated_at)) : date('d-M-Y', strtotime($presetmsg->created_at)).'<br/>'. date('h:i A', strtotime($presetmsg->created_at)),
            ];
        });
    }

    public function add(Request $request, $id = '')
    {   
        $menus = $this->load_menus();
        $flashMessage = self::messages();
        $segment = request()->segment(4);

        if (count($flashMessage) && $flashMessage[0]['module'] == 'preset-message') {
            $presetmsg = (new PresetMessage)->fetch($flashMessage[0]['id']);
        } else {
            $presetmsg = (new PresetMessage)->fetch($id);
        }

        return view('modules/schedules/presetmsg/add')->with(compact('menus', 'presetmsg', 'segment', 'flashMessage'));
    }

    public function edit(Request $request, $id)
    {   
        $menus = $this->load_menus();
        $flashMessage = self::messages();
        $segment = request()->segment(4);
        $presetmsg = (new PresetMessage)->find($id);
        return view('modules/schedules/presetmsg/edit')->with(compact('menus', 'presetmsg', 'segment', 'flashMessage'));
    }

    public function store(Request $request)
    {   
        $timestamp = date('Y-m-d H:i:s');
        
        $presetmsg = PresetMessage::create([
            'message' => $request->message,
            'created_at' => $timestamp,
            'created_by' => Auth::user()->id
        ]);

        if (!$presetmsg) {
            throw new NotFoundHttpException();
        }

        $data = array(
            'title' => 'Well done!',
            'text' => 'The preset message has been successfully saved.',
            'type' => 'success',
            'class' => 'btn-brand'
        );

        echo json_encode( $data ); exit();
    }

    public function update(Request $request, $id)
    {    
        $timestamp = date('Y-m-d H:i:s');

        $presetmsg = PresetMessage::find($id);

        if(!$presetmsg) {
            throw new NotFoundHttpException();
        }

        $presetmsg->message = $request->message;
        $presetmsg->updated_at = $timestamp;
        $presetmsg->updated_by = Auth::user()->id;

        if ($presetmsg->update()) {

            $data = array(
                'title' => 'Well done!',
                'text' => 'The preset message has been successfully updated.',
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
            $presetmsg = PresetMessage::where([
                'id' => $id,
            ])
            ->update([
                'updated_at' => $timestamp,
                'updated_by' => Auth::user()->id,
                'is_active' => 0
            ]);
            
            $data = array(
                'title' => 'Well done!',
                'text' => 'The preset message status has been successfully removed.',
                'type' => 'success',
                'class' => 'btn-brand'
            );
    
            echo json_encode( $data ); exit();
        }

        else if ($action == 'Active') {
            $presetmsg = PresetMessage::where([
                'id' => $id,
            ])
            ->update([
                'updated_at' => $timestamp,
                'updated_by' => Auth::user()->id,
                'is_active' => 1
            ]);
            
            $data = array(
                'title' => 'Well done!',
                'text' => 'The preset message status has been successfully activated.',
                'type' => 'success',
                'class' => 'btn-brand'
            );
    
            echo json_encode( $data ); exit();
        }

    }

}
