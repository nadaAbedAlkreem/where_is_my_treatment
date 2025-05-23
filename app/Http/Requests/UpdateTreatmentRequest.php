<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class UpdateTreatmentRequest extends FormRequest
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
            'id_update' => 'required' ,
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'about_the_medicine' => 'nullable|string|max:1000',
            'how_to_use' => 'nullable|string|max:1000',
            'instructions' => 'nullable|string|max:1000',
            'side_effects' => 'nullable|string|max:1000',
            'image' => 'image|mimes:jpg,jpeg,png,webp|max:2048',
            'status_approved' => 'nullable|boolean',
        ];
    }

    public function messages()
    {
        return [
            'category_id.required' => 'الفئة مطلوبة.',
            'category_id.exists' => 'الفئة غير موجودة في قاعدة البيانات.',
            'id_update.required' => 'معرف مطلوبة.',

            'name.required' => 'اسم الدواء مطلوب.',
            'name.string' => 'يجب أن يكون اسم الدواء نصاً.',
            'name.max' => 'يجب ألا يزيد اسم الدواء عن 255 حرفاً.',

            'description.required' => 'الوصف مطلوب.',
            'description.string' => 'يجب أن يكون الوصف نصياً.',
            'description.max' => 'يجب ألا يتجاوز الوصف 1000 حرف.',

            'about_the_medicine.string' => 'حول الدواء يجب أن يكون نصياً.',
            'how_to_use.string' => 'كيفية الاستخدام يجب أن تكون نصاً.',
            'instructions.string' => 'التعليمات يجب أن تكون نصاً.',
            'side_effects.string' => 'الآثار الجانبية يجب أن تكون نصاً.',

            'image.required' => 'صورة الدواء مطلوبة.',
            'image.image' => 'يجب أن يكون الملف صورة.',
            'image.mimes' => 'الصورة يجب أن تكون من نوع: jpg، jpeg، png، webp.',
            'image.max' => 'يجب ألا يتجاوز حجم الصورة 2 ميجابايت.',

            'status_approved.boolean' => 'حالة الموافقة يجب أن تكون نعم أو لا.',
        ];
    }

    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        $errors = $validator->errors()->all();
        $formattedErrors = ['error' => $errors[0]];
        throw new \Illuminate\Validation\ValidationException($validator, response()->json([
            'success' => false,
            'message' => __('messages.ERROR_OCCURRED'),
            'data' => $formattedErrors,
            'status' => 'Internal Server Error'
        ], 500));
    }

    public function getData()
    {
        $data = $this->validated();

        if ($this->hasFile('image')) {
            $userName = (!empty($data['name']))
                ? str_replace(' ', '_', $data['name']) . time() . rand(1, 10000000)
                : time() . rand(1, 10000000);

            $path = 'uploads/images/medicines/';
            $nameImage = $userName . '.' . $this->file('image')->getClientOriginalExtension();

            Storage::disk('public')->put($path . $nameImage, file_get_contents($this->file('image')));
            $this->file('image')->move('storage/' . $path, $nameImage);

            $absolutePath = storage_path('app/public/' . $path . $nameImage);
            if (file_exists($absolutePath)) {
                chmod($absolutePath, 0775);
            } else {
                throw new \Exception(__('messages.ERROR_OCCURRED') . $absolutePath);
            }

            $data['image'] = Storage::url($path . $nameImage);
        }
        $currentUser = Auth::user();
        $status_approved = ($currentUser->roles->first()->name == 'admin')? 'approved': 'pending' ;
        $data['status_approved'] = $status_approved ;




        return $data;
    }

}
