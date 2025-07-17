<?php

namespace App\Http\Controllers\Api\V1\TreatmentManagement;

use App\Http\Controllers\Controller;
use App\Http\Requests\api\StoreTreatmentAvailabilityRequest;
use App\Http\Requests\api\StoreTreatmentFavRequest;
use App\Http\Resources\TreatmentFavoriteResource;
use App\Http\Resources\TreatmentResource;
use App\Models\Treatment;
use App\Repositories\ICategoryRepositories;
use App\Repositories\IFavoriteRepositories;
use App\Repositories\IMedicationAvalabilityRequestRepositories;
use App\Repositories\ITreatmentRepositories;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Mockery\Exception;

class TreatmentController extends Controller
{
    use ResponseTrait ;
    protected $medicationAvalabilityRequestRepositories , $treatmentRepositories ,$categoriesRepository  , $favoriteRepository;

    public function __construct(IMedicationAvalabilityRequestRepositories $medicationAvalabilityRequestRepositories  ,IFavoriteRepositories $favoriteRepositories ,ITreatmentRepositories $treatmentRepositories  ,ICategoryRepositories  $categoriesRepository)
    {
        $this->treatmentRepositories = $treatmentRepositories;
        $this->categoriesRepository = $categoriesRepository;
        $this->favoriteRepository = $favoriteRepositories;
        $this->medicationAvalabilityRequestRepositories = $medicationAvalabilityRequestRepositories;

    }
    public function searchTreatments(Request $request)
    {
        try {
            $categoryId = $request->query('category_id');
            $treatmentsValue = $request->query('treatment_search');
            $category = ($categoryId  != null )? $this->categoriesRepository->findOrFail($categoryId) :null ;
            $condition  = ($category == null)? [] : ['id' => $category->id] ;

            $treatments  = $this->treatmentRepositories->searchWithWhereHas(['category'], ['status_approved', '=', 'approved'], ['name', 'description'], $treatmentsValue, 'category' ,null ,$condition , ['column' => 'id', 'dir' => 'DESC']);
            return $this->successResponse('DATA_RETRIEVED_SUCCESSFULLY', TreatmentResource::collection($treatments), 202, app()->getLocale());

        } catch (\Exception $e) {
             if($e->getCode() ==0 )
            {
                return $this->errorResponse('ERROR_OCCURRED', ['error'=>'قيمة الفئة غير موجود'], 500, app()->getLocale());
            }
            return $this->errorResponse('ERROR_OCCURRED', ['error' => $e->getMessage()], 500, app()->getLocale());
        }
    }

     public function storeFavouriteTreatment(StoreTreatmentFavRequest $request)
     {
         try {
             $exists = $this->favoriteRepository->existsWhere([
                 'favoritable_id'  => $request->getData()['treatment_id'],
                 'favoritable_type'   => $request->getData()['favoritable_type'],
                 'user_id'   => $request->getData()['user_id'],
             ]);

             if ($exists) {
                 throw new Exception( 'تم إدخال هذا السجل من قبل. السجل مطابق تمامًا لسجل موجود.') ;
             }
         $favoriteTreatment = $this->favoriteRepository->create($request->getData());

         return $this->successResponse('favorite', [], 201);
         } catch (\Exception $e) {
            return $this->errorResponse('ERROR_OCCURRED', ['error' => $e->getMessage()], 500, app()->getLocale());}
     }

    public function getFavoritesForCurrentUser()
    {
        try {
            $user = auth()->user();
            $favoritesOfTreatment = $user->favorites()
                ->where('favoritable_type', \App\Models\Treatment::class)
                ->with('favoritable')
                ->get();

            return $this->successResponse('DATA_RETRIEVED_SUCCESSFULLY', TreatmentFavoriteResource::collection($favoritesOfTreatment) , 202, app()->getLocale());

        }catch (\Exception $exception){
            return $this->errorResponse('ERROR_OCCURRED', ['error' => $exception->getMessage()], 500, App::getLocale());
        }
    }

    public function getMostSearchedTreatments()
    {
        try {
            $topTreatments = Treatment::select('treatments.*')
                ->selectSub(function ($query) {
                    $query->from('treatment_searches')
                        ->selectRaw('SUM(search_count)')
                        ->whereColumn('treatment_searches.treatment_id', 'treatments.id');
                }, 'total_searches')
                ->withExists([
                    'favorites as is_favorite' => function ($q) {
                        $q->where('user_id', auth()->id());
                    }
                ])
                ->with(['category', 'searchTreatments', 'pharmacyStocks'])
                ->withCount('pharmacyStocks')
                ->orderByDesc('total_searches')
                ->take(5)
                ->get();
             return $this->successResponse('DATA_RETRIEVED_SUCCESSFULLY', TreatmentResource::collection($topTreatments) , 202, app()->getLocale());

        }catch (\Exception $exception){
            return $this->errorResponse('ERROR_OCCURRED', ['error' => $exception->getMessage()], 500);
        }
    }

    public function storeTreatmentAvailabilityRequest(StoreTreatmentAvailabilityRequest $request)
    {
        try {
            $exists = $this->medicationAvalabilityRequestRepositories->existsWhere(['treatment_id'  => $request->getData()['treatment_id'], 'pharmacy_id'   => $request->getData()['pharmacy_id'], 'user_id'   => $request->getData()['user_id'],]);
            if ($exists) {
                throw new Exception( 'تم إدخال هذا السجل من قبل. السجل مطابق تمامًا لسجل موجود.') ;
            }
            $medicationAvalabilityRequest = $this->medicationAvalabilityRequestRepositories->create($request->getData());
            return $this->successResponse('CREATE_SUCCESS', [], 201, app()->getLocale());
        }catch (\Exception $exception){
            return $this->errorResponse('ERROR_OCCURRED', ['error' => $exception->getMessage()], 500);
        }

    }



}
