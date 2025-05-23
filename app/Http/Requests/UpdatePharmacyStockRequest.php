<?php

namespace App\Http\Requests;

use App\Models\Pharmacy;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdatePharmacyStockRequest extends FormRequest
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
            'id_update' => '',

            'pharmacy_id' => '',
            'treatment_id' => 'required|exists:treatments,id',
            'price' => 'required|numeric|min:0',
            'discount_rate' => 'nullable|numeric|min:0|max:100',
            'price_after_discount' => 'nullable|numeric|min:0',
            'status' => 'required|string|in:available,unavailable',
            'quantity' => 'required|integer|min:1',
            'is_expired' => 'nullable|boolean',
            'expiration_date' => 'required|date|after:today',
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
            'pharmacy_id.required' => 'يجب ادخال  اسم الصيدلية' ,
            'pharmacy_id.exists' => 'الصيدلية المدخلة غير موجودة',

            'treatment_id.required' =>'يجب ادخال الدواء',
            'treatment_id.exists' =>'الدواء المدخل غير موجود',

            'price.required' =>'يجب ادخال سعر بقيمة الشيكل ',
            'discount_rate.max' => '',
            'status.required' => 'حالة توفر الدواء مطلوبة',
            'status.string' => 'يجب ان تكون قيمة الدواء نص ',
            'status.in' => 'يجب ان يكون قيمة الحالة متوفر او غير متوفر',
            'quantity.required' => 'الكمية مطلوبة',
            'quantity.min' => 'الكمية لا تقل عن واحد',
            'expiration_date.required' => ' تاريخ انتهاء الصلاحية مطلوبة ',
            'expiration_date.date' => 'تاريخ انتهاء الصلاحية يجب ان يكون تاريخ',



        ];
    }
    public  function getData()
    {
        $data = $this->validated();
        $price = $data['price'];
        $discountRate = $data['discount_rate'];

        if ($discountRate) {
            $priceAfterDiscount = $price - ($price * ($discountRate / 100));
        } else {
            $priceAfterDiscount = $price;
        }
        $data['price_after_discount'] = $priceAfterDiscount;
        $currentUser = Auth::user();
        $currentRoles = $currentUser->roles->first->name;
        if($currentRoles->name == 'pharmacy_owner')
        {
            $firstPharmacy = Pharmacy::where('admin_id', $currentUser->id)->first();
            if ($firstPharmacy) {
                $data['pharmacy_id'] = $firstPharmacy->id;
            }
        }elseif ($currentRoles->name == 'employee')
        {
            $firstPharmacy = Pharmacy::where('admin_id', $currentUser->parent_admin_id)->first();
            if ($firstPharmacy) {
                $data['pharmacy_id'] = $firstPharmacy->id;
            }
        }




        return $data;
    }
}
