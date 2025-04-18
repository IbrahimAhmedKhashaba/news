<?php

namespace App\Http\Requests\Admin;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class StoreCategoryRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }
    public function rules()
    {
        $categoryId = $this->route('category');
        return [
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('categories')->ignore($categoryId, 'id'),
            ],
            'small_desc' => [
                'required',
                'string',
                'min:8',
            ],
            'status' => 'required|in:0,1',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'The name field is required.',
            'small_desc.required' => 'The small desc field is required.',
            'small_desc.min' => 'The small desc must be at least 8 characters.',
            'status.required' => 'The status field is required.',
            'status.in' => 'The status must be 0 or 1.',
        ];
    }
}
