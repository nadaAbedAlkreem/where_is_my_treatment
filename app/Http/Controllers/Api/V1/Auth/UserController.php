<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\api\StoreLocationRequest;
use App\Http\Resources\LocationResource;
use App\Http\Resources\UserResource;
use App\Repositories\IUserRepositories;
use App\Repositories\ILocationRepositories;
use App\Services\api\UserService;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

// Make sure to import the App facade


class UserController extends Controller
{
    use ResponseTrait  ;
    protected $userRepository  , $userService ,$locationRepository;

    public function __construct(IUserRepositories $userRepository  ,ILocationRepositories $locationRepository ,UserService $userService)
    {
        $this->middleware('auth:sanctum');
        $this->userRepository = $userRepository;
        $this->userService = $userService;
        $this->locationRepository = $locationRepository;

    }

//    public function getAllUsers()
//    {
//        $users = $this->userRepository->getAll();
//        return $this->successResponse('DATA_RETRIEVED_SUCCESSFULLY',UserResource::collection($users), 200, App::getLocale());
//    }
////    public function getAllUsersWithFriends()
////    {
////        $users = $this->userRepository->getWith(['friends']);
////        return $this->successResponse('DATA_RETRIEVED_SUCCESSFULLY',UserWithFriendsResource::collection($users), 200, App::getLocale());
////    }
//
//
//    public function getSearchUsers(SearchUsersRequest $request)
//    {
//        $searchResult = $this->userRepository->getWhereSerach([[$request->query('search_type'), 'like', "%{$request->query('search_value')}%"]]);
//         return ($searchResult)
//            ? $this->successResponse('DATA_RETRIEVED_SUCCESSFULLY', UserResource::collection($searchResult), 200, App::getLocale())
//            : $this->errorResponse('NO_DATA', [], 200, App::getLocale());
//    }
//    public function  oflineUserActive($request)
//    {
//        $currentUser = $request->user();
//        $currentUser->is_online = false;
//        $currentUser->last_active_at = now();
//        $currentUser->save();
//    }

   public function storeLocationUser(StoreLocationRequest $request)
   {

       try{
              $locationUser = $this->locationRepository->create($request->getData) ;
              $locationUser->load('locationable');
              dd($locationUser);
               return $this->successResponse('CREATE_SUCCESS', new LocationResource($locationUser), 201,);
           } catch (\Exception $e) {
                return $this->errorResponse(
                'ERROR_OCCURRED',
                ['error' => $e->getMessage()],
                500,
                app()->getLocale()
                );
        }
   }
    public function updateProfile(UpdateProfileRequest $request)
    {
        try {
            $user = $request->user();
            $updatedUser = $request->updateUserData($user);

             return $this->successResponse(
                'PROFILE_UPDATED_SUCCESSFULLY',
                new UserResource($updatedUser),
                200,
                App::getLocale()
            );
        } catch (\Exception $exception) {
            return $this->errorResponse(
                'ERROR_OCCURRED',
                ['error' => $exception->getMessage()],
                500,
                App::getLocale()
            );
        }

    }

    public function deleteUser($id)
    {
        try {
            $user =$this->userRepository->findOrFail($id);
            $user->delete();
             return $this->successResponse(
                'USER_DELETE_SUCCESS',
                 [],
                200,
                App::getLocale()
            );
        } catch (\Exception $exception) {
            return $this->errorResponse(
                'USER_NOT_FOUND',
                [],
                500,
                App::getLocale()
            );
        }

    }






    // Other methods using the user repository...
}
