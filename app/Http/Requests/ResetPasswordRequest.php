<?php

namespace App\Http\Requests;

use App\Models\Admin;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class ResetPasswordRequest extends FormRequest
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
            'id'=>['required'],
            'current_password' => [
                'required',
                'string',
                'min:8'] ,
            'new_password' => [
                'required',
                'string',
                'min:8' ,
                'different:current_password'] ,
            'confirm_password' => [
                'required',
                'string',
                'min:8',
                'same:new_password',] ,


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
    public function messages(): array
    {
        return [
            // current_password
            'current_password.required' => 'يرجى إدخال كلمة المرور الحالية.',
            'current_password.string' => 'كلمة المرور الحالية يجب أن تكون نصاً.',

            // new_password
            'new_password.required' => 'يرجى إدخال كلمة المرور الجديدة.',
            'new_password.string' => 'كلمة المرور الجديدة يجب أن تكون نصاً.',
            'new_password.min' => 'كلمة المرور الجديدة يجب أن لا تقل عن 8 أحرف.',
            'new_password.different' => 'يجب أن تكون كلمة المرور الجديدة مختلفة عن الحالية.',

            // confirm_password
            'confirm_password.required' => 'يرجى تأكيد كلمة المرور الجديدة.',
            'confirm_password.string' => 'تأكيد كلمة المرور يجب أن يكون نصاً.',
            'confirm_password.min' => 'تأكيد كلمة المرور يجب أن لا يقل عن 8 أحرف.',
            'confirm_password.same' => 'تأكيد كلمة المرور لا يطابق كلمة المرور الجديدة.',
        ];
    }
    public  function getData()
    {
        $data=$this->validated();

        $admin =Admin::find($data['id']);
        if (!Hash::check($data['current_password'], $admin->password))
        {
            throw ValidationException::withMessages([
                'new_password' => ['كلمة المرور غير صحيحة.'],
            ]);
        }

        return $data;
    }

}
