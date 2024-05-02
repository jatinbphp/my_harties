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
            'website_address' => 'nullable|url',
            'category' => 'required',
            'status' => 'required',
            'time' => 'required|array',
            'time.*.from' => 'required|date_format:H:i',
            'time.*.to' => [
                'required',
                'date_format:H:i',
                function ($attribute, $value, $fail) {
                    $from = $this->input(str_replace('.to', '.from', $attribute));

                    // If the 'to' time is '00:00', consider it valid
                    if ($value === '00:00') {
                        return;
                    }

                    if (strtotime($value) <= strtotime($from)) {
                        $fail('The '.$attribute.' must be a time after the from time.');
                    }
                },
            ],
            'main_image' => 'required|mimes:jpeg,jpg,png,bmp,gif',
        ];

        if ($this->isMethod('patch')) {
            $rules['main_image'] = 'jpeg,jpg,png,bmp,gif';
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