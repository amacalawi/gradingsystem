<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Batch;
use App\Models\Group;
use App\Models\Section;
use App\Models\Message;
use App\Models\GroupUser;
use App\Models\Admission;
use App\Models\Prefix;
use App\Models\Outbox;
use App\User;

class InfoblastController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
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
        return view('modules/notifications/messaging/infoblast/new')->with(compact('menus'));
    }

    public function outbox(Request $request)
    {   
        $menus = $this->load_menus();
        return view('modules/notifications/messaging/infoblast/outbox')->with(compact('menus'));
    }

    public function active_outbox(Request $request)
    {
        $res = Outbox::
        with([
            'message' =>  function($q) { 
                $q->select(['id', 'messages']); 
            }
        ])
        ->where(['is_active' => 1, 'batch_id' => (new Batch)->get_current_batch()])
        ->orderBy('id', 'DESC')
        ->get();

        return $res->map(function($outbox) {
            return [
                'outboxID' => $outbox->id,
                'outboxStatus' => $outbox->status,
                'outboxNetwork' => $outbox->smsc,
                'outboxPhone' => $outbox->msisdn,
                'outboxMessage' => $outbox->message->messages,
                'outboxDate' => date('d-M-Y h:i A', strtotime($outbox->created_at))
            ];
        });
    }

    public function new()
    {   
        $menus = $this->load_menus();
        $groups = Group::where('is_active', 1)->get();
        $sections = Section::where('is_active', 1)->get();
        $users = User::where('id', '!=', 1)->where('is_active', 1)->get();
        return view('modules/notifications/messaging/infoblast/new')->with(compact('menus', 'groups', 'sections', 'users'));
    }

    public function send(Request $request)
    {    
        $timestamp = date('Y-m-d H:i:s');
        $recipients = array();

        $message = Message::create([
            'message_type_id' => $request->message_type_id,
            'messages' => $request->messages,
            'created_at' => $timestamp,
            'created_by' => Auth::user()->id
        ]);

        if (!$message) {
            throw new NotFoundHttpException();
        }

        if (!empty($request->groups)) {
            foreach ($request->groups as $group) {
                $groupUsers = GroupUser::where(['is_active' => 1, 'group_id' => $group, 'batch_id' => (new Batch)->get_current_batch()])->get();
                if ($groupUsers->count() > 0) {
                    foreach ($groupUsers as $groupUser) {
                        $mobileNum = (new User)->get_msisdn_via_user($groupUser);
                        if ($mobileNum !== '' && !in_array($mobileNum, $recipients)) {
                            $recipients[] = $mobileNum;
                        }
                    }
                }
            }
        }

        if (!empty($request->sections)) {
            foreach ($request->sections as $section) {
                $admissions = Admission::where(['is_active' => 1, 'section_id' => $section, 'batch_id' => (new Batch)->get_current_batch(), 'status' => 'admit'])->get();
                if ($admissions->count() > 0) {
                    foreach ($admissions as $admission) {
                        $mobileNum = ((new Student)->where('id', $admission->student_id)->pluck('mobile_no') !== NULL) ? (new Student)->where('id', $admission->student_id)->pluck('mobile_no') : '';
                        if ($mobileNum !== '' && !in_array($mobileNum, $recipients)) {
                            $recipients[] = $mobileNum;
                        }
                    }
                }
            }
        }

        if (!empty($request->users)) {
            foreach ($request->users as $user) {
                $mobileNum = (new User)->get_msisdn_via_user($user);
                if ($mobileNum !== '' && !in_array($mobileNum, $recipients)) {
                    $recipients[] = $mobileNum;
                }
            }
        }

        if (!empty($request->anonymous)) {
            foreach ($request->anonymous as $mobileNum) {
                if ($mobileNum !== '' && !in_array($mobileNum, $recipients)) {
                    $recipients[] = $mobileNum;
                }
            }
        }
        
        $queue = $this->queue_message($message, $recipients, $timestamp);

        if ($queue) {
            $data = array(
                'message_type_id' => $request->message_type_id,
                'messages' => $request->messages,
                'groups' => $request->groups,
                'sections' => $request->sections,
                'users' => $request->users,
                'anonymous' => $request->anonymous,
                'title' => 'Well done!',
                'text' => 'The messages has been successfully sent.',
                'type' => 'success',
                'class' => 'btn-brand'
            );

            echo json_encode( $data ); exit();
        }
    }

    public function queue_message($message, $recipients, $timestamp) 
    {   
        $batch = (new Batch)->get_current_batch();
        foreach ($recipients as $recipient) {
            $network = (new Prefix)->get_network($recipient);
            $outbox = Outbox::create([
                'message_id' => $message->id,
                'batch_id' => $batch,
                'msisdn' => $recipient,
                'status' => 'pending',
                'smsc' => $network,
                'created_at' => $timestamp,
                'created_by' => Auth::user()->id,
            ]);
    
            if (!$outbox) {
                throw new NotFoundHttpException();
            }

            $messages = (new Message)->sendItem($outbox->id, $recipient, $network, $message->messages);
        }

        return true;
    }

    public function dlr()
    {
        $outbox_id = $_REQUEST['outbox_id'];
        if (!$outbox_id) exit();

        #  1: delivery success
        #  2: delivery failure
        #  4: message buffered
        #  8: smsc submit
        #  16: smsc reject

        $status[1] = 'successful';
        $status[2] = 'failure';
        $status[4] = 'buffered';
        $status[8] = 'success';
        $status[16] = 'reject';

        $type = $_REQUEST['type'];
        $type = ($status[$type]) ? $status[$type] : $type;

        $outbox = Outbox::find($outbox_id);

        if(!$outbox) {
            throw new NotFoundHttpException();
        }

        $outbox->status = $type;
        $outbox->update();
    }
}
