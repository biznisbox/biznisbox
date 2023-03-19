<?php

namespace App\Mail\Auth;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\User;

class PasswordReset extends Mailable
{
    use Queueable, SerializesModels;

    public $token;
    public $user;
    public $url;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($token, User $user)
    {
        $this->token = $token;
        $this->user = $user;
        $this->url = url('/auth/set-password/' . $user->email . '?token=' . $token);
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.auth.reset_password')
            ->with([
                'token' => $this->token,
                'user' => $this->user,
                'url' => $this->url,
            ])
            ->subject('Reset Password');
    }
}
