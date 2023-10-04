<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class UpdateProfileRequest extends FormRequest
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
            'first_name'=>'required',
            'middle_name'=>'required',
            'last_name'=>'required',
            'birthday'=>'required|date|before:today',
            'gender'=>['required', Rule::in(['Female','Male'])],
            'street'=>'required',
            'landmark'=>'required',
            'city'=>'required',
            'zip_code'=>'required',
            'company_name.*'=>'sometimes|required',
            'job_title.*'=>'sometimes|required',
            'start_date.*'=>'sometimes|required|date',
            'end_date.*'=>'sometimes|required|date|before:today',
            'accomplishments.*'=>'sometimes|required',
            // 'skills'=>'required',
            // 'languages'=>'required',
        ];
    }
    
    protected function prepareForValidation()
    {
        // dd(request()->all());
    }
}
