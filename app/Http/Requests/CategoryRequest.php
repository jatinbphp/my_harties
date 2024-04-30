<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [
            'section' => 'required',
            'name' => 'required',
            'image' => 'required|mimes:jpeg,jpg,png,bmp,gif',
            'status' => 'required',
        ];

        if ($this->isMethod('patch')) {
            $rules['image'] = 'nullable|mimes:jpeg,jpg,png,bmp,gif';
        }

        return $rules;
    }
}
