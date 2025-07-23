<?php

namespace App\Http\Controllers\Dashboard\PharmacyManagement;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePharmacyStockRequest;
use App\Http\Requests\UpdatePharmacyStockRequest;
use App\Models\PharmacyStock;
use App\Repositories\IPharmacyStockRepositories;
use App\Repositories\ITreatmentRepositories;
use App\Services\PharmacyStockDatatableService;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Mockery\Exception;
use Throwable;

class PharmacyStockController extends Controller
{
    use ResponseTrait ;
    protected $pharmacyStockRepository  , $treatmentRepository;
    public function __construct(IPharmacyStockRepositories $pharmacyStockRepository  ,ITreatmentRepositories $treatmentRepositories )
    {
//        $this->middleware('permission:view admin', ['only' => ['index']]);
//        $this->middleware('permission:update admin',['only' => ['update','edit']]);
        $this->pharmacyStockRepository = $pharmacyStockRepository;
        $this->treatmentRepository = $treatmentRepositories;

    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request ,PharmacyStockDatatableService $pharmacyStockDatatableService)
    {
           $currentUser = Auth::user();
           $currentRoles = $currentUser->roles->first->name ;
            if ($request->ajax()) {
             if ($currentRoles->name == 'admin') {
                $pharmacyStock = $this->pharmacyStockRepository->getWithForDatatable(['treatment', 'pharmacy']);
            } else if ($currentRoles->name  == 'pharmacy_owner' ) {
                $pharmacyStock = $this->pharmacyStockRepository->getWhereWithForDatatable(['treatment', 'pharmacy'], ['pharmacy.admin_id'=>$currentUser->id]);
            }else {
                $pharmacyStock = $this->pharmacyStockRepository->getWhereWithForDatatable(['treatment', 'pharmacy'], ['pharmacy.admin_id'=>  $currentUser->parent_admin_id]);}
            try {
                return $pharmacyStockDatatableService->handle($request,$pharmacyStock );
            } catch (Throwable $e) {
                return response([
                    'message' => $e->getMessage(),
                ], 500);
            }
        }
        return view('dashboard.pages.treatment-management.pharmacies-stock.list'  );
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
    public function store(StorePharmacyStockRequest $request)
    {
            try {
                 $exists = $this->pharmacyStockRepository->existsWhere([
                    'treatment_id'  => $request->getData()['treatment_id'],
                    'pharmacy_id'   => $request->getData()['pharmacy_id'],
                    'quantity'      => $request->getData()['quantity'],
                    'discount_rate'  => $request->getData()['discount_rate'],
                    'expiration_date'  => $request->getData()['expiration_date'],
                    'price'  => $request->getData()['price'],
                ]);

                if ($exists) {
                     throw new Exception( 'تم إدخال هذا السجل من قبل. السجل مطابق تمامًا لسجل موجود.') ;
                }
              $this->pharmacyStockRepository->create($request->getData());
               return $this->successResponse('CREATE_SUCCESS', [], 201,);
            } catch (\Exception $e) {
                return $this->errorResponse('ERROR_OCCURRED', ['error' => $e->getMessage()], 500, app()->getLocale());
            }
    }

    /**
     * Display the specified resource.
     */
    public function show(PharmacyStock $pharmacyStock)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PharmacyStock $pharmacyStock)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePharmacyStockRequest $request)
    {
        try {
            $this->pharmacyStockRepository->update($request->getData() , $request['id_update']);
            return $this->successResponse('CREATE_SUCCESS', [], 201, App::getLocale());
        } catch (\Exception $e) {
            return response([
                'message' => $e->getMessage(),
            ], 500);
        }
    }
    public function filterTreatment(Request $request): \Illuminate\Http\JsonResponse
    {
        $searchTerm = $request->input('q');

        if ($searchTerm) {
            $treatments = $this->treatmentRepository->getAllWhere([
                'name' => ['like', '%' . $searchTerm . '%'],
                'status_approved'=> 'approved'

            ]);
        } else {
            $treatments = $this->treatmentRepository->getAll()->take(5);
        }

        return response()->json([
            'results' => $treatments->map(function ($treatment) {
                return [
                    'id' => $treatment->id,
                    'text' => $treatment->name,
                ];
            }),
        ]);
    }



    public function UpdateStatus($pharmacyStockId , $status)
    {
        try{
            $this->pharmacyStockRepository->update(['status'=> $status],$pharmacyStockId) ;
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

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($pharmacyStockId)
    {
        try{
            $this->pharmacyStockRepository->delete($pharmacyStockId) ;
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
            $this->pharmacyStockRepository->deleteManyNative($ids) ;
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
