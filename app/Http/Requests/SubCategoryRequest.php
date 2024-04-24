<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SubCategoryRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [
            'category' => 'required',
            'name' => 'required',
            'status' => 'required',
        ];

        /*if ($this->isMethod('patch')) {
            $rules['name'] .= '|unique:categories,name,' . $this->category->id;
        } else {
            $rules['name'] .= '|unique:categories';
        }*/

        return $rules;
    }
}
