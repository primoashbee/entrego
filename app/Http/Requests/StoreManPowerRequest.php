<?php

namespace App\Http\Requests;

use App\Models\ManPower;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class StoreManPowerRequest extends FormRequest
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
            'job_group'=>['required', Rule::in(collect(ManPower::JOB_GROUP)->pluck('value')->toArray())],
            'description'=>'required',
            'responsibilities'=>'required',
            'has_sjt'=>'nullable',
            'qualifications'=>'required',
            'benefits'=>'required',
            'vacancies'=>'required',
            'job_nature'=>'required',
            'location'=>'required',
            'expires_at'=>'required',
            'required_experience'=>'required',
            'department'=>'required',
            'quiz_id'=>'required_if_accepted:has_sjt',
            'job_level'=>'required',
        ];
    }

    public function messages()
    {
        return [
            'quiz_id.required_if_accepted' => 'The SJT/CSA is required if manpower request has SJT',
            'quiz_id.exists' => 'The SJT/CSA is invalid',

        ];
    }
}
