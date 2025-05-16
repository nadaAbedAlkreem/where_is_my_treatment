<?php

namespace App\Http\Controllers\Dashboard\RolesAndPermission;

use App\Http\Controllers\Controller;
use App\Repositories\IAdminRepositories;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\App;
use Spatie\Permission\Models\Permission;
use App\Services\PermissionDatatableService  ;
use Throwable;

class PermissionController extends Controller
{
    use ResponseTrait ;
    protected $adminsRepository;
    public function __construct(IAdminRepositories $adminsRepository)
    {
        $this->middleware('permission:view permission', ['only' => ['index']]);
        $this->middleware('permission:create permission', ['only' => ['create','store']]);
        $this->middleware('permission:update permission', ['only' => ['update','edit']]);
        $this->middleware('permission:delete permission', ['only' => ['destroy']]);
        $this->adminsRepository = $adminsRepository;

    }

    public function index($lang ,Request $request  ,  PermissionDatatableService $permissionDatatableService )
    {
        if ($request->ajax())
        {
            $permissions = Permission::get();

            try {
                return $permissionDatatableService->handle($request,$permissions);
            } catch (Throwable $e) {
                return response([
                    'message' => $e->getMessage(),
                ], 500);
            }
        }

        return view('dashboard.role&permission.permission.index' ,compact('lang'));
    }

    public function create()
    {
         return view('dashboard.role&permission.permission.create');
    }

    public function store(Request $request)
    {
      try{
          $request->validate([
              'name' => [
                  'required',
                  'string',
                  'unique:permissions,name'
              ]
          ]);

          Permission::create([
              'name' => $request->name
          ]);
          return $this->successResponse('CREATE_SUCCESS',[], 201, app()->getLocale());

      }catch (throwable $e) {
          return $this->errorResponse(
              'ERROR_OCCURRED',
              ['error' => $e->getMessage()],
              500,
              app()->getLocale()
          );
      }

      }

    public function edit(Permission $permission)
    {
        return view('dashboard.role&permission.permission.edit', ['permission' => $permission]);
    }

    public function update(Request $request, Permission $permission)
    {
         try{
             $request->validate([
                 'name' => [
                     'required',
                     'string',
                     'unique:permissions,name,'.$permission->id
                 ]
             ]);

             $permission->update([
                 'name' => $request->name
             ]);
             return $this->successResponse('UPDATE_SUCCESS',[], 201, app()->getLocale());

         }catch (Throwable $e)
         {
             return $this->errorResponse(
                 'ERROR_OCCURRED',
                 ['error' => $e->getMessage()],
                 500,
                 app()->getLocale()
             );
         }


     }

    public function destroy($permissionId)
    {
        $permission = Permission::find($permissionId);
        $permission->delete();
        return $this->successResponse('DELETE_SUCCESS',[], 201, app()->getLocale());
    }
}
