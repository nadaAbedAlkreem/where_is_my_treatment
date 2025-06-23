<?php

namespace App\Http\Controllers\Api\V1\TreatmentManagement;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Http\Resources\CategoryResource;
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
        $this->categoriesRepository = $categoriesRepository;
    }

   public function getCategories()
   {
       try {
           $categories = $this->categoriesRepository->getAll();
            return $this->successResponse('DATA_RETRIEVED_SUCCESSFULLY', CategoryResource::collection($categories), 202, app()->getLocale());
       } catch (\Exception $e) {
            return $this->errorResponse('ERROR_OCCURRED', ['error' => $e->getMessage()], 500, app()->getLocale());
       }
   }

}
