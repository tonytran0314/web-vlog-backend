<?php

namespace App\Http\Requests\v1;

use Illuminate\Foundation\Http\FormRequest;

class VlogRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [
            'title' => [
                'required',
                'string',
                'max:255'
            ],
            'description' => [
                'required',
                'string'
            ],
            'public' => [
                'required',
                'boolean',
            ],
            'categories' => [
                'required'
            ]
        ];

        if($this->isMethod('post')) {
            $rules['video'] = [
                'required',
                'file',
                'mimes:mp4'
            ];
            $rules['thumbnail'] = [
                'required',
                'file',
                'mimes:jpg,png'
            ];
        }

        return $rules;
    }
}
