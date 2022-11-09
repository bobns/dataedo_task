<?php

namespace App\Modules\Mailing\Mails;

use App\Modules\Users\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AccountCreatedMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    private User $user;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build(): static
    {
        return $this->to($this->user->email)
            ->cc('support@company.com')
            ->subject('New account created')
            ->view('mails.account_created', ['user' => $this->user, 'message' => 'Account has beed created. You can log in as <b>' . $this->user->login . '</b>']);
    }
}
