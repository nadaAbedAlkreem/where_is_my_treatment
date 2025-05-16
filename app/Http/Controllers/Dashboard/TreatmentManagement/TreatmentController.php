<?php

namespace App\Http\Controllers\Dashboard\TreatmentManagement;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTreatmentRequest;
use App\Http\Requests\UpdateTreatmentRequest;
use App\Models\Treatment;
use App\Repositories\ITreatmentRepositories;
use App\Services\TreatmentDatatableService;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;
use Throwable;

class TreatmentController extends Controller
{
    use ResponseTrait ;
    protected $treatmentRepositories;
    public function __construct(ITreatmentRepositories $treatmentRepositories)
    {
//        $this->middleware('permission:view admin', ['only' => ['index']]);
//        $this->middleware('permission:update admin',['only' => ['update','edit']]);
        $this->treatmentRepositories = $treatmentRepositories;

    }

    public function index(Request $request ,TreatmentDatatableService $treatmentOwnerDatatableService)
    {

        if ($request->ajax())
        {
            $treatment = $this->treatmentRepositories->getAllWithout();

            try {
                return $treatmentOwnerDatatableService->handle($request,$treatment );
            } catch (Throwable $e) {
                return response([
                    'message' => $e->getMessage(),
                ], 500);
            }
        }
        return view('dashboard.pages.treatment-management.treatment.list' );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTreatmentRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Treatment $treatment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Treatment $treatment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTreatmentRequest $request, Treatment $treatment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */

    public function destroy($treatmentId)
    {
        try{
            $this->treatmentRepositories->delete($treatmentId) ;
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
            $this->treatmentRepositories->deleteManyNative($ids) ;
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
}
