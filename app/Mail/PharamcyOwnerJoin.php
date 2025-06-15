<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PharamcyOwnerJoin extends Mailable
{
    use Queueable, SerializesModels;

    public $email , $password , $linkDashboard; // Token variable

    /**
     * Create a new message instance.
     */
    public function __construct($email  , $password , $linkDashboard)
    {
        $this->email = $email;
        $this->password = $password;
        $this->linkDashboard = $linkDashboard;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject('Accept subscription to the Where is My Treatment? application ')
                    ->view('emails.pharmacy-join')
                    ->with(['email' => $this->email , 'password'=>$this->password  , 'link' => $this->linkDashboard ]); // Pass the token to the view
    }
}
