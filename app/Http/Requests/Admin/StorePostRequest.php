<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StorePostRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'required|max:255',
            'small_desc' => 'required|min:3',
            'desc' => 'required|min:3',
            'status' => 'required|in:0,1',
            'category' => 'exists:categories,id',
            'images' => 'nullable',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'title.required' => 'The title field is required.',
            'small_desc.required' => 'The small description field is required.',
            'desc.required' => 'The description field is required.',
            'status.required' => 'The status field is required.',
            'status.in' => 'The status field is invalid.',
            'category.required' => 'The category field is required.',
            'category.exists' => 'The selected category is invalid.',
            'images.required' => 'At least one image is required.',
            'images.*.image' => 'Each file must be an image.',
            'images.*.mimes' => 'Each image must be a file of type: jpeg, png, jpg, gif, svg.',
            'images.*.max' => 'Each image may not be greater than 2MB in size.',
        ];
    }
}
