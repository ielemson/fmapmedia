<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreContactRequest extends FormRequest
{
    /**
     * Determine whether the user may submit the form.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Validation rules.
     */
    public function rules(): array
    {
        return [
            'first_name' => [
                'required',
                'string',
                'min:2',
                'max:50',
            ],

            'last_name' => [
                'required',
                'string',
                'min:2',
                'max:50',
            ],

            'email' => [
                'required',
                'email:rfc',
                'max:150',
            ],

            'phone' => [
                'nullable',
                'string',
                'max:30',
                'regex:/^[0-9+\-\s()]+$/',
            ],

            'subject' => [
                'required',
                'string',
                'min:3',
                'max:150',
            ],

            'message' => [
                'required',
                'string',
                'min:10',
                'max:5000',
            ],

            /*
            |--------------------------------------------------------------------------
            | Honeypot field
            |--------------------------------------------------------------------------
            |
            | Genuine visitors will leave this field empty. Automated bots often
            | populate every available input.
            |
            */
            'website' => [
                'nullable',
                'prohibited',
            ],
        ];
    }

    /**
     * Custom validation messages.
     */
    public function messages(): array
    {
        return [
            'first_name.required' => 'Please enter your first name.',
            'first_name.min' => 'Your first name must contain at least 2 characters.',
            'first_name.max' => 'Your first name may not exceed 50 characters.',

            'last_name.required' => 'Please enter your last name.',
            'last_name.min' => 'Your last name must contain at least 2 characters.',
            'last_name.max' => 'Your last name may not exceed 50 characters.',

            'email.required' => 'Please enter your email address.',
            'email.email' => 'Please enter a valid email address.',

            'phone.regex' => 'Please enter a valid phone number.',

            'subject.required' => 'Please enter the subject of your enquiry.',
            'subject.min' => 'The subject must contain at least 3 characters.',

            'message.required' => 'Please write your message.',
            'message.min' => 'Your message must contain at least 10 characters.',
            'message.max' => 'Your message may not exceed 5,000 characters.',

            'website.prohibited' => 'Your submission could not be processed.',
        ];
    }

    /**
     * Human-readable field names.
     */
    public function attributes(): array
    {
        return [
            'first_name' => 'first name',
            'last_name' => 'last name',
            'email' => 'email address',
            'phone' => 'phone number',
        ];
    }
}