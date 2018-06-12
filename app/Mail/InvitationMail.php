<?php

namespace App\Mail;

use App\User;
use App\Invite;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class InvitationMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Invite $invite)
    {
        $this->invite = $invite;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $this->user = $this->invite->user;

        if(User::find(1)->role->name == 'trainer') {
            return $this->from($this->user->email)->view('emails.invite-client', ['name' => $this->user->name, 
                                                                                'token' => $this->invite->token ]);
        }
        else if (User::find(1)->role->name == 'owner'){
            return $this->from($this->user->email)->view('emails.invite-trainer', ['name' => $this->user->name, 
                                                                                'token' => $this->invite->token ]);
        }

    }
}
