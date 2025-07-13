<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\UserWithTokenAccessResource;
use Google_Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Hash;
use App\Traits\ResponseTrait;
use App\Models\User;
use App ;
use Illuminate\Support\Str;




class SocialAuthController extends Controller
{
    use ResponseTrait ;




    public function handleSocialLogin(Request $request)
    {
        $request->validate([
            'provider' => 'required|string|in:google,facebook',
            'id_token' => 'required|string',
        ]);

        $provider = $request->provider;
        $idToken = $request->id_token;

        if ($provider === 'google') {
            $client = new Google_Client(['client_id' => env('GOOGLE_CLIENT_ID')]);
            $payload = $client->verifyIdToken($idToken);

            if (!$payload) {
                return response()->json(['error' => 'Invalid Google token'], 401);
            }

            $socialId = $payload['sub'];
            $email = $payload['email'];
            $name = $payload['name'] ?? 'No Name';

        } elseif ($provider === 'facebook') {
            try {
                $fbUser = Socialite::driver('facebook')->stateless()->userFromToken($idToken);

                $socialId = $fbUser->getId();
                $email = $fbUser->getEmail();
                $name = $fbUser->getName();

            } catch (\Exception $e) {
                return response()->json(['error' => 'Invalid Facebook token', 'message' => $e->getMessage()], 401);
            }

        } else {
            return response()->json(['error' => 'Unsupported provider'], 400);
        }

        $user = User::where('provider', $provider)
            ->where('provider_id', $socialId)
            ->orWhere('email', $email)
            ->first();

        if (!$user) {
            $user = User::create([
                'name' => $name,
                'email' => $email,
                'provider' => $provider,
                'provider_id' => $socialId,
                'password' => Hash::make(Str::random(24)),
            ]);
        }

        Auth::login($user);
        $token = $user->createToken(ucfirst($provider) . 'AuthToken')->plainTextToken;

        return response()->json([
            'user' => $user,
            'token' => $token,
        ]);
    }


//        try {
//            $request->validate([
//                'social_type' => 'required|string|in:google,twitter,instagram',
//                'social_token' => 'required|string',
//                'fcm_token' => 'required|string',
//                'device_type' => 'required|string',
//            ]);
//
//            $socialUser = Socialite::driver('google')->userFromToken($request->social_token);
//
//             $user = User::where('email', $socialUser->email)->first();
//            if (!$user) {
//                $user = User::create([
//                    'full_name' => $socialUser->name,
//                    'email' => $socialUser->email,
////                    'phone' => $socialUser->email, // You might want to modify this to handle phone numbers properly
//                    'image' => $socialUser->avatar,
//                    'provider' =>$request->social_type ,
//                    'provider_id' => $socialUser->id,
//                    'password' => Hash::make(Str::random(8)), // Generate a random password for security
//                ]);
//            }
//
//             $userToken =  $user->createToken('API Token')->plainTextToken;
//             $data = ['access_token' => $userToken,'user' => $user,];
//             return $this->successResponse('LOGGED_IN_SUCCESSFULLY',   new UserWithTokenAccessResource($data) , 202, app()->getLocale());

            // Return the response
//            return response()->json([
//                'success' => true,
//                'data' => [
//                    'social_type' => 'required|string|in:google,twitter,instagram',
//                    'social_token' => $request->social_token,
//                    'fcm_token' => $request->fcm_token,
//                    'device_type' => $request->device_type,
//                ],
//                'user' => $user,
//                'token' => $token,
//            ]);
//        } catch (Exception $e) {
//            if ($e instanceof \Laravel\Socialite\Two\InvalidStateException) {
//                return $this->errorResponse('INVALID_TOKEN', ['error' => 'Token has expired or is invalid'], 401, app()->getLocale());
//            }
//            return $this->errorResponse('ERROR_OCCURRED', ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()], 500, app()->getLocale());
//
//        }

//    public function redirectToTwitter()
//    {
//        return Socialite::driver('twitter')->redirect();
//    }
//
//    public function handleTwitterCallback()
//    {
//        try {
//            $twitterUser = Socialite::driver('twitter')->user();
//            return $this->handleSocialUser($twitterUser, 'twitter');
//        } catch (Exception $e) {
//             return $this->errorResponse('ERROR_OCCURRED', ['error' => $e->getMessage()], 500, app()->getLocale());
//        }
//    }
//
//    public function redirectToInstagram()
//    {
//        return Socialite::driver('instagram')->redirect();
//    }
//
//    public function handleInstagramCallback()
//    {
//        try {
//            $instagramUser = Socialite::driver('instagram')->user();
//            return $this->handleSocialUser($instagramUser, 'instagram');
//        } catch (Exception $e) {
//            return $this->errorResponse('ERROR_OCCURRED', ['error' => $e->getMessage()], 500, app()->getLocale());
//        }
//    }

//    private function handleSocialUser($socialUser, $provider)
//    {
//        $user = User::where('provider_id', $socialUser->getId())->first();
//        if (!$user) {
//              $user = User::create([
//                'full_name' => $socialUser->getName(),
//                'name' => $socialUser->getNickname(),
//                'email' => $socialUser->getEmail(),
//                'phone' => $socialUser->getEmail(),
//                'image' => $socialUser->getAvatar(),
//                'provider' => $provider,
//                'provider_id' => $socialUser->getId(),
//                'password' => Hash::make(Str::random(8)),
//            ]);
//        }else
//        {
//            return $this->errorResponse('ERROR_OCCURRED', ['error' => $user], 500, app()->getLocale());
//
//        }
//         Auth::login($user);
//         $token = $user->createToken('auth_token')->plainTextToken;
//         $dataUser =[
//            'access_token' => $token,
//            'token_type' => 'Bearer',
//            'user' => $user] ;
//
//
//        return $this->successResponse('CREATE_USER_SUCCESSFULLY', $dataUser, 201, app()->getLocale());
//
//    }
//    public function handleInstagramDeauthorization(Request $request)
//    {
//        $instagramUserId = $request->input('user_id');
//        $user = User::where('instagram_id', $instagramUserId)->first();
//        if ($user) {
//            $user->delete();
//        }
//         return response()->json(['status' => 'success'], 200);
//    }
//


}
