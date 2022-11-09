<?php

namespace App\Modules\Users\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Mailing\Mails\AccountCreatedMail;
use App\Modules\Mailing\Services\MailingService;
use App\Modules\Users\Http\Requests\StoreRequest;
use App\Modules\Users\Http\Requests\UpdateRequest;
use App\Modules\Users\Http\Services\UserService;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    private UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function updateUsers(UpdateRequest $request)
    {
        foreach ($request->input('users') as $user) {
            try {
                $this->userService->updateUser($user);
            } catch (\Throwable $e) {
                Log::error($e);
                return redirect()->back()->with('error', "We couldn\'t update user. Something went wrong on server side. Please try then later or contact with administrator");
            }
        }
        return redirect()->back()->with('success', 'All users updated.');
    }

    public function storeUsers(StoreRequest $request)
    { 
        foreach ($request->input('users') as $user) {
            try {
                $userModel = $this->userService->storeUser($user);
                MailingService::sendEmail($userModel, new AccountCreatedMail($userModel))		
            } catch (\Throwable $e) {
                Log::error($e);
                return redirect()->back()->with('error', "We couldn\'t store user. Something went wrong on server side. Please try then later or contact with administrator");
            }
        }
        return redirect()->back()->with('success', 'All users created.');
    }

}