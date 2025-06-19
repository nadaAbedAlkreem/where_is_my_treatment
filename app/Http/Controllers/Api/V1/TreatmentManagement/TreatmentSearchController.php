<?php

namespace App\Http\Controllers\Api\V1\TreatmentManagement;

use App\Http\Controllers\Controller;
use App\Http\Requests\api\StoreTreatmentSearchRequest;
use App\Repositories\Eloquent\TreatmentSearchRepository;
use App\Repositories\ICategoryRepositories;
use App\Traits\ResponseTrait;
use Illuminate\Support\Facades\App;

class TreatmentSearchController extends Controller
{


    use ResponseTrait ;
    protected $treatmentSearchRepository;
    /**
     * Display a listing of the resource.
     */


    public function __construct(TreatmentSearchRepository $treatmentSearchRepository)
    {
        $this->treatmentSearchRepository = $treatmentSearchRepository;
    }

    public function createSearch(StoreTreatmentSearchRequest $request)
    {
        try {

            $exists = $this->treatmentSearchRepository->findWhere(['treatment_id'  => $request->getData()['treatment_id'], 'user_id'   => $request->getData()['user_id'],]);
             if($exists == null){
               $dataWithCount  = $request->getData() ;
               $dataWithCount['search_count'] = 1 ;
               $this->treatmentSearchRepository->create($dataWithCount);
            }else
            {
                $this->treatmentSearchRepository->update(['search_count' => $exists['search_count'] + 1  ] ,$exists->id);
            }
            return $this->successResponse('CREATE_SUCCESS', [], 200, App::getLocale());
        }catch (\Exception $e){
            return $this->errorResponse('ERROR_OCCURRED', ['error' => $e->getMessage()], 500, app()->getLocale());
        }
    }
}
