<?php

namespace App\Modules\Users\Http\Requests;

use App\Http\Requests\Request;

class StoreRequest extends Request
{
    public function authorize()
    {
        return true;
    }

    public function messages()
    {
        return [
            'users.required' => trans('validation.required', ['attribute' => 'users']),
            'users.min' => trans('validation.min', ['attribute' => 'users']),
            'users.*.login.required' => trans('validation.required', ['attribute' => 'login']),
            'users.*.login.min' => trans('validation.min', ['attribute' => 'login']),
            'users.*.login.max' => trans('validation.max', ['attribute' => 'login']),
            'users.*.login.unique' => trans('validation.unique', ['attribute' => 'login']),
            'users.*.name.required' => trans('validation.required', ['attribute' => 'name']),
            'users.*.name.min' => trans('validation.min', ['attribute' => 'name']),
            'users.*.password.required' => trans('validation.required', ['attribute' => 'password']),
            'users.*.password.min' => trans('validation.min', ['attribute' => 'password']),
            'users.*.password.max' => trans('validation.max', ['attribute' => 'password']),
            'users.*.email.required' => trans('validation.required', ['attribute' => 'email']),
            'users.*.email.email' => trans('validation.email', ['attribute' => 'email']),
            'users.*.email.max' => trans('validation.max', ['attribute' => 'email']),
            'users.*.email.unique' => trans('validation.unique', ['attribute' => 'email']),
        ];
    }

    public function rules()
    {
        return [
            'users' => 'required|array|min:1',
            'users.*.login' => 'required|string|min:8|max:255|unique:users',
            'users.*.name' => 'required|string|min:10',
            'users.*.password' => 'required|string|min:8|max:255',         
            'users.*.email' => 'required|string|email|max:255|unique:users',
        ];
    }
}