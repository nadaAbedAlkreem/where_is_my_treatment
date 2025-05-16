<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

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
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:admins,email',
            'phone' => 'nullable|string|max:20',
            'password' => 'required|string|min:6',
            'name_pharmacy' => 'required|string|max:255',
            'image_pharmacy' => 'required|image',
            'license_number' => 'required|string|unique:pharmacies,license_number',
            'license_file_path' => 'required|file',
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
            'admin.name.required' => __('messages.name.required'),
            'admin.name.string' => __('messages.name.string'),
            'admin.name.max' => __('messages.name.max'),

            'admin.email.required' => __('messages.email.required'),
            'admin.email.email' => __('messages.email.email'),
            'admin.email.unique' => __('messages.email.unique'),

            'admin.phone.string' => __('messages.phone.string'),

            'admin.password.required' => __('messages.password.required'),
            'admin.password.string' => __('messages.password.string'),
            'admin.password.min' => __('messages.password.min', ['min' => 6]),
            'admin.password.confirmed' => __('messages.password.confirmed'),

            // رسائل التحقق للصيدلية (pharmacy)
            'pharmacy.name_pharmacy.required' => __('messages.name_pharmacy.required'),
            'pharmacy.name_pharmacy.string' => __('messages.name_pharmacy.string'),
            'pharmacy.name_pharmacy.max' => __('messages.name_pharmacy.max'),

            'pharmacy.image_pharmacy.required' => __('messages.image_pharmacy.required'),
            'pharmacy.image_pharmacy.image' => __('messages.image_pharmacy.image'),

            'pharmacy.license_number.required' => __('messages.license_number.required'),
            'pharmacy.license_number.unique' => __('messages.license_number.unique'),

            'pharmacy.license_file_path.required' => __('messages.license_file_path.required'),
            'pharmacy.license_file_path.file' => __('messages.license_file_path.file'),

            'pharmacy.license_expiry_date.required' => __('messages.license_expiry_date.required'),
            'pharmacy.license_expiry_date.date' => __('messages.license_expiry_date.date'),

            'pharmacy.phone_number_pharmacy.required' => __('messages.phone_number_pharmacy.required'),
            'pharmacy.phone_number_pharmacy.string' => __('messages.phone_number_pharmacy.string'),
            'pharmacy.phone_number_pharmacy.max' => __('messages.phone_number_pharmacy.max'),

            'pharmacy.email_pharmacy.required' => __('messages.email_pharmacy.required'),
            'pharmacy.email_pharmacy.email' => __('messages.email_pharmacy.email'),

            'pharmacy.status_exist.required' => __('messages.status_exist.required'),
            'pharmacy.status_exist.in' => __('messages.status_exist.in'),

            'pharmacy.description.string' => __('messages.description.string'),

            'pharmacy.working_hours.required' => __('messages.working_hours.required'),
            'pharmacy.working_hours.string' => __('messages.working_hours.string'),
        ];
    }
    public  function getData()
    {
        $data=$this->validated();

        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }
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
