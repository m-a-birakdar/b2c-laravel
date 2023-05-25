<?php

namespace Modules\User\Emails\CuApi\V1;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class VerifyEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $resetUrl;
    public $user;

    /**
     * Create a new message instance.
     *
     * @param  string  $resetUrl
     * @param  \App\Models\User  $user
     * @return void
     */
    public function __construct($resetUrl, $user)
    {
        $this->resetUrl = $resetUrl;
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('user::emails.reset-password')
            ->subject('Reset Your Password')
            ->with([
                'resetUrl' => $this->resetUrl,
                'user' => $this->user,
            ]);
    }
}
