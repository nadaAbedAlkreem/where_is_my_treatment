<?php

namespace App\Http\Controllers\Api\V1\TreatmentManagement;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTreatmentRequest;
use App\Http\Requests\UpdateTreatmentRequest;
use App\Http\Resources\TreatmentResource;
use App\Models\Treatment;
use App\Repositories\ICategoryRepositories;
use App\Repositories\ITreatmentRepositories;
use App\Services\TreatmentDatatableService;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Throwable;

class TreatmentController extends Controller
{
    use ResponseTrait ;
    protected $treatmentRepositories ,$categoriesRepository ;

    public function __construct(ITreatmentRepositories $treatmentRepositories  ,ICategoryRepositories  $categoriesRepository)
    {
//        $this->middleware('permission:view admin', ['only' => ['index']]);
//        $this->middleware('permission:update admin',['only' => ['update','edit']]);
        $this->treatmentRepositories = $treatmentRepositories;
        $this->categoriesRepository = $categoriesRepository;

    }
    public function searchTreatments(Request $request)
    {
        try {
            $categoryId = $request->query('category_id');
            $treatmentsValue = $request->query('treatment_search');
            $category = $this->categoriesRepository->findOrFail($categoryId);
            $treatments  = $this->treatmentRepositories->searchWithWhereHas(['category'], ['status_approved', '=', 'approved'], ['name', 'description'], $treatmentsValue, 'category' ,null ,['id' => $category->id] , ['column' => 'id', 'dir' => 'DESC']);
            return $this->successResponse(
                'DATA_RETRIEVED_SUCCESSFULLY',
                TreatmentResource::collection($treatments),
                202,
                app()->getLocale()
            );

        } catch (\Exception $e) {
            return $this->errorResponse(
                'ERROR_OCCURRED',
                ['error' => $e->getMessage()],
                500,
                app()->getLocale()
            );
        }
    }



}
