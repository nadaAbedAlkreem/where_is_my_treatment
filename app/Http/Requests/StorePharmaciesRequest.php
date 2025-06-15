<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class StorePharmaciesRequest extends FormRequest
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
            'name_pharmacy' => 'required|string|max:255',
            'image_pharmacy' => 'required|image',
            'license_number' => 'required|string|unique:pharmacies,license_number,NULL,id,deleted_at,NULL',
            'license_file_path' => 'required|file',
            'license_expiry_date' => 'required|date|after:today',
            'phone_number_pharmacy' => 'required|string|max:20|unique:pharmacies,phone_number_pharmacy,NULL,id,deleted_at,NULL',
            'email_pharmacy' => 'required|email|unique:pharmacies,email_pharmacy,NULL,id,deleted_at,NULL',
            'status_exist' => 'required|in:open,closed',
            'description' => 'required|string',
            'working_hours' => 'required|string',
            'latitude' => 'required',
            'longitude' => 'required',


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

            // رسائل التحقق للصيدلية (pharmacy)
            'name_pharmacy.required' => __('messages.name_pharmacy.required'),
            'name_pharmacy.string' => __('messages.name_pharmacy.string'),
            'name_pharmacy.max' => __('messages.name_pharmacy.max'),

            'image_pharmacy.required' => __('messages.image_pharmacy.required'),
            'image_pharmacy.image' => __('messages.image_pharmacy.image'),

            'license_number.required' => __('messages.license_number.required'),
            'license_number.unique' => __('messages.license_number.unique'),

            'license_file_path.required' => __('messages.license_file_path.required'),
            'license_file_path.file' => __('messages.license_file_path.file'),

            'license_expiry_date.required' => __('messages.license_expiry_date.required'),
            'license_expiry_date.date' => __('messages.license_expiry_date.date'),

            'phone_number_pharmacy.required' => __('messages.phone_number_pharmacy.required'),
            'phone_number_pharmacy.string' => __('messages.phone_number_pharmacy.string'),
            'phone_number_pharmacy.max' => __('messages.phone_number_pharmacy.max'),
            'phone_number_pharmacy.unique' => __('messages.phone_number_pharmacy.unique'),

            'email_pharmacy.required' => __('messages.email_pharmacy.required'),
            'email_pharmacy.email' => __('messages.email_pharmacy.email'),
            'email_pharmacy.unique' => __('messages.email_pharmacy.unique'),

            'status_exist.required' => __('messages.status_exist.required'),
            'status_exist.in' => __('messages.status_exist.in'),

            'description.string' => __('messages.description.string'),
            'description.required' => __('messages.description.required'),


            'working_hours.required' => __('messages.working_hours.required'),
            'working_hours.string' => __('messages.working_hours.string'),

            'latitude.required' => ' بيانات الموقع مفقودة',
            'license_expiry_date.after' => 'يجب أن يكون تاريخ انتهاء الترخيص بعد تاريخ اليوم.',


            'longitude.required' => ' بيانات الموقع مفقودة',
         ];
    }
    public  function getData()
    {
        $data=$this->validated();

        if ($this->hasFile('license_file_path'))
        {
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
        if ($this->hasFile('image_pharmacy'))
        {
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
