<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends FormRequest
{
    private $except = "";
    private $hasPassword = true;
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
            'first_name'=>'required',
            'middle_name'=>'required',
            'last_name'=>'required',
            'birthday'=>'required|date|before:today',
            'gender'=>['required', Rule::in(['Female','Male'])],
            'street'=>'required',
            'landmark'=>'required',
            'contact_number'=>'required|unique:users,contact_number,'.$this->except,
            'city'=>'required',
            'barangay'=>'required',
            'zip_code'=>'required',
            'password'=>'sometimes|required|confirmed',
            'cv'=>'sometimes|mimes:pdf,doc,docx',
            'requirement.*'=>'sometimes|mimes:pdf,doc,docx',
            'password' => ['required','confirmed', Password::min(8)
                                                            ->letters()
                                                            ->mixedCase()
                                                            ->numbers()
                                                            ->symbols()
                        ]
            // 'company_name.*'=>'sometimes|required',
            // 'job_title.*'=>'sometimes|required',
            // 'start_date.*'=>'sometimes|required|date',
            // 'end_date.*'=>'sometimes|required|date|before:today',
            // 'accomplishments.*'=>'sometimes|required',
            // 'skills'=>'required',
            // 'languages'=>'required',
        ];

        if($this->hasPassword){
            unset($rules['password']);
        }

        return $rules;
    }
    
    protected function prepareForValidation()
    {
        $this->except = request()->route('id') !== null ? request()->route('id') : auth()->user()->id;
        if(request()->password !== null){
            $this->hasPassword = false;
        }
    }
}
