<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class StoreAdminRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:admins,email,NULL,id,deleted_at,NULL',
            'phone' => [
                'required',
                'string',
                function ($attribute, $value, $fail) {
                    $phoneWithPrefix = request()->country_prefix . $value;
                    if (\App\Models\Admin::where('phone', $phoneWithPrefix)->exists()) {
                        $fail(__('messages.phone.unique', ['attribute' => $attribute]));
                    }
                },
            ],
            'password' => [
                'required',
                'string',
                 'min:8']
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
    public function messages()
    {
        return [

            'name.required' => __('messages.name.required'),
            'name.string' => __('messages.name.string'),
            'name.max' => __('messages.name.max'),

            'email.required' => __('messages.email.required'),
            'email.string' => __('messages.email.string'),
            'email.email' => __('messages.email.email'),
            'email.max' => __('messages.email.max'),
            'email.unique' => __('messages.email.unique'),

            'phone.required' => __('messages.phone.required'),
            'phone.string' => __('messages.phone.string'),
            'phone.unique' => __('messages.phone.unique'),
            'phone.prefix' => __('messages.phone.prefix'),

            'password.required' => __('messages.password.required'),
            'password.string' => __('messages.password.string'),
            'password.min' => __('messages.password.min', ['min' => 8]),
            'password.confirmed' => __('messages.password.confirmed'),

        ];
    }

    public  function getData()
    {
        $data=$this->validated();

        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }
        $data['status_approved_for_pharmacy'] = 'pending';


        return $data;
    }


}
