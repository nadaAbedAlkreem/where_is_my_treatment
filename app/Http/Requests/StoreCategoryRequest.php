<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Storage;

class StoreCategoryRequest extends FormRequest
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
    public function rules()
    {
         return [
             'name' => 'required|string|max:255',
             'image' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
             'description' => 'required|string|max:1000',
        ];
    }
    public function messages()
    {
        return [
            'name.required' => 'اسم الفئة مطلوب.',
            'name.string' => 'يجب أن يكون اسم الفئة نصاً.',
            'name.max' => 'يجب ألا يزيد اسم الفئة عن 255 حرفاً.',

            'image.required' => 'صورة الفئة مطلوب.',

            'image.image' => 'يجب أن يكون الملف صورة.',
            'image.mimes' => 'الصورة يجب أن تكون من نوع: jpg، jpeg، png، webp.',
            'image.max' => 'يجب ألا يتجاوز حجم الصورة 2 ميجابايت.',
            'description.required' => 'تفاصيل الفئة مطلوب.',

            'description.string' => 'يجب أن تكون الوصف نصياً.',
            'description.max' => 'يجب ألا يتجاوز الوصف 1000 حرف.',
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
    public function getData()
    {
        $data= $this::validated();


        if ($this->hasFile('image')) {
            $userName =  (!empty($data['name']))
                ? str_replace(' ', '_', $data['name']) . time() . rand(1, 10000000)
                : time() . rand(1, 10000000);

            $path = 'uploads/images/categories/';
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
