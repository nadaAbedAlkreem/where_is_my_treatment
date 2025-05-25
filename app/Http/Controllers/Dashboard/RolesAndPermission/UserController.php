<?php

namespace App\Http\Controllers\Dashboard\RolesAndPermission;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\UserDatatableService;
use Illuminate\Http\Request;
use Throwable;

class UserController extends Controller
{
    public function index(Request $request , UserDatatableService $userDatatableService)
    {
        if ($request->ajax())
        {
            $user = User::select('*');
            try {
                return $userDatatableService->handle($request,$user );
            } catch (Throwable $e) {
                return response([
                    'message' => $e->getMessage(),
                ], 500);
            }
        }
        return view('dashboard.pages.user-management.users.list');
    }
}
