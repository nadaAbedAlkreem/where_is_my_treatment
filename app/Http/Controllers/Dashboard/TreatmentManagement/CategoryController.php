<?php

namespace App\Http\Controllers\Dashboard\TreatmentManagement;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorecategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\category;
use App\Repositories\ICategoryRepositories;
use App\Services\CategoryDatatableService;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;
use Throwable;

class CategoryController extends Controller
{
    use ResponseTrait ;
    protected $categoriesRepository;
    /**
     * Display a listing of the resource.
     */


    public function __construct(ICategoryRepositories $categoriesRepository)
    {
//        $this->middleware('permission:view admin', ['only' => ['index']]);
//        $this->middleware('permission:update admin',['only' => ['update','edit']]);
        $this->categoriesRepository = $categoriesRepository;

    }


    public function index(Request $request , CategoryDatatableService $categoryDatatableService)
    {
        if ($request->ajax())
        {
            $categories = $this->categoriesRepository->getAllWithout();
            try {
                return $categoryDatatableService->handle($request,$categories );
            } catch (Throwable $e) {
                return response([
                    'message' => $e->getMessage(),
                ], 500);
            }
        }
        return view('dashboard.pages.treatment-management.categories.list');
    }


    /**
     * Store a newly created resource in storage.
     */
    public  function store(StoreCategoryRequest $request)
    {
        try {
           $category =  $this->categoriesRepository->create($request->getData());
             return $this->successResponse('CREATE_SUCCESS', [], 201,);
        } catch (\Exception $e) {
            return response([
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(category $category)
    {
        //
    }




    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request)
    {
        try {
            $this->categoriesRepository->update($request->getData() , $request['id']);
            return $this->successResponse('UPDATE_SUCCESS', [], 201);
        } catch (\Exception $e) {
            return response([
                'message' => $e->getMessage(),
            ], 500);
        }
    }
    /**
     * Remove the specified resource from storage.
     */



    public function destroy($categoryId)
    {
        try{
            $this->categoriesRepository->delete($categoryId) ;
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
            $this->categoriesRepository->deleteManyNative($ids) ;
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
