<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreAdminRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }
    public function rules()
    {
        $admin = $this->route('admin');
        return [
            'name' => 'required|string|max:255',
            'username' => [
                'required',
                'string',
                'max:255',
                'unique:admins,username'.$admin
            ],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                'unique:users,email'.$admin
            ],
            'status' => 'required|in:0,1',
            'authorization_id' => 'required|exists:authorizations,id',
        ];
        if ($this->isMethod('post')) {
            $rules['password'] = 'required|string|min:8|confirmed';
        }
    }

    public function messages()
    {
        return [
            'name.required' => 'The name field is required.',
            'username.required' => 'The username field is required.',
            'username.unique' => 'The username has already been taken.',
            'email.required' => 'The email field is required.',
            'email.email' => 'The email must be a valid email address.',
            'email.unique' => 'The email has already been taken.',
            'status.required' => 'The status field is required.',
            'password.required' => 'The password field is required.',
            'password.min' => 'The password must be at least 8 characters.',
            'password.confirmed' => 'The password confirmation does not match.'
        ];
    }
}
