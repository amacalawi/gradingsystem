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
use App\Models\Inbox;
use App\Models\MessageType;
use App\Models\MessageTemplate;
use App\User;
use DB;

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

    public function inbox(Request $request)
    {   
        $menus = $this->load_menus();
        $inboxes = Inbox::
        with([
            'user' =>  function($q) { 
                $q->select(['id', 'name']); 
            }
        ])
        ->where(['is_active' => 1, 'batch_id' => (new Batch)->get_current_batch()])
        ->get();
        return view('modules/notifications/messaging/infoblast/inbox')->with(compact('menus', 'inboxes'));
    }

    public function get_inboxes_via_msisdn(Request $request)
    {   
        $msisdn = $request->get('msisdn');
        $first = \DB::table('inbox')
        ->select(['messages', 'created_at', DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d %h:%i') as timestamp"), DB::raw("CONCAT('inbox') AS type")])
        ->where([
            'msisdn' => $msisdn, 
            'is_active' => 1, 
            'batch_id' => (new Batch)->get_current_batch()
        ]);
        
        $res = \DB::table('outbox')
        ->select(['messages.messages', 'outbox.created_at', DB::raw("DATE_FORMAT(outbox.created_at, '%Y-%m-%d %h:%i') as timestamp"), DB::raw("CONCAT('outbox') AS type")])
        ->join('messages', 'outbox.message_id', '=', 'messages.id')
        ->where([
            'outbox.status' => 'success', 
            'outbox.msisdn' => $msisdn, 
            'outbox.is_active' => 1, 
            'outbox.batch_id' => (new Batch)->get_current_batch()
        ])
        ->union($first)
        ->orderBy('created_at', 'ASC')
        ->groupBy('timestamp')
        ->get();

        $res = $res->map(function($msg) {
            $timestampHour = (date('Y-m-d') == date('Y-m-d', strtotime($msg->created_at))) ? date('h:i', strtotime($msg->created_at)) : date('d-M-Y h:i', strtotime($msg->created_at));
            $timestampTime = date('A', strtotime($msg->created_at));
            return [
                'msg' => $msg->messages,
                'msgDate' => $timestampHour,
                'msgTime' => $timestampTime,
                'msgTimestamp' => $msg->timestamp,
                'type' => $msg->type
            ];
        });   
        
        return response()
        ->json([
            'status' => 'ok',
            'data' => $res
        ]);
    }

    public function new()
    {   
        $menus = $this->load_menus();
        $groups = Group::where('is_active', 1)->get();
        return view('modules/notifications/messaging/infoblast/new')->with(compact('menus'));
    }

    public function resend_item(Request $request, $message_id)
    {   
        $timestamp = date('Y-m-d H:i:s'); $recipients = array(); $outboxes = array();
        $message = Message::find($message_id);
        $outboxs = Outbox::where('status', '!=', 'success')->where(['message_id' => $message_id, 'is_active' => 1, 'batch_id' => (new Batch)->get_current_batch()])->get();
        
        if ($outboxs->count() > 0) {
            foreach ($outboxs as $outbox) {
                if ($outbox->msisdn !== '') {
                    $recipients[] = $outbox->msisdn;
                    $outboxes[] = $outbox->id;
                }
            }
        }

        if (!empty($recipients)) {
            $queue = $this->queue_message($message, $recipients, $timestamp, $outboxes);

            if ($queue) {
                $data = array(
                    'title' => 'Well done!',
                    'text' => 'The messages has been successfully sent.',
                    'type' => 'success',
                    'class' => 'btn-brand'
                );

                echo json_encode( $data ); exit();
            }
        } else {
            $data = array(
                'title' => 'Tadaa!',
                'text' => 'The items have already been sent.',
                'type' => 'info',
                'class' => 'btn-info'
            );

            echo json_encode( $data ); exit();
        }
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

    public function queue_message($message, $recipients, $timestamp, $outboxs = '') 
    {   
        $batch = (new Batch)->get_current_batch();
        if ($outboxs == '') {
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
        } else {
            $iteration = 0;
            foreach ($recipients as $recipient) {
                $network = (new Prefix)->get_network($recipient);
                $messages = (new Message)->sendItem($outboxs[$iteration], $recipient, $network, $message->messages);
                $iteration++;
            }
        }

        return true;
    }

    public function templates(Request $request)
    {   
        $menus = $this->load_menus();
        return view('modules/notifications/messaging/infoblast/templates')->with(compact('menus'));
    }

    public function inactive_templates(Request $request)
    {   
        $menus = $this->load_menus();
        return view('modules/notifications/messaging/infoblast/inactive-templates')->with(compact('menus'));
    }

    public function messaging_template(Request $request, $id = '')
    {   
        $menus = $this->load_menus();
        $segment = request()->segment(5);
        $template = (new MessageTemplate)->fetch($id);
        return view('modules/notifications/messaging/infoblast/messaging-template')->with(compact('menus', 'template', 'segment'));
    }

    public function all_active_templates(Request $request)
    {
        $res = MessageTemplate::
        with([
            'types' =>  function($q) { 
                $q->select(['id', 'name']); 
            }
        ])
        ->where(['is_active' => 1])
        ->orderBy('id', 'DESC')
        ->get();

        return $res->map(function($template) {
            return [
                'templateID' => $template->id,
                'templateCode' => $template->code,
                'templateName' => $template->name,
                'templateMessages' => $template->messages,
                'templateTypeID' => $template->types->id,
                'templateType' => $template->types->name,
                'templateModified' => ($template->updated_at !== NULL) ? date('d-M-Y', strtotime($template->updated_at)).'<br/>'. date('h:i A', strtotime($template->updated_at)) : date('d-M-Y', strtotime($template->created_at)).'<br/>'. date('h:i A', strtotime($template->created_at))
            ];
        });
    }

    public function all_inactive_templates(Request $request)
    {
        $res = MessageTemplate::
        with([
            'types' =>  function($q) { 
                $q->select(['id', 'name']); 
            }
        ])
        ->where(['is_active' => 0])
        ->orderBy('id', 'DESC')
        ->get();

        return $res->map(function($template) {
            return [
                'templateID' => $template->id,
                'templateCode' => $template->code,
                'templateName' => $template->name,
                'templateMessages' => $template->messages,
                'templateTypeID' => $template->types->id,
                'templateType' => $template->types->name,
                'templateModified' => ($template->updated_at !== NULL) ? date('d-M-Y', strtotime($template->updated_at)).'<br/>'. date('h:i A', strtotime($template->updated_at)) : date('d-M-Y', strtotime($template->created_at)).'<br/>'. date('h:i A', strtotime($template->created_at))
            ];
        });
    }

    public function store_template(Request $request)
    {    
        $timestamp = date('Y-m-d H:i:s');

        $rows = MessageTemplate::where([
            'code' => $request->code
        ])->count();

        if ($rows > 0) {
            $data = array(
                'title' => 'Oh snap!',
                'text' => 'You cannot create a message template with an existing code.',
                'type' => 'error',
                'class' => 'btn-danger'
            );
    
            echo json_encode( $data ); exit();
        }

        $message_template = MessageTemplate::create([
            'code' => $request->code,
            'name' => $request->name,
            'messages' => $request->messages,
            'message_type_id' => $request->message_type_id,
            'created_at' => $timestamp,
            'created_by' => Auth::user()->id
        ]);

        if (!$message_template) {
            throw new NotFoundHttpException();
        }

        $data = array(
            'title' => 'Well done!',
            'text' => 'The message template has been successfully saved.',
            'type' => 'success',
            'class' => 'btn-brand'
        );

        echo json_encode( $data ); exit();
    }

    public function update_template(Request $request, $id)
    {    
        $timestamp = date('Y-m-d H:i:s');

        $rows = MessageTemplate::where('id', '!=', $id)->where([
            'code' => $request->code
        ])->count();

        if ($rows > 0) {
            $data = array(
                'title' => 'Oh snap!',
                'text' => 'You cannot use and update an existing code.',
                'type' => 'error',
                'class' => 'btn-danger'
            );
    
            echo json_encode( $data ); exit();
        }

        $message_template = MessageTemplate::find($id);

        if(!$message_template) {
            throw new NotFoundHttpException();
        }

        $message_template->code = $request->code;
        $message_template->name = $request->name;
        $message_template->messages = $request->messages;
        $message_template->message_type_id = $request->message_type_id;
        $message_template->updated_at = $timestamp;
        $message_template->updated_by = Auth::user()->id;

        if ($message_template->update()) {

            $data = array(
                'title' => 'Well done!',
                'text' => 'The message template has been successfully updated.',
                'type' => 'success',
                'class' => 'btn-brand'
            );
    
            echo json_encode( $data ); exit();
        }
    }

    public function update_template_status(Request $request, $id)
    {   
        $timestamp = date('Y-m-d H:i:s');
        $action = $request->input('items')[0]['action'];

        if ($action == 'Remove') {
            $departments = MessageTemplate::where([
                'id' => $id,
            ])
            ->update([
                'updated_at' => $timestamp,
                'updated_by' => Auth::user()->id,
                'is_active' => 0
            ]);
            
            $data = array(
                'title' => 'Well done!',
                'text' => 'The message template has been successfully removed.',
                'type' => 'success',
                'class' => 'btn-brand'
            );
    
            echo json_encode( $data ); exit();
        }    
        else {
            $batches = MessageTemplate::where([
                'id' => $id,
            ])
            ->update([
                'updated_at' => $timestamp,
                'updated_by' => Auth::user()->id,
                'is_active' => 1
            ]);
            
            $data = array(
                'title' => 'Well done!',
                'text' => 'The message template has been successfully activated.',
                'type' => 'success',
                'class' => 'btn-brand'
            );
    
            echo json_encode( $data ); exit();
        }   
    }

    public function search_group(Request $request)
    {   
        if ($request->group != '') {
            $groups = Group::where('name', 'like', '%' . $request->group . '%')->where('is_active', 1)->get();
        } else {
            $groups = Group::where(['is_active' => 1])->get();
        }

        echo json_encode( $groups ); exit();
    }

    public function search_section(Request $request)
    {   
        if ($request->section != '') {
            $sections = Section::where('name', 'like', '%' . $request->section . '%')->where('is_active', 1)->get();
        } else {
            $sections = Section::where(['is_active' => 1])->get();
        }

        echo json_encode( $sections ); exit();
    }

    public function search_user(Request $request)
    {   
        if ($request->user != '') {
            $users = User::where('id', '!=', 1)->where('name', 'like', '%' . $request->user . '%')->where('is_active', 1)->get();
        } else {
            $users = User::where('id', '!=', 1)->where(['is_active' => 1])->get();
        }

        echo json_encode( $users ); exit();
    }

    public function tracking(Request $request)
    {   
        $menus = $this->load_menus();
        $messages = Outbox::where(['is_active' => 1, 'batch_id' => (new Batch)->get_current_batch()])->count();
        $successful = Outbox::where(['status' => 'success', 'is_active' => 1, 'batch_id' => (new Batch)->get_current_batch()])->count();
        $pending = Outbox::where(['status' => 'pending', 'is_active' => 1, 'batch_id' => (new Batch)->get_current_batch()])->count();
        $failure = Outbox::where(['status' => 'failure', 'is_active' => 1, 'batch_id' => (new Batch)->get_current_batch()])->count();
        return view('modules/notifications/messaging/infoblast/tracking')->with(compact('menus', 'messages', 'successful', 'pending', 'failure'));
    }

    public function active_tracking(Request $request)
    {
        $res = Outbox::
        with([
            'message' =>  function($q) { 
                $q->select(['id', 'messages', 'message_type_id']); 
            }
        ])
        ->where(['is_active' => 1, 'batch_id' => (new Batch)->get_current_batch()])
        ->orderBy('id', 'DESC')
        ->groupBy('message_id')
        ->get();

        return $res->map(function($outbox) {
            return [
                'outboxID' => $outbox->message->id,
                'outboxIDs' => $outbox->message->id,
                'outboxMessage' => $outbox->message->messages,
                'outboxMessageType' => $outbox->message->message_type_id,
                'outboxContact' => (new Outbox)->where(['message_id' => $outbox->message->id, 'is_active' => 1, 'batch_id' => (new Batch)->get_current_batch()])->groupBy('msisdn')->count(),
                'outboxSuccessful' => (new Outbox)->where(['status' => 'success', 'message_id' => $outbox->message->id,'is_active' => 1, 'batch_id' => (new Batch)->get_current_batch()])->count(),
                'outboxPending' => (new Outbox)->where(['status' => 'pending', 'message_id' => $outbox->message->id,'is_active' => 1, 'batch_id' => (new Batch)->get_current_batch()])->count(),
                'outboxFailure' => (new Outbox)->where(['status' => 'failure', 'message_id' => $outbox->message->id,'is_active' => 1, 'batch_id' => (new Batch)->get_current_batch()])->count()
            ];
        });
    }

    public function fetch_all_template(Request $request)
    {   
        $templates = MessageTemplate::where(['is_active' => 1, 'message_type_id' => $request->get('type')])->get();
        $arr = array();
        foreach ($templates as $template) {
            $arr[] = array(
                'id' => $template->id,
                'code' => $template->code,
                'messages' => htmlentities($template->messages),
            );
        }
        echo json_encode( $arr ); exit();
    }
}