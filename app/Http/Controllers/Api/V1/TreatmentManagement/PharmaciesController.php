<?php

namespace App\Http\Controllers\Api\V1\TreatmentManagement;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePharmaciesRequest;
use App\Http\Requests\UpdatePharmaciesRequest;
use App\Http\Resources\PharmacyResource;
use App\Http\Resources\TreatmentResource;
use App\Http\Resources\TreatmentWithPharmacyStockResource;
use App\Models\Pharmacy;
use App\Models\Treatment;
use App\Repositories\IPharmacyRepositories;
use App\Repositories\IPharmacyStockRepositories;
use App\Repositories\ITreatmentRepositories;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;

class PharmaciesController extends Controller
{
    use ResponseTrait ;
    protected $treatmentRepositories,$pharmacyRepositories , $pharmacyStockRepositories ;
    /**
     * Display a listing of the resource.
     */


    public function __construct( IPharmacyStockRepositories  $pharmacyStockRepositories ,    ITreatmentRepositories $treatmentRepositories  ,IPharmacyRepositories $pharmacyRepositories)
    {

        $this->pharmacyRepositories = $pharmacyRepositories;
        $this->pharmacyStockRepositories = $pharmacyStockRepositories;
        $this->treatmentRepositories = $treatmentRepositories;
    }

    public function getPharmaciesNearestToCurrentUser(Request $request)
    {
        try {
            $user = $request->user();
            $location = $user->location;
            $nearbyPharmacies = $this->pharmacyRepositories->getNearestPharmacies($location->latitude, $location->longitude);
            return $this->successResponse(
                'DATA_RETRIEVED_SUCCESSFULLY',
                PharmacyResource::collection($nearbyPharmacies),
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
    public function searchTreatmentsOnStock(Request $request)
    {
        try {
            $pharmacyId = $request->query('pharmacy_id');
            $treatmentsValue = $request->query('treatment_search');
            $pharmacy  = $this->pharmacyRepositories->findOrFail($pharmacyId);
            $treatments = Treatment::with([
                'pharmacyStocks' => function ($query) use ($pharmacyId) {
                    $query->where('pharmacy_id', $pharmacyId)
                        ->where('status', 'available');
                }
            ])
                ->withExists([
                    'favorites as is_favorite' => function ($q) {
                        $q->where('user_id', auth()->id());
                    }
                ])
                ->whereHas('pharmacyStocks', function ($query) use ($pharmacyId) {
                    $query->where('pharmacy_id', $pharmacyId)
                        ->where('status', 'available');
                })
                ->where(function ($q) use ($treatmentsValue) {
                    $q->where('name', 'like', "%$treatmentsValue%")
                        ->orWhere('description', 'like', "%$treatmentsValue%");
                })
                ->orderBy('id', 'DESC')
                ->get();


        return $this->successResponse(
                'DATA_RETRIEVED_SUCCESSFULLY',
                TreatmentWithPharmacyStockResource::collection($treatments),
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
