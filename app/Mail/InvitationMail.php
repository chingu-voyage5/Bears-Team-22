<?php

namespace App\Mail;

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
        $user = $this->invite->user();

        if($user->has('roles')== 'trainer') {
            return $this->from($user->email)->view('emails.invite-client');
        }
        else if ($user->has('roles')== 'owner'){
            return $this->from($user->email)->view('emails.invite-trainer');
        }

    }
}
