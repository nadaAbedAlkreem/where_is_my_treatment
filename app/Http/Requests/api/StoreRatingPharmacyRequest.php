<?php

namespace App\Http\Requests\api;

use Illuminate\Foundation\Http\FormRequest;

class StoreRatingPharmacyRequest extends FormRequest
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
            'pharmacy_id' => 'required|integer|exists:pharmacies,id',
            'rating' => 'required|decimal:1,1',

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
        if($data['pharmacy_id'])
        {
            $data['type'] = 'pharmacy';
        }
        return $data;
    }
    public function messages()
    {
        return [
            'user_id.required' => 'معرّف المستخدم مطلوب.',
            'user_id.integer' => 'يجب أن يكون معرف المستخدم رقماً صحيحاً.',
            'user_id.exists' => 'المستخدم غير موجود في قاعدة البيانات.',

            'pharmacy_id.required' => 'معرّف الصيدلية مطلوب.',
            'pharmacy_id.integer' => 'يجب أن يكون معرف الصيدلية رقماً صحيحاً.',
            'pharmacy_id.exists' => 'الصيدلية غير موجود في قاعدة البيانات.',


            'rating.required' => 'قيمة التقيم  مطلوب.',
            'rating.integer' => 'يجب أن يكون التقيم رقماً عشري.',

        ];
    }
}
