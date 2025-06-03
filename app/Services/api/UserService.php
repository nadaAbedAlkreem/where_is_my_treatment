<?php
namespace App\Services\api;

use App\Models\User;
use App\Repositories\IUserRepositories;
use Exception;

class UserService
{

    protected $userRepository;

    public function __construct(IUserRepositories $userRepository)
    {
        $this->userRepository = $userRepository; // Inject the repository
    }

    public function register($data)
    {
        try {
            $user = $this->userRepository->create($data);
            $userToken =  $user->createToken('API Token')->plainTextToken;
            return   [
                'access_token' =>  $userToken ,
                'token_type' => 'Bearer',
                'user' => $user
            ] ;
        } catch (\Exception $e) {
             throw new \Exception($e->getMessage());
        }

    }






}
