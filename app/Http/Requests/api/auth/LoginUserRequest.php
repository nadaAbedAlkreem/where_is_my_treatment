<?php

namespace App\Http\Requests\api\auth;

use App\Models\User;
use Exception;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;

class LoginUserRequest extends FormRequest
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
            'email' => 'required|string|email',
            'password' =>
                'required',
            'string',
            'min:8'
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
            'email' => 'required|string|email|max:255',
            'password' => [
                'required',
                'string',
                'min:8', // Ensure minimum password length
            ]
        ];
    }

    public function authenticate()
    {
        $credentials = $this->only('email', 'password');
        $user = User::where('email', $credentials['email'])->first();

        if ($user && Hash::check($credentials['password'], $user->password)) {

            return   [
                'access_token' =>  $user->createToken('API Token')->plainTextToken,
                'token_type' => 'Bearer',
                'user' => $user
            ] ;
        }

        throw new Exception(__('messages.invalid_credentials'));
    }
}
