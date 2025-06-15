<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Auth\UpdatePasswordRequest;
use App\Http\Requests\api\auth\UpdateProfileRequest;
use App\Http\Requests\api\StoreLocationRequest;
use App\Http\Requests\api\StoreRatingAppRequest;
use App\Http\Requests\api\UpdateLocationRequest;
use App\Http\Resources\LocationResource;
use App\Http\Resources\NotificationResource;
use App\Http\Resources\UserResource;
use App\Repositories\IFavoriteRepositories;
use App\Repositories\ILocationRepositories;
use App\Repositories\INotificationRepositories;
use App\Repositories\IRatingRepositories;
use App\Repositories\IUserRepositories;
use App\Services\api\UserService;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Mockery\Matcher\Not;

// Make sure to import the App facade


class UserController extends Controller
{
    use ResponseTrait  ;
    protected  $notificationRepositories, $ratingRepositories , $userRepository  , $userService ,$locationRepository  ,$favoriteRepository;

    public function __construct( INotificationRepositories $notificationRepositories,IRatingRepositories $ratingRepositories  ,IFavoriteRepositories $favoriteRepositories ,IUserRepositories $userRepository  ,ILocationRepositories $locationRepository ,UserService $userService)
    {
        $this->userRepository = $userRepository;
        $this->userService = $userService;
        $this->locationRepository = $locationRepository;
        $this->favoriteRepository = $favoriteRepositories;
        $this->ratingRepositories = $ratingRepositories;
        $this->notificationRepositories = $notificationRepositories;

    }


   public  function getCurrentUser(Request $request)
   {
       try {
           $user = $request->user();
           return $this->successResponse('DATA_RETRIEVED_SUCCESSFULLY', new UserResource($user->load('location')), 200, App::getLocale());
       } catch (\Exception $exception) {
           return $this->errorResponse('ERROR_OCCURRED', ['error' => $exception->getMessage()], 500, App::getLocale());
       }

   }

   public function storeLocationUser(StoreLocationRequest $request)
   {
        try{
              $locationUser = $this->locationRepository->create($request->getData()) ;
                return $this->successResponse('CREATE_SUCCESS', new LocationResource($locationUser->load('locationable')), 201);
           } catch (\Exception $e) {
                return $this->errorResponse('ERROR_OCCURRED', ['error' => $e->getMessage()], 500, app()->getLocale());
        }
   }

    public function updateLocationUser(UpdateLocationRequest $request)
    {
         try{
             $data = $request->getData();
             $dataWithoutType = collect($data)->except('user_id')->toArray();
             $this->locationRepository->updateWhere($dataWithoutType, ['locationable_id' => $request->getData()['locationable_id']  ,'locationable_type' =>'App\Models\User'] ) ;
            return $this->successResponse('UPDATE_SUCCESS',[], 202);
        } catch (\Exception $e) {
            return $this->errorResponse('ERROR_OCCURRED', ['error' => $e->getMessage()], 500, app()->getLocale());
        }
    }
    public function updatePasswordUser(UpdatePasswordRequest $request)
    {
        try {
            $user = $request->user();
            $this->userRepository->update($request->getData($user) ,$user->id );
            return $this->successResponse('UPDATE_SUCCESS',[], 202);
        }catch (\Exception $exception){
            return $this->errorResponse('ERROR_OCCURRED', ['error' => $exception->getMessage()], 500, app()->getLocale());
        }

    }


    public function deleteFavoriteOFCurrentUser($id)
    {
        try {
            $favorite = $this->favoriteRepository->findOne($id);

            if (!$favorite) {
                 throw new \Exception(__('المفضلة غير موجودة أو تم حذفها مسبقاً.'));
            }
            $this->favoriteRepository->delete($id);
            return $this->successResponse('favorite_delete',[], 202);

        }catch (\Exception $e){
            return $this->errorResponse('ERROR_OCCURRED', ['error' => $e->getMessage()], 500, app()->getLocale());
        }

    }
    public function updateProfile(UpdateProfileRequest $request)
    {
        try {
            $user = $request->user();
            $updatedUser = $request->updateUserData($user);
             return $this->successResponse('PROFILE_UPDATED_SUCCESSFULLY', new UserResource($updatedUser), 200, App::getLocale());
        } catch (\Exception $exception) {
            return $this->errorResponse('ERROR_OCCURRED', ['error' => $exception->getMessage()], 500, App::getLocale());
        }

    }

    public function deleteUser($id)
    {
        try {
            $user =$this->userRepository->findOrFail($id);
            $user->delete();
             return $this->successResponse('USER_DELETE_SUCCESS', [], 200, App::getLocale());
        } catch (\Exception $exception) {
            return $this->errorResponse('USER_NOT_FOUND', [], 500, App::getLocale());
        }

    }
    public function  storeRatingApp(StoreRatingAppRequest $request)
    {
        try {
            $ratingApp = $this->ratingRepositories->create($request->getData()) ;
            return $this->successResponse('CREATE_SUCCESS', [], 200, App::getLocale());
        }catch (\Exception $e){
            return $this->errorResponse('ERROR_OCCURRED', ['error' => $e->getMessage()], 500, App::getLocale());
        }
    }
    public function  getNotificationForCurrentUser(Request $request)
    {
        try {
            $user = $request->user();
            $notification = $this->notificationRepositories->getWhere(['user_id' => $user->id ]);
            return $this->successResponse('DATA_RETRIEVED_SUCCESSFULLY', new NotificationResource($notification), 200, App::getLocale());

        }catch (\Exception $e){
            return $this->errorResponse('ERROR_OCCURRED', ['error' => $e->getMessage()], 500, App::getLocale());

        }
    }






    // Other methods using the user repository...
}
