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
            'job_group'=>['required', Rule::in(collect(ManPower::JOB_GROUP)->pluck('value')->toArray())],
            'description'=>'required',
            'responsibilities'=>'required',
            'qualifications'=>'required',
            'benefits'=>'required',
            'vacancies'=>'required',
            'job_nature'=>'required',
            'location'=>'required',
            'location'=>'required',
            'expires_at'=>'required',
            'required_experience'=>'required',
            'department'=>'required'
        ];
    }
}
