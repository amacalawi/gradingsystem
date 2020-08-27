<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Input;
use Illuminate\Mail\Mailable;
use App\Models\Batch;
use App\Models\Admission;
use App\Models\Group;
use App\Models\GroupUser;
use App\Models\Section;
use App\Models\Email;
use App\Models\EmailOutbox;
use App\User;
use App\Mail\Mailer;
use Config;

class EmailblastController extends Controller
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
        return view('modules/notifications/messaging/emailblast/new')->with(compact('menus'));
    }

    public function new()
    {   
        $menus = $this->load_menus();
        $email = (new Email)->all_email();
        $groups = Group::where('is_active', 1)->get();
        $sections = Section::where('is_active', 1)->get();
        $users = User::where('id', '!=', 1)->where('is_active', 1)->get();
        return view('modules/notifications/messaging/emailblast/new')->with(compact('menus', 'email', 'groups', 'sections', 'users'));
    }

    public function store(Request $request)
    {
        /*
        $timestamp = date('Y-m-d H:i:s');
        $radio_autoattachment = $request->radio_autoattachment;
        
        $emailoutbox = EmailOutbox::create([
            'email_id' => $request->sender,
            'subject' => $request->subject,
            'message' => $request->message_editor,
            $radio_autoattachment => '1',
            'created_at' => $timestamp,
            'created_by' => Auth::user()->id
        ]);

        if (!$emailoutbox) {
            throw new NotFoundHttpException();
        }
        
        $this->send($request->sender, $request->user, $request->subject, $request->message_editor);

        $data = array(
            'title' => 'Well done!',
            'text' => 'The email has been sent.',
            'type' => 'success',
            'class' => 'btn-brand'
        );

        echo json_encode( $data ); exit();
        */
    }

    public function send()
    {
        $registered = $this->register(Input::get('sender'));

        if($registered)
        {
            $groups = Input::get('group');
            $sections = Input::get('section');
            $users = Input::get('user');
            $emails = [];

            if($groups){
                foreach($groups as $group){
                    $users_emails = GroupUser::select('email', 'users.id')->where('groups_users.group_id', $group)->join('users', 'users.id', '=', 'groups_users.users_id')->where('users.is_active', 1)->get();
                    foreach($users_emails as $user_email){
                        if (!in_array($user_email->email, $emails)){
                            array_push($emails, $user_email->email);
                        }
                    }
                }
            }
            if($sections){
                foreach($sections as $section){
                    $users_emails = Admission::select('email', 'users.id')->where('admissions.section_id', $section)->join('users', 'users.id', '=', 'admissions.student_id')->where('users.is_active', 1)->get();
                    foreach($users_emails as $user_email){
                        if (!in_array($user_email->email, $emails)){
                            array_push($emails, $user_email->email);
                        }
                    }
                }
            }
            if($users){
                foreach($users as $user){
                    $users_emails = User::select('email', 'users.id')->where('id', $user)->where('users.is_active', 1)->get();
                    foreach($users_emails as $user_email){
                        if (!in_array($user_email->email, $emails)){
                            array_push($emails, $user_email->email);
                        }
                    }
                }
            }

            if($emails){

                $email_id = Input::get('sender');
                $message_subject = Input::get('subject');
                $message_editor = Input::get('message_editor');
                $radio_autoattachment = Input::get('radio_autoattachment');

                foreach($emails as $email){

                    $details = [
                        "to" => $email,
                        "from" => $registered,
                        "subject" => $message_subject,
                        "body"  => $message_editor
                    ];
    
                    Mail::to($email)->send(new Mailer($details));
                    $this->outbox($email_id, $email, $message_subject, $message_editor, $radio_autoattachment);

                }

                $data = array(
                    'title' => 'Well done!',
                    'text' => 'The email has been sent.',
                    'type' => 'success',
                    'class' => 'btn-brand'
                );
                echo json_encode( $data ); exit();

            } else {
                $data = array(
                    'title' => 'Warning!',
                    'text' => 'No email address for recipient defined.',
                    'type' => 'warning',
                    'class' => 'btn-brand'
                );
                echo json_encode( $data ); exit();
            }

        } else {
            $data = array(
                'title' => 'Warning!',
                'text' => 'Unregistered Sender.',
                'type' => 'warning',
                'class' => 'btn-brand'
            );
            echo json_encode( $data ); exit();
        }

    }

    public function register($sender_id)
    {
        $mail = Email::where('id', $sender_id)->first();

        if ($mail)
        {
            $config = array(
                'driver'     => config('mail.driver'),
                'host'       => config('mail.host'),
                'port'       => config('mail.port'),
                'from'       => array('address' => config('mail.from.address'), 'name' => config('mail.from.name') ),
                'encryption' => 'tls',
                'username'   => $mail->email,
                'password'   => $mail->password,
                'sendmail'   => '/usr/sbin/sendmail -bs',
            );
            Config::set('mail', $config);
            
            return $mail->email;

        } else {
            return 0;
        }
    }

    public function manage_outbox(Request $request)
    {   
        $menus = $this->load_menus();
        return view('modules/notifications/messaging/emailblast/manage-outbox')->with(compact('menus'));
    }

    public function all_active_outbox(Request $request)
    {
        $res = EmailOutbox::with([
            'email' =>  function($q) { 
                $q->select(['id', 'email']); 
            }
        ])
        ->where('is_active', 1)->orderBy('id', 'DESC')->get();

        return $res->map(function($emailoutbox) {

            if($emailoutbox->is_soa){
                $type = 'SOA';
            }elseif($emailoutbox->is_payslip){
                $type = 'PAYSLIP';
            }elseif($emailoutbox->is_grade){
                $type = 'GRADE';
            }else{
                $type = 'NORMAL';
            }

            return [
                'emailblastoutboxID' => $emailoutbox->id,
                'emailblastoutboxEmailSender' => $emailoutbox->email->email,
                'emailblastoutboxEmailRecipient' => $emailoutbox->email_recipient,
                'emailblastoutboxSubject' => $emailoutbox->subject,
                'emailblastoutboxMessage' => $emailoutbox->message,
                'emailblastoutboxType' => $type,
                'emailblastoutboxModified' => ($emailoutbox->updated_at !== NULL) ? date('d-M-Y', strtotime($emailoutbox->updated_at)).'<br/>'. date('h:i A', strtotime($emailoutbox->updated_at)) : date('d-M-Y', strtotime($emailoutbox->created_at)).'<br/>'. date('h:i A', strtotime($emailoutbox->created_at))
            ];
        });
    }

    public function outbox($email_id, $email_recipient, $message_subject, $message_editor, $radio_autoattachment)
    {
        $timestamp = date('Y-m-d H:i:s');
        
        $emailoutbox = EmailOutbox::create([
            'email_id' => $email_id,
            'email_recipient' => $email_recipient,
            'subject' => $message_subject,
            'message' => $message_editor,
            $radio_autoattachment => '1',
            'created_at' => $timestamp,
            'created_by' => Auth::user()->id
        ]);

    }

    public function settings()
    {
        $menus = $this->load_menus();
        return view('modules/notifications/messaging/emailblast/settings')->with(compact('menus'));
    }

    public function all_active_settings()
    {
        $res = Email::where('is_active', 1)->orderBy('id', 'DESC')->get();

        return $res->map(function($email) {
            return [
                'emailID' => $email->id,
                'emailUsername' => $email->username,
                'emailEmail' => $email->email,
                'emailModified' => ($email->updated_at !== NULL) ? date('d-M-Y', strtotime($email->updated_at)).'<br/>'. date('h:i A', strtotime($email->updated_at)) : date('d-M-Y', strtotime($email->created_at)).'<br/>'. date('h:i A', strtotime($email->created_at))
            ];
        });
    }

    public function add_settings(Request $request, $id = '')
    {
        $menus = $this->load_menus();
        $flashMessage = self::messages();
        $segment = request()->segment(5);
        $email = (new Email)->fetch($id);
        return view('modules/notifications/messaging/emailblast/settings-add')->with(compact('menus', 'email', 'segment'));
    }

    public function edit_settings(Request $request, $id)
    {
        $menus = $this->load_menus();
        $flashMessage = self::messages();
        $segment = request()->segment(5);
        $email = (new Email)->fetch($id);
        return view('modules/notifications/messaging/emailblast/settings-edit')->with(compact('menus', 'email', 'segment'));
    }

    public function store_settings(Request $request)
    {
        $timestamp = date('Y-m-d H:i:s');

        $emailsettings = Email::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => $request->password,
            'created_at' => $timestamp,
            'created_by' => Auth::user()->id
        ]);

        if (!$emailsettings) {
            throw new NotFoundHttpException();
        }

        $data = array(
            'title' => 'Well done!',
            'text' => 'The email account has been successfully saved.',
            'type' => 'success',
            'class' => 'btn-brand'
        );

        echo json_encode( $data ); exit();
    }

    public function update_settings(Request $request, $id)
    {
        $timestamp = date('Y-m-d H:i:s');
        $emailsettings = Email::find($id);

        if(!$emailsettings) {
            throw new NotFoundHttpException();
        }

        $emailsettings->username = $request->username;
        $emailsettings->email = $request->email;
        $emailsettings->password = $request->password;
        $emailsettings->updated_at = $timestamp;
        $emailsettings->updated_by = Auth::user()->id;

        if ($emailsettings->update()) {

            $data = array(
                'title' => 'Well done!',
                'text' => 'The email account has been successfully updated.',
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
            $emailsettings = Email::where([
                'id' => $id,
            ])
            ->update([
                'updated_at' => $timestamp,
                'updated_by' => Auth::user()->id,
                'is_active' => 0
            ]);
            
            $data = array(
                'title' => 'Well done!',
                'text' => 'The email account has been successfully removed.',
                'type' => 'success',
                'class' => 'btn-brand'
            );
    
            echo json_encode( $data ); exit();
        }
    }

}
