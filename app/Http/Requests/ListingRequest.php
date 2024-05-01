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
            'email' => 'required|required',
            'website_address' => 'required|url',
            'category' => 'required',
            'main_image' => 'mimes:jpeg,jpg,png,bmp,gif',
            'status' => 'required',
            'time' => 'required|array',
            'time.*.from' => 'required|date_format:H:i',
            'time.*.to' => 'required|date_format:H:i|after:time.*.from',
            'main_image' => 'required|mimes:jpeg,jpg,png,bmp',
        ];

        if ($this->isMethod('patch')) {
            $rules['image'] = 'mimes:jpeg,jpg,png,bmp';
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'time.*.from.required' => 'The open hour is required for all days.',
            'time.*.from.date_format' => 'The open hour must be in the format HH:MM.',
            'time.*.to.required' => 'The close hour is required for all days.',
            'time.*.to.date_format' => 'The close hour must be in the format HH:MM.',
            'time.*.to.after' => 'The close hour must be after the open hour.',
        ];
    }
}