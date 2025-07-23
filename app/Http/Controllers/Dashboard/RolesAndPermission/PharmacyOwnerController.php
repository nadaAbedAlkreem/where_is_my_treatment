<?php

namespace App\Http\Controllers\Dashboard\RolesAndPermission;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAdminRequest;
use App\Http\Requests\StorePharmaciesRequest;
use App\Http\Requests\UpdatePharmaciesRequest;
use App\Mail\PharamcyOwnerJoin;
use App\Models\Location;
use App\Repositories\IAdminRepositories;
use App\Repositories\ILocationRepositories;
use App\Repositories\IPharmacyRepositories;
use App\Services\LocationService;
use App\Services\PharmacyOwnerDatatableService;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Throwable;


class PharmacyOwnerController extends Controller
{
    use ResponseTrait ;
    protected $adminsRepository , $pharmacyRepositories  ,$locationRepositories;
    public function __construct(IAdminRepositories $adminsRepository , IPharmacyRepositories  $pharmacyRepositories ,ILocationRepositories  $locationRepositories)
    {
//        $this->middleware('permission:view admin', ['only' => ['index']]);
//        $this->middleware('permission:update admin',['only' => ['update','edit']]);
         $this->pharmacyRepositories = $pharmacyRepositories;
         $this->adminsRepository = $adminsRepository;
         $this->locationRepositories = $locationRepositories;

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
             $this->adminsRepository->create($request->getData());
             $this->pharmacyRepositories->create($request->getData());
             DB::commit();
            return $this->successResponse('CREATE_SUCCESS', [], 201, App::getLocale());
        } catch (\Exception $e) {
            DB::rollback();
            return $this->errorResponse('ERROR_OCCURRED', ['error' => $e->getMessage()], 500, app()->getLocale());
        }
    }

    public function edit(UpdatePharmaciesRequest $request)
    {
        try {
            $this->pharmacyRepositories->update($request->getData() , $request['id_update']);
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
    public function UpdateStatusPharmacyApproved($pharmacyOwnerId , $status)
    {
        try{
            $this->adminsRepository->update(['status_approved_for_pharmacy'=> $status],$pharmacyOwnerId) ;
            if($status == 'approved')
            {
                $admin = $this->adminsRepository->findOne($pharmacyOwnerId);
                Mail::to($admin->email)->send(new PharamcyOwnerJoin($admin->email , Cache::pull("pharmacy_plain_password_{$admin->id}"), config('app.url').'/admin/login' ));
            }
            return $this->successResponse('UPDATE_STATUS_USER_ACTIVE',[], 202, app()->getLocale());
        }catch(Throwable $e)
        {
            return $this->errorResponse('ERROR_OCCURRED', ['error' => $e->getMessage()], 500, app()->getLocale());
        }
    }
    public function view(Request $request)
    {
        try {
            $id = $request->query('id');
            $admin = $this->adminsRepository->findWith($id , ['pharmacies']);
            $pharmacyLocation = $this->pharmacyRepositories->findWith($admin->pharmacies->id , ['location']);
          } catch (Throwable $e) {
            return $this->errorResponse('ERROR_OCCURRED', ['error' => $e->getMessage()], 500, app()->getLocale());
        }
        return view('dashboard.pages.user-management.pharmacyOwner.view' , ['admin' => $admin , 'pharmacyLocation' =>$pharmacyLocation]);

    }
    public function updateLocationPharmacy(Request $request , LocationService $locationService)
    {
            try {
                $locationDetails = $locationService->getLocationDetails($request['id_pharmacy'] , 'App\Models\Pharmacy' ,$request['lat'], $request['lng']);
                $this->locationRepositories->update($locationDetails , $request['id_location']);
                return $this->successResponse('UPDATE_SUCCESS',[], 202, app()->getLocale());
            } catch (Throwable $e) {
                return $this->errorResponse('ERROR_OCCURRED', ['error' => $e->getMessage()], 500, app()->getLocale());
            }
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
    public function subscriptionPharmacyInApp(StoreAdminRequest $requestAdmin ,StorePharmaciesRequest $requestPharmacy  , LocationService $locationService)
    {
        try {
            DB::beginTransaction();
            $admin = $this->adminsRepository->create($requestAdmin->getData());
            if (! $admin->hasRole('pharmacy_owner')) {$admin->assignRole('pharmacy_owner');}
            Cache::put("pharmacy_plain_password_{$admin->id}", $requestAdmin->password);
            $data  = $requestPharmacy->getData();
            $data['admin_id'] = $admin->id;
            $pharmacy = $this->pharmacyRepositories->create($data);
            $locationDetails = $locationService->getLocationDetails( $pharmacy->id , 'App\Models\Pharmacy' ,$requestPharmacy->input('latitude'), $requestPharmacy->input('longitude'));
            $this->locationRepositories->create($locationDetails);
            DB::commit();
            return $this->successResponse('CREATE_SUCCESS',[], 202, app()->getLocale());
        }catch (Throwable $e) {
            DB::rollback();
            return $this->errorResponse('ERROR_OCCURRED', ['error' => $e->getMessage()], 500, app()->getLocale());
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
            return $this->errorResponse('ERROR_OCCURRED', ['error' => $e->getMessage()], 500, app()->getLocale());
        }
    }


}
