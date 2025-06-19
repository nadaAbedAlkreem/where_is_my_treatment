<?php

namespace App\Http\Requests\api;

use Illuminate\Foundation\Http\FormRequest;

class StoreTreatmentSearchRequest extends FormRequest
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
            'user_id' => 'required|integer|exists:users,id',
            'treatment_id' => 'required|integer|exists:treatments,id',
            'search_count' => 'nullable',

        ];
    }
    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        $errors = $validator->errors()->all();
        $formattedErrors = ['error' => $errors[0]] ;
        throw new \Illuminate\Validation\ValidationException($validator, response()->json([
            'success' => false,
            'message' => __('messages.ERROR_OCCURRED'),
            'data' => $formattedErrors,
            'status' => 'Internal Server Error'
        ], 500));
    }
    public  function getData()
    {
        $data=$this->validated();
        if($data['treatment_id'])
        {
           $data['ip_address'] = request()->ip() ;

        }

        return $data;
    }
    public function messages()
    {
        return [
            'user_id.required' => 'معرّف المستخدم مطلوب.',
            'user_id.integer' => 'يجب أن يكون معرف المستخدم رقماً صحيحاً.',
            'user_id.exists' => 'المستخدم غير موجود في قاعدة البيانات.',
            'treatment_id.required' => 'معرّف العلاج مطلوب.',
            'treatment_id.integer' => 'يجب أن يكون معرف العلاج رقماً صحيحاً.',
            'treatment_id.exists' => 'العلاج غير موجود في قاعدة البيانات.',
        ];
    }

}
