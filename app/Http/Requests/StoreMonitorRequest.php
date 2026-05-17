<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreMonitorRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {   //allow all requests for now
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            
        'url' => [
            'required',
            'url:http,https',
            'unique:monitors,url'
        ],

        'check_interval' => [
            'nullable',
            'integer',
            'min:1',
            'max:60'
        ],

        'threshold' => [
            'nullable',
            'integer',
            'min:1'
        ]
        ];
    }
}
