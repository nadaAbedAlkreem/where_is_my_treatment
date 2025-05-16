<?php

namespace App\Http\Controllers\Dashboard\RolesAndPermission;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Dashboard\Category;
use App\Http\Requests\StorePharmaciesRequest;
use App\Http\Requests\UpdatePharmaciesRequest;
use App\Models\Admin;
use App\Repositories\IAdminRepositories;
use App\Repositories\IPharmacyRepositories;
use App\Services\PharmacyOwnerDatatableService;
use App\Services\BannedAdminsDatatableService;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Throwable;


class PharmacyOwnerController extends Controller
{
   use ResponseTrait ;
    protected $adminsRepository , $pharmacyRepositories;
    public function __construct(IAdminRepositories $adminsRepository , IPharmacyRepositories  $pharmacyRepositories)
    {
//        $this->middleware('permission:view admin', ['only' => ['index']]);
//        $this->middleware('permission:update admin',['only' => ['update','edit']]);
        $this->pharmacyRepositories = $pharmacyRepositories;
        $this->adminsRepository = $adminsRepository;

    }

    public function index(Request $request ,PharmacyOwnerDatatableService $pharmacyOwnerDatatableService)
    {

        if ($request->ajax())
        {
            $pharmacyOwners = $this->adminsRepository->getPharmacyOwners();

            try {
                return $pharmacyOwnerDatatableService->handle($request,$pharmacyOwners );
            } catch (Throwable $e) {
                return response([
                    'message' => $e->getMessage(),
                ], 500);
            }
        }
         return view('dashboard.pages.user-management.pharmacyOwner.list' );
    }
    public  function store(StorePharmaciesRequest $request)
    {
        DB::beginTransaction();
        try {
            $admin = $this->adminsRepository->create($request->getData());
            $pharmacy = $this->pharmacyRepositories->create($request->getData());

            DB::commit();

            return $this->successResponse('CREATE_SUCCESS', [], 201, App::getLocale());
        } catch (\Exception $e) {
            DB::rollback();
            return response([
                'message' => $e->getMessage(),
            ], 500);        }
    }

    public function edit(UpdatePharmaciesRequest $request)
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

    public function UpdateStatusPharmacyOwner($pharmacyOwnerId , $status)
    {
        try{
            $this->adminsRepository->update(['status'=> $status],$pharmacyOwnerId) ;
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
    public function view(Request $request)
    {
        try {
            $id = $request->query('id');
            $admin = $this->adminsRepository->findWith($id , ['pharmacies']);
         } catch (Throwable $e) {
            return response([
                'message' => $e->getMessage(),
            ], 500);
        }
        return view('dashboard.pages.user-management.pharmacyOwner.view' , ['admin' => $admin]);

    }
    public function destroy($pharmacyOwnerId)
    {
        try{
            $this->adminsRepository->delete($pharmacyOwnerId) ;
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
