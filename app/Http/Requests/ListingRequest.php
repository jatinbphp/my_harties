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
            'not_applicable' => 'nullable|boolean',
            'main_image' => 'required|mimes:jpeg,jpg,png,bmp,gif',
        ];
    
        if ($this->isMethod('patch')) {
            $rules['main_image'] = 'mimes:jpeg,jpg,png,bmp,gif';
        }
    
        // Check if 'not_applicable' is false (0)
        if (!$this->input('not_applicable')) {
            $rules['time'] = ['required', 'array'];
            $rules['time.*.from'] = ['required', 'date_format:H:i'];
            $rules['time.*.to'] = [
                'required',
                'date_format:H:i',
                function ($attribute, $value, $fail) {
                    $from = request(str_replace('.to', '.from', $attribute));
    
                    if (strtotime($value) <= strtotime($from)) {
                        $fail('The closing time must be after the opening time.');
                    }
                },
            ];
        } else {
            // If 'not_applicable' is true (1), time should not be required
            $rules['time'] = 'nullable';
            $rules['time.*.from'] = 'nullable';
            $rules['time.*.to'] = 'nullable';
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