<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Repositories\IAdminRepositories;
use App\Repositories\ICategoryRepositories;
use App\Repositories\ITreatmentRepositories;
use App\Repositories\IUserRepositories;
use Illuminate\Support\Facades\Auth;

class AnalyticsController extends Controller
{
    protected $treatmentRepository,$categoriesRepository ,$adminsRepository , $userRepository ;


    public function __construct(ITreatmentRepositories $treatmentRepositories  ,ICategoryRepositories  $categoriesRepository ,IAdminRepositories $adminsRepository ,IUserRepositories $userRepository)
    {
//        $this->middleware('permission:view admin', ['only' => ['index']]);
//        $this->middleware('permission:update admin',['only' => ['update','edit']]);
        $this->treatmentRepository = $treatmentRepositories;
        $this->categoriesRepository = $categoriesRepository;
        $this->adminsRepository = $adminsRepository;
        $this->userRepository = $userRepository;

    }

    public function index()
    {
        $user = Auth::user();
        $usersCount = $this->userRepository->getCount();
        $employeesCount =$this->adminsRepository->getEmployee($user['parent_admin_id'])->count();
        $ownersCount =$this->adminsRepository->getPharmacyOwners()->Count();
        $medicinesCount = $this->treatmentRepository->getCount();
        $categoriesCount = $this->categoriesRepository->getCount();
        $monthlyUserCounts = User::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
            ->whereYear('created_at', now()->year)
            ->groupByRaw('MONTH(created_at)')
            ->pluck('count', 'month');
         return view('dashboard.pages.dashboard.analytics', [
            'usersCount' => $usersCount,
            'employeesCount' => $employeesCount,
            'ownersCount' => $ownersCount,
            'medicinesCount' => $medicinesCount,
            'categoriesCount' => $categoriesCount,
            'userCounts' => $monthlyUserCounts

        ]);
    }
}
