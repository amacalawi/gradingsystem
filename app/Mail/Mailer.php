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
                ->attach( public_path('email/'.$this->details['radio_attach'].'/'.$this->details['user_id'].'.pdf') )
                ->view(['html' => 'mails.email'])->with(compact('dtl'))
                ->from($this->details['from'], $this->details['from']);
            
        } else {
            $mail = $this->subject($this->details['subject'])
                ->view(['html' => 'mails.email'])->with(compact('dtl'))
                ->from($this->details['from'], $this->details['from']);

            if($this->details['attach']){
                $mail = $mail->attach( public_path( $this->details['attach'] ) );
            }
        }

        return $mail;
    }
}
