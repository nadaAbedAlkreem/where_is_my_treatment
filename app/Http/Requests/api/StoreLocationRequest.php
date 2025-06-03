<?php

namespace App\Http\Requests\api;

use Illuminate\Foundation\Http\FormRequest;

class StoreLocationRequest extends FormRequest
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
            'user_id'   => 'required|integer|exists:users,id',
            'latitude'          => 'required|numeric|between:-90,90',
            'longitude'         => 'required|numeric|between:-180,180',
            'formatted_address' => 'required|string',
            'country'           => 'required|string|max:255',
            'region'            => 'required|string|max:255',
            'city'              => 'required|string|max:255',
            'district'          => 'required|string|max:255',
            'postal_code'       => 'required|string|max:20',
            'location_type'     => 'required|string|max:50',
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
        if($data['user_id'])
        {
            $data['locationable_id'] = $data['user_id'] ;
            $data['locationable_type'] = 'App\Models\User' ;
        }


        return $data;
    }
    public function messages()
    {
        return [
            'user_id.required' => 'معرّف المستخدم مطلوب.',
            'user_id.integer' => 'يجب أن يكون معرف المستخدم رقماً صحيحاً.',
            'user_id.exists' => 'المستخدم غير موجود في قاعدة البيانات.',

            'latitude.required' => 'إحداثيات العرض (Latitude) مطلوبة.',
            'latitude.numeric' => 'يجب أن تكون إحداثيات العرض رقماً.',
            'latitude.between' => 'يجب أن تكون إحداثيات العرض بين -90 و 90.',

            'longitude.required' => 'إحداثيات الطول (Longitude) مطلوبة.',
            'longitude.numeric' => 'يجب أن تكون إحداثيات الطول رقماً.',
            'longitude.between' => 'يجب أن تكون إحداثيات الطول بين -180 و 180.',

            'formatted_address.required' => 'العنوان الكامل مطلوب.',
            'formatted_address.string' => 'يجب أن يكون العنوان الكامل نصاً.',

            'country.required' => 'اسم الدولة مطلوب.',
            'country.string' => 'يجب أن يكون اسم الدولة نصاً.',
            'country.max' => 'يجب ألا يزيد اسم الدولة عن 255 حرفاً.',

            'region.required' => 'اسم المنطقة مطلوب.',
            'region.string' => 'يجب أن يكون اسم المنطقة نصاً.',
            'region.max' => 'يجب ألا يزيد اسم المنطقة عن 255 حرفاً.',

            'city.required' => 'اسم المدينة مطلوب.',
            'city.string' => 'يجب أن يكون اسم المدينة نصاً.',
            'city.max' => 'يجب ألا يزيد اسم المدينة عن 255 حرفاً.',

            'district.required' => 'اسم الحي أو المنطقة الفرعية مطلوب.',
            'district.string' => 'يجب أن يكون اسم الحي أو المنطقة الفرعية نصاً.',
            'district.max' => 'يجب ألا يزيد اسم الحي عن 255 حرفاً.',

            'postal_code.required' => 'الرمز البريدي مطلوب.',
            'postal_code.string' => 'يجب أن يكون الرمز البريدي نصاً.',
            'postal_code.max' => 'يجب ألا يزيد الرمز البريدي عن 20 حرفاً.',



            'location_type.required' => 'نوع الموقع مطلوب.',
            'location_type.string' => 'يجب أن يكون نوع الموقع نصاً.',
            'location_type.max' => 'يجب ألا يزيد نوع الموقع عن 50 حرفاً.',
        ];
    }

}
