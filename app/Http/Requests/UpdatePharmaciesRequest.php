<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UpdatePharmaciesRequest extends FormRequest
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
            'id_update' => '' ,
            'name_pharmacy' => 'required|string|max:255',
            'image_pharmacy' => 'image',
            'license_number' => 'required|string',
            'license_file_path' => 'file',
            'license_expiry_date' => 'required|date',
            'phone_number_pharmacy' => 'required|string|max:20',
            'email_pharmacy' => 'required|email',
            'status_exist' => 'required|in:open,closed',
            'description' => 'nullable|string',
            'working_hours' => 'required|string',


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
            // رسائل التحقق للمالك (admin)


            'pharmacy.name_pharmacy.required' => 'حقل اسم الصيدلية مطلوب.',
            'pharmacy.name_pharmacy.string' => 'اسم الصيدلية يجب أن يكون نصًا.',
            'pharmacy.name_pharmacy.max' => 'اسم الصيدلية يجب ألا يتجاوز الحد الأقصى للطول المسموح.',

            'pharmacy.image_pharmacy.image' => 'الصورة المرفقة للصيدلية يجب أن تكون صورة صحيحة.',

            'pharmacy.license_number.required' => 'رقم الترخيص مطلوب.',
            'pharmacy.license_number.unique' => 'رقم الترخيص مستخدم مسبقًا.',

            'pharmacy.license_file_path.required' => 'ملف الترخيص مطلوب.',
            'pharmacy.license_file_path.file' => 'يجب أن يكون ملف الترخيص من نوع ملف صالح.',

            'pharmacy.license_expiry_date.required' => 'تاريخ انتهاء الترخيص مطلوب.',
            'pharmacy.license_expiry_date.date' => 'تاريخ انتهاء الترخيص يجب أن يكون تاريخًا صالحًا.',

            'pharmacy.phone_number_pharmacy.required' => 'رقم هاتف الصيدلية مطلوب.',
            'pharmacy.phone_number_pharmacy.string' => 'رقم الهاتف يجب أن يكون نصًا.',
            'pharmacy.phone_number_pharmacy.max' => 'رقم الهاتف يتجاوز الطول المسموح به.',

            'pharmacy.email_pharmacy.required' => 'البريد الإلكتروني للصيدلية مطلوب.',
            'pharmacy.email_pharmacy.email' => 'صيغة البريد الإلكتروني غير صحيحة.',

            'pharmacy.status_exist.required' => 'حالة الصيدلية (مفتوح/مغلق) مطلوبة.',
            'pharmacy.status_exist.in' => 'قيمة حالة الصيدلية غير صحيحة.',

            'pharmacy.description.string' => 'الوصف يجب أن يكون نصًا.',

            'pharmacy.working_hours.required' => 'ساعات العمل مطلوبة.',
            'pharmacy.working_hours.string' => 'ساعات العمل يجب أن تكون نصًا.',

        ];
    }
    public  function getData()
    {
        $data=$this->validated();


        if ($this->hasFile('license_file_path')) {
            $userName =  (!empty($data['name']))
                ? str_replace(' ', '_', $data['name']) . time() . rand(1, 10000000)
                : time() . rand(1, 10000000);

            $path = 'uploads/images/pharmacy/';
            $nameImage = $userName . '.' . $this->file('license_file_path')->getClientOriginalExtension();
            Storage::disk('public')->put($path . $nameImage, file_get_contents($this->file('license_file_path')));
            $this->file('license_file_path')->move('storage/'.($path), $nameImage);
            $absolutePath = storage_path('app/public/' . $path . $nameImage);
            if (file_exists($absolutePath)) {
                chmod($absolutePath, 0775);
            } else {
                throw new \Exception(__('messages.ERROR_OCCURRED') . $absolutePath);
            }

            $data['license_file_path'] = Storage::url($path . $nameImage);
        }
        if ($this->hasFile('image_pharmacy')) {
            $userName =  (!empty($data['name']))
                ? str_replace(' ', '_', $data['name']) . time() . rand(1, 10000000)
                : time() . rand(1, 10000000);

            $path = 'uploads/images/pharmacy/';
            $nameImage = $userName . '.' . $this->file('image_pharmacy')->getClientOriginalExtension();
            Storage::disk('public')->put($path . $nameImage, file_get_contents($this->file('image_pharmacy')));
            $this->file('image_pharmacy')->move('storage/'.($path), $nameImage);
            $absolutePath = storage_path('app/public/' . $path . $nameImage);
            if (file_exists($absolutePath)) {
                chmod($absolutePath, 0775);
            } else {
                throw new \Exception(__('messages.ERROR_OCCURRED') . $absolutePath);
            }

            $data['image_pharmacy'] = Storage::url($path . $nameImage);
        }


        return $data;
    }
}
