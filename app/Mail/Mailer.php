<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class Mailer extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($details)
    {
        $this->details = $details;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $dtl = $this->details;

        if( $this->details['radio_attach'] ){
            $mail = $this->subject($this->details['subject'])
                ->attach( storage_path('app/public/uploads/uploads/file-management/'.str_replace("is_","",$this->details['radio_attach']).'/'.$this->details['user_id'].'.pdf') )
                ->view(['html' => 'mails.email'])->with(compact('dtl'))
                ->from($this->details['from'], $this->details['from']);
        } else {
            $mail = $this->subject($this->details['subject'])
                ->view(['html' => 'mails.email'])->with(compact('dtl'))
                ->from($this->details['from'], $this->details['from']);

            if( count($this->details['attach']) > 0 ){
                for($x=0; $x < count( $this->details['attach'] ); $x++){
                    $mail->attach( storage_path('app/public/uploads/emails/'.$this->details['attach'][$x] ));
                }
            }
        }

        return $mail;
    }
}
