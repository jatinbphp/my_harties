<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ListingRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            'section' => 'required',
            'company_name' => 'required',
            'address' => 'required',
            'description' => 'required',
            'telephone_number' => 'required',
            'category' => 'required',
            'main_image' => 'mimes:jpeg,jpg,png,bmp,gif',
            'status' => 'required',
        ];

        return $rules;
    }
}
