<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }


    public function rules()
    {
        return [
            'name' => ['required', 'string'],
            'email' => ['required', 'email'],
            'phone' => ['required', 'string'],
            'title' => ['required', 'string'],
            'body' => ['required', 'string'],
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'The name field is required.',
        'name.string' => 'The name must be a string.',
        'email.required' => 'The email field is required.',
        'email.email' => 'The email must be a valid email address.',
        'phone.required' => 'The phone field is required.',
        'phone.string' => 'The phone must be a string.',
        'title.required' => 'The title field is required.',
        'title.string' => 'The title must be a string.',
        'body.required' => 'The body field is required.',
        'body.string' => 'The body must be a string.',
        ];
    }
}
