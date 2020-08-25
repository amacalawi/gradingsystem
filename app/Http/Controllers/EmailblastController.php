<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Mail\Mailable;
use App\Models\Batch;
use App\Models\Group;
use App\Models\Section;
use App\Models\Email;
use App\Models\EmailOutbox;
use App\User;
use App\Mail;

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
    }

    public function send($sender, $receiver, $subject, $message)
    {
        $receiver = (new User)->where('id', $receiver)->first()->email;
        
        $details = [
            'to' => 'jinkevind@gmail.com',
            'from' => 'jinkevind@gmail.com',
            'subject' => 'test',
            'title' => 'tesr',
            "body"  => 'body'
        ];

        Mail::to('jinkevind@gmail.com')->send(new \App\Mail\Mailer($details));
    }
}
