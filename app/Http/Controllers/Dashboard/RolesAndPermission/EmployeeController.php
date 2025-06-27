<?php

namespace App\Http\Controllers\Dashboard\RolesAndPermission;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Dashboard\Category;
use App\Http\Requests\StoreEmployeeRequest;
use App\Http\Requests\UpdateEmployeeRequest;
use App\Models\Admin;
use App\Repositories\IAdminRepositories;
use App\Services\EmployeeDatatableService;
use App\Services\BannedAdminsDatatableService;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use Throwable;


class EmployeeController extends Controller
{
    use ResponseTrait ;
    protected $adminsRepository;
    public function __construct(IAdminRepositories $adminsRepository)
    {
//        $this->middleware('permission:view admin', ['only' => ['index']]);
//        $this->middleware('permission:update admin',['only' => ['update','edit']]);
        $this->adminsRepository = $adminsRepository;

    }

    public function index(Request $request , EmployeeDatatableService $employeeDatatableService)
    {
        $user = Auth::user();
        $filterEmployee = $request->query('filter_employee');
        $idToUse = $filterEmployee ?? $user['id'];
        dd($idToUse);
        if ($request->ajax())
        {
            dd($idToUse);
            $employees = $this->adminsRepository->getEmployee(5);
            try {
                return $employeeDatatableService->handle($request,$employees );
            } catch (Throwable $e) {
                return response([
                    'message' => $e->getMessage(),
                ], 500);
            }
        }
         return view('dashboard.pages.user-management.employees.list');
    }
    public function edit(UpdateEmployeeRequest $request)
    {
        try {
            $this->adminsRepository->update($request->getData() , $request['id']);
            return $this->successResponse('CREATE_SUCCESS', [], 201, App::getLocale());
        } catch (\Exception $e) {
            return response([
                'message' => $e->getMessage(),
            ], 500);
        }
    }
    public  function store(StoreEmployeeRequest $request)
    {
        try {
            $admin = $this->adminsRepository->create($request->getData());
            if (! $admin->hasRole('employee')) {$admin->assignRole('employee');}
            return $this->successResponse('CREATE_SUCCESS', [], 201, App::getLocale());
        } catch (\Exception $e) {
            return response([
                'message' => $e->getMessage(),
            ], 500);
        }
    }
    public function UpdateStatusEmployee($employeeId , $status)
    {
        try{
            $this->adminsRepository->update(['status'=> $status],$employeeId) ;
            return $this->successResponse('UPDATE_STATUS_USER_ACTIVE',[], 202, app()->getLocale());
        }catch(Throwable $e)
        {
            return $this->errorResponse(
                'ERROR_OCCURRED',
                ['error' => $e->getMessage()],
                500,
                app()->getLocale()
            );
        }

    }
    public function destroy($employeeId)
    {
        try{
            $this->adminsRepository->delete($employeeId) ;
            return $this->successResponse('DELETE_SUCCESS',[], 202, app()->getLocale());
        } catch (Throwable $e) {
            return $this->errorResponse(
                'ERROR_OCCURRED',
                ['error' => $e->getMessage()],
                500,
                app()->getLocale()
            );
        }
    }
    public  function deleteMultiple(Request  $request)
    {
        try{
            $ids = $request->input('ids', []);
            if (empty($ids)) {
                return $this->errorResponse('NO_IDS_PROVIDED', [], 400, app()->getLocale());
            }
            $this->adminsRepository->deleteMany($ids) ;
            return $this->successResponse('DELETE_SUCCESS',[], 202, app()->getLocale());
        } catch (Throwable $e) {
            return $this->errorResponse(
                'ERROR_OCCURRED',
                ['error' => $e->getMessage()],
                500,
                app()->getLocale()
            );
        }
    }


}
