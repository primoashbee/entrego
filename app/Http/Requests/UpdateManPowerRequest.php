<?php

namespace App\Http\Requests;

use App\Models\ManPower;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateManPowerRequest extends FormRequest
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
        return [
            'job_title'=>'required',
            'description'=>'required',
            'has_sjt'=>'nullable',
            'responsibilities'=>'required',
            'qualifications'=>'required',
            'benefits'=>'required',
            'vacancies'=>'required',
            'job_nature'=>'required',
            'location'=>'required',
            'location'=>'required',
            'expires_at'=>'required',
            'required_experience'=>'required',
            'department'=>'required',
            'quiz_id'=>'required_if_accepted:has_sjt',
            'job_level'=>'required'

        ];
    }

    public function messages()
    {
        return [
            'quiz_id.required' => 'The SJT/CSA is required',
            'quiz_id.exists' => 'The SJT/CSA is invalid',
        ];
    }
}
