<?php

namespace App\Http\Requests\api\auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;

class RegisterUserRequest extends FormRequest
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
            'image' =>  $this->hasFile('image')
                ? 'file|mimes:jpeg,png,jpg,gif,svg|max:2048'
                : 'string|max:255',
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,NULL,id,deleted_at,NULL',
            'phone' => 'required|string|unique:users,phone',
            'password' => [
                'required',
                'string',
                'min:8'
                ]

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
            'image.required' => 'حقل الصورة مطلوب.',
            'image.file' => 'يجب أن تكون الصورة ملفًا.',
            'image.mimes' => 'يجب أن تكون الصورة من نوع: jpeg، png، jpg، gif، svg.',
            'image.max' => 'يجب ألا يتجاوز حجم الصورة 2 ميغابايت.',
            'image.string' => 'يجب أن تكون الصورة نصًا في حال عدم رفع ملف.',

            'name.required' => 'الاسم مطلوب.',
            'name.string' => 'يجب أن يكون الاسم نصًا.',
            'name.max' => 'يجب ألا يتجاوز الاسم 255 حرفًا.',

            'email.required' => 'البريد الإلكتروني مطلوب.',
            'email.string' => 'يجب أن يكون البريد الإلكتروني نصًا.',
            'email.email' => 'يجب إدخال بريد إلكتروني صالح.',
            'email.max' => 'يجب ألا يتجاوز البريد الإلكتروني 255 حرفًا.',
            'email.unique' => 'البريد الإلكتروني مستخدم بالفعل.',

            'phone.required' => 'الرقم التواصل مطلوب.',
            'phone.string' => 'يجب أن يكون الرقم التواصل نصًا.',
            'phone.unique' => 'الرقم التواصل مستخدم بالفعل.',

            'password.required' => 'كلمة المرور مطلوبة.',
            'password.string' => 'يجب أن تكون كلمة المرور نصًا.',
            'password.min' => 'يجب ألا تقل كلمة المرور عن 8 أحرف.',
            'password.confirmed' => 'تأكيد كلمة المرور غير مطابق.',
        ];
    }
    public function getData()
    {
        $data= $this::validated();


        if ($this->hasFile('image')) {
            $userName =  (!empty($data['name']))
                ? str_replace(' ', '_', $data['name']) . time() . rand(1, 10000000)
                : time() . rand(1, 10000000);

            $path = 'uploads/images/users/';
            $nameImage = $userName . '.' . $this->file('image')->getClientOriginalExtension();
            Storage::disk('public')->put($path . $nameImage, file_get_contents($this->file('image')));
            $this->file('image')->move('storage/'.($path), $nameImage);


            $absolutePath = storage_path('app/public/' . $path . $nameImage);
            if (file_exists($absolutePath)) {
                chmod($absolutePath, 0775);
            } else {
                throw new \Exception(__('messages.ERROR_OCCURRED') . $absolutePath);
            }

            $data['image'] = Storage::url($path . $nameImage);
        }



        return $data;
    }


}
