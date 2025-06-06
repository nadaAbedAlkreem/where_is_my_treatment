<?php

namespace App\Http\Controllers\Dashboard\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Resources\Api\UserWithTokenAccessResource;
use App\Traits\ResponseTrait;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    use ResponseTrait ;

    public function index()
    {
    return view('dashboard.auth.login');
    }


    public function login(Request $request)
    {
          try {
            $credentials = $request->only('email', 'password');
               if (auth('admin')->attempt($credentials)) {
                   $admin = auth('admin')->user();
                   if ($admin->isBlocked()) {
                       Auth::logout();
                       throw new Exception(__('messages.blocked_Admin'));
                   }
//                   if (! $admin->hasRole('pharmacy_owner')) {
//                       $admin->assignRole('pharmacy_owner');
//                   }
                   return true;
             }
            else
            {
                throw new Exception(__('messages.invalid_credentials'));

            }
        } catch (\Exception $e) {
//             return redirect()->route('admin.login' , ['error' => $e->getMessage()]);
              return $this->errorResponse(
                'ERROR_OCCURRED',
                ['error' => $e->getMessage()],
                500,
                app()->getLocale()
            );
         }
    }
    public function logout()
    {
        Auth::guard('admin')->logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return redirect()->route('admin.login')->with('success', 'You have been logged out.');

    }
}
