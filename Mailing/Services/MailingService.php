<?php

namespace App\Modules\Mailing\Services;

use App\Users\Models\User;
use Illuminate\Support\Facades\Mail;

class MailingService
{
    public static function sendEmail(User $user, $mailClass)
    {
        Mail::to($user->email)->queue($mailClass);
    }
}