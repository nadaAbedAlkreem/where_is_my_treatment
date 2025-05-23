<?php

namespace App\Http\Controllers\Dashboard\RolesAndPermission;

use App\Http\Controllers\Controller;
use App\Http\Requests\ResetPasswordRequest;
use App\Http\Requests\StoreAdminRequest;
use App\Http\Requests\UpdateAdminRequest;
use App\Models\Admin;
use App\Repositories\IAdminRepositories;
use App\Services\AdminDatatableService;
use App\Services\BannedAdminsDatatableService;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Spatie\Permission\Models\Role;
use Throwable;


class AdminController extends Controller
{
   use ResponseTrait ;
    protected $adminsRepository;

    public function __construct(IAdminRepositories $adminsRepository)
    {
//        $this->middleware('permission:view admin', ['only' => ['index']]);
//        $this->middleware('permission:update admin',['only' => ['update','edit']]);
        $this->adminsRepository = $adminsRepository;

    }


    public function index(Request $request , AdminDatatableService $adminsDatatableService)
    {
        if ($request->ajax())
        {
            $admins = $this->adminsRepository->getAllAdmins();
             try {
                return $adminsDatatableService->handle($request,$admins );
            } catch (Throwable $e) {
                return response([
                    'message' => $e->getMessage(),
                ], 500);
            }
        }
         return view('dashboard.pages.user-management.admins.list');
    }

    public function view(Request $request)
    {
        try {
        $id = $request->query('id');
        $admin = $this->adminsRepository->findOrFail($id);
        } catch (Throwable $e) {
            return response([
                'message' => $e->getMessage(),
            ], 500);
        }
        return view('dashboard.pages.user-management.admins.view' , ['admin' => $admin]);

    }
    public  function store(StoreAdminRequest $request)
    {
        try {
            $admin = $this->adminsRepository->create($request->getData());
            if (! $admin->hasRole('admin')) {$admin->assignRole('admin');}
            return $this->successResponse('CREATE_SUCCESS', [], 201, App::getLocale());
        } catch (\Exception $e) {
            return response([
                'message' => $e->getMessage(),
            ], 500);
        }
    }

//   public function bannedAdminIndex(Request $request , BannedAdminsDatatableService $bannedAdminsDatatableService)
//   {
//       if ($request->ajax())
//       {
//           $bannedAdmins = Admin::where('status' ,'blocked')->with('category');
//           try {
//               return $bannedAdminsDatatableService->handle($request,$bannedAdmins );
//           } catch (Throwable $e) {
//               return response([
//                   'message' => $e->getMessage(),
//               ], 500);
//           }
//       }
//       return view('dashboard.role&permission.admin.banned-admins'  ,[ 'lang' => app::getLocale()]);
//   }
    public function edit(UpdateAdminRequest $request)
    {
        try {
            $this->adminsRepository->update($request->getData() , $request['id']);
//            $adminItem =$this->adminsRepository->findOrFail($request['id']);
//            $adminItem->syncRoles($request['role']);
//            $adminItem->save();
             return $this->successResponse('CREATE_SUCCESS', [], 201, App::getLocale());
        } catch (\Exception $e) {
            return response([
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function updatePassword(ResetPasswordRequest $request)
    {
         try {
            $this->adminsRepository->updateWhere(['id' =>$request['id']] ,['password'=> $request->getData()['new_password']]);
            return $this->successResponse('ITEMS_UPDATED_SUCCESSFULLY', [], 201, App::getLocale());
        } catch (\Exception $e) {
            return response([
                'message' => $e->getMessage(),
            ], 500);
        }
    }


//
//    public function update(Request $request, Admin $admins, $id)
//    {
//        try {
//             $admins = Admin::with('category')->where('id', $id)->first();
//
//             $validation = $request->validate([
//                'name' => 'required|string|max:255',
//                'roles' => [
//                    'required',
//                    function ($attribute, $value, $fail) use ($admins) {
//                        $superAdminsCount = Admin::role('super-admin')->count();
//                        if ($admins->hasRole('super-admin') && !in_array('super-admin', $value) && $superAdminsCount <= 1) {
//                            $fail('You cannot assign a role other than "super admin" as there is no other "super admin" in the table.');
//                        }
//                    },
//                ],
//                'category_id' => 'array',
//                'category_id.*' => 'nullable|exists:location-pharmacy,id' ,
//            ]);
//             $data = [
//                'name' => $request->name,
//                'email' => $request->email,
//            ];
//             if ($request->roles[0] == 'super-admin') {
//                $data['category_id'] = null;
//            }
//
//            $admins->update($data);
//            $admins->syncRoles($request->roles);
//
//            if ($request->roles[0] != 'super-admin') {
//                $admins->category()->sync($request->category_id);
//            } else {
//                $admins->category()->detach();
//            }
//
//            return $this->successResponse('UPDATE_SUCCESS', [], 201, app()->getLocale());
//
//        } catch (Throwable $e) {
//            return $this->errorResponse(
//                'ERROR_OCCURRED',
//                ['error' => $e->getMessage()],
//                500,
//                app()->getLocale()
//            );
//        }
//    }
//
      public function blockAdmin($adminId  , $status)
     {
         try{
             $this->adminsRepository->update(['status'=> $status],$adminId) ;
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
      public function destroy($adminId)
    {
        try{
            $this->adminsRepository->delete($adminId) ;
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
//    public function restoreAdmin(Request $request)
//    {
//        $admin = Admin::findOrFail($request['id']);
//        $admin->status = 'active';
//        $admin->save() ;
//        return $this->successResponse('RESTORE_SUCCESS',[], 202, app()->getLocale());
//    }



}
