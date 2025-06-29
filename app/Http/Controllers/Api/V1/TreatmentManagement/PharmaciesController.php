<?php

namespace App\Http\Controllers\Api\V1\TreatmentManagement;

use App\Http\Controllers\Controller;
use App\Http\Requests\api\StorePharmaciesFavRequest;
use App\Http\Requests\api\StoreRatingPharmacyRequest;
use App\Http\Resources\PharmacyFavoriteResource;
use App\Http\Resources\PharmacyResource;
use App\Http\Resources\TreatmentWithPharmacyStockResource;
use App\Models\Treatment;
use App\Repositories\IFavoriteRepositories;
use App\Repositories\IPharmacyRepositories;
use App\Repositories\IPharmacyStockRepositories;
use App\Repositories\IRatingRepositories;
use App\Repositories\ITreatmentRepositories;
use App\Traits\ResponseTrait;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class PharmaciesController extends Controller
{
    use ResponseTrait ;
    protected  $ratingRepositories ,  $treatmentRepositories,$pharmacyRepositories ,$favoriteRepository , $pharmacyStockRepositories ;
    /**
     * Display a listing of the resource.
     */


    public function __construct(  IRatingRepositories $ratingRepositories,IFavoriteRepositories $favoriteRepositories , IPharmacyStockRepositories  $pharmacyStockRepositories ,    ITreatmentRepositories $treatmentRepositories  ,IPharmacyRepositories $pharmacyRepositories)
    {

        $this->pharmacyRepositories = $pharmacyRepositories;
        $this->pharmacyStockRepositories = $pharmacyStockRepositories;
        $this->treatmentRepositories = $treatmentRepositories;
        $this->favoriteRepository = $favoriteRepositories;
        $this->ratingRepositories = $ratingRepositories;

    }

    public function getPharmaciesNearestToCurrentUser(Request $request)
    {
        try {
            $user = $request->user();
            $location = $user->location;
            $nearbyPharmacies = $this->pharmacyRepositories->getNearestPharmacies($location->latitude, $location->longitude);
            return $this->successResponse('DATA_RETRIEVED_SUCCESSFULLY', PharmacyResource::collection($nearbyPharmacies), 202, app()->getLocale());
        } catch (\Exception $e) {
            return $this->errorResponse(
                'ERROR_OCCURRED',
                ['error' => $e->getMessage()],
                500,
                app()->getLocale()
            );
        }

    }
    public function searchTreatmentOnPharmaciesNearestToCurrentUser(Request $request)
    {
        try {
            $user = $request->user();
            $location = $user->location;
            $searchTreatment = $request->query('treatment_search');
            $nearbyPharmacies = $this->pharmacyRepositories->getSearchTreatmentNearestPharmacies($location->latitude, $location->longitude ,$searchTreatment );
            dd($nearbyPharmacies);
            return $this->successResponse('DATA_RETRIEVED_SUCCESSFULLY', PharmacyResource::collection($nearbyPharmacies), 202, app()->getLocale());
        } catch (\Exception $e) {
            return $this->errorResponse('ERROR_OCCURRED', ['error' => $e->getMessage()], 500, app()->getLocale());
        }

    }
    public function searchTreatmentsOnStock(Request $request)
    {
        try {
            $pharmacyId = $request->query('pharmacy_id');
            $treatmentsValue = $request->query('treatment_search');
            $pharmacy  = $this->pharmacyRepositories->findOrFail($pharmacyId);
            $treatments = $this->treatmentRepositories->treatmentAvailabilityPharmacy($pharmacyId , $treatmentsValue);
        return $this->successResponse('DATA_RETRIEVED_SUCCESSFULLY', TreatmentWithPharmacyStockResource::collection($treatments), 202, app()->getLocale());
        } catch (\Exception $e) {
            return $this->errorResponse('ERROR_OCCURRED', ['error' => $e->getMessage()], 500, app()->getLocale());
        }
    }
    public function storeFavouritePharmacies(StorePharmaciesFavRequest $request)
    {
        try {
            $exists = $this->favoriteRepository->existsWhere([
                'favoritable_id'  => $request->getData()['pharmacy_id'],
                'favoritable_type'   => $request->getData()['favoritable_type'],
                'user_id'   => $request->getData()['user_id'],
            ]);

            if ($exists) {
                throw new Exception( 'تم إدخال هذا السجل من قبل. السجل مطابق تمامًا لسجل موجود.') ;
            }
            $favoritePharmacy = $this->favoriteRepository->create($request->getData());
            return $this->successResponse('favorite', [], 201);
        } catch (\Exception $e) {
            return $this->errorResponse('ERROR_OCCURRED', ['error' => $e->getMessage()], 500, app()->getLocale());
        }

    }


    public function getFavoritesForCurrentUser()
    {
        try {
            $user = auth()->user();
            $favoritesOfPharmacy = $user->favorites()
                ->where('favoritable_type', \App\Models\Pharmacy::class)
                ->with('favoritable.ratings')
                ->get();
              return $this->successResponse('DATA_RETRIEVED_SUCCESSFULLY', PharmacyFavoriteResource::collection($favoritesOfPharmacy) , 202, app()->getLocale());

        }catch (\Exception $exception){
               return $this->errorResponse('ERROR_OCCURRED', ['error' => $exception->getMessage()], 500, App::getLocale());
        }
    }
    public function storeRatingPharmacies(StoreRatingPharmacyRequest $request)
    {
        try {
        $ratingPharmacy = $this->ratingRepositories->create($request->getData());
        return $this->successResponse('CREATE_SUCCESS', [], 200, App::getLocale());
        }catch (\Exception $exception){
        return $this->errorResponse('ERROR_OCCURRED', ['error' => $exception->getMessage()], 500, App::getLocale());
        }

    }


}
