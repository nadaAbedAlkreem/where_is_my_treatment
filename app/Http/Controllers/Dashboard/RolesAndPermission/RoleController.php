<?php

namespace App\Http\Controllers\Dashboard\RolesAndPermission;

use App\Http\Controllers\Controller;
use App\Repositories\IAdminRepositories;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;
use App\Services\RolesDatatableService  ;
use Throwable;

class RoleController extends Controller
{
    use ResponseTrait ;
    protected $adminsRepository;
    public function __construct(IAdminRepositories $adminsRepository)    {
        $this->middleware('permission:view role', ['only' => ['index']]);
        $this->middleware('permission:create role', ['only' => ['create','store','addPermissionToRole','givePermissionToRole']]);
        $this->middleware('permission:update role', ['only' => ['update','edit']]);
        $this->middleware('permission:delete role', ['only' => ['destroy']]);
        $this->adminsRepository = $adminsRepository;

    }

    public function index(Request $request  , RolesDatatableService $rolesDatatableService)
    {
        if ($request->ajax())
        {
            $data = Role::select('*') ;

            try {
                return $rolesDatatableService->handle($request,$data);
            } catch (Throwable $e) {
                return response([
                    'message' => $e->getMessage(),
                ], 500);
            }
        }

        // $roles = Role::get();
        return view('dashboard.role&permission.role.index' , ['lang' => app::getLocale()]);
    }

    public function create()
    {
        return view('dashboard.role&permission.role.create');
    }

    public function store(Request $request)
    {
        try {

            $request->validate([
                'name' => [
                    'required',
                    'string',
                    'unique:roles,name'
                ]
            ]);
            Role::create([
                'name' => $request->name
            ]);
            return $this->successResponse('CREATE_SUCCESS',[], 201, app()->getLocale());

        }catch (Throwable $e) {
            return $this->errorResponse(
                'ERROR_OCCURRED',
                ['error' => $e->getMessage()],
                500,
                app()->getLocale()
            );
        }
     }

    public function edit($id)
    {
        $role = Role::find($id);
        $permission = Permission::get();
        $rolePermissions = DB::table("role_has_permissions")->where("role_has_permissions.role_id",$id)
            ->pluck('role_has_permissions.permission_id','role_has_permissions.permission_id')
            ->all();

        return view('dashboard.role&permission.role.edit',compact('role','permission','rolePermissions'));
    }

    public function update(Request $request, Role $role)
    {
        try {
            $request->validate([
                'name' => [
                    'required',
                    'string',
                    'unique:roles,name,' . $role->id
                ]
            ]);

            $role->update([
                'name' => $request->name
            ]);
            return $this->successResponse('UPDATE_SUCCESS', [], 201, app()->getLocale());

        } catch (Throwable $e) {
            return $this->errorResponse(
                'ERROR_OCCURRED',
                ['error' => $e->getMessage()],
                500,
                app()->getLocale()
            );
        }


    }

    public function destroy($id)
    {
        $role = Role::find($id);
        return  $role->delete() ? $id :  $this->errorResponse(
        'ERROR_OCCURRED',
        [],
        500,
        app()->getLocale()
    );
    }

    public function addPermissionToRole($roleId)
    {
        $permissions = Permission::get();
        $role = Role::findOrFail($roleId);
        $rolePermissions = DB::table('role_has_permissions')
            ->where('role_has_permissions.role_id', $role->id)
            ->pluck('role_has_permissions.permission_id','role_has_permissions.permission_id')
            ->all();

        return view('dashboard.role&permission.role.add-permissions', [
            'role' => $role,
            'permissions' => $permissions,
            'rolePermissions' => $rolePermissions
        ]);
    }

    public function givePermissionToRole(Request $request, $roleId)
    {

        /// if just super admin to be required but other roles not importenmt
        $request->validate([
            'permission' => 'required'
        ]);

        $role = Role::findOrFail($roleId);
        $role->syncPermissions($request->permission);

        return redirect()->back()->with('status','Permissions added to role');
    }
}
