<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

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

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response()->json([
                'status' => 422,
                'errors' => $validator->errors(),
            ], 422)
        );
    }
}
