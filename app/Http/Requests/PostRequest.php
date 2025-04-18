<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }


    public function rules()
    {
        return [
            'comment' => 'required|string',
            'post_id' => [
                'required',
                'integer',
                'exists:posts,id',
            ],
        ];
    }

    public function messages()
    {
        return [
            'comment.required' => 'The comment field is required.',
            'comment.string' => 'The comment must be a string.',
            'post_id.required' => 'The post ID field is required.',
            'post_id.integer' => 'The post ID must be an integer.',
            'post_id.exists' => 'The selected post ID is invalid.  This post does not exist.',
        ];
    }
}
