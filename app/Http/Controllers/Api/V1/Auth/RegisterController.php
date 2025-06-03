<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App;
use App\Http\Controllers\Controller;
use App\Http\Requests\api\auth\RegisterUserRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Resources\Api\UserWithTokenAccessResource;
use App\Http\Resources\UserResource;
use App\Services\api\UserService;
use App\Traits\ResponseTrait;

class RegisterController extends Controller
{

    use ResponseTrait ;
     protected $userService ;

    public function __construct(UserService $userService)
    {
         $this->userService = $userService;
    }


    public function register(RegisterUserRequest $request)
    {
        try {
            $user = $this->userService->register($request->getData());
            return $this->successResponse('CREATE_USER_SUCCESSFULLY',
               [
                   'access_token' => $user['access_token'],
                   'token_type' => 'Bearer',
                   'user' => new UserResource($user['user']),
               ], 201, app()->getLocale());
        } catch (\Exception $e) {
             return $this->errorResponse('ERROR_OCCURRED', ['error' => $e->getMessage()], 500, app()->getLocale());
        }
     }
}
