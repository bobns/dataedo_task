<?php

use Illuminate\Support\Facades\Route;
use App\Modules\Users\Http\Controllers\UserController;

Route::post('store-users', [UserController::class, 'storeUsers'])->name('users.storeUsers');
Route::put('update-users', [UserController::class, 'updateUsers'])->name('users.updateUsers');
