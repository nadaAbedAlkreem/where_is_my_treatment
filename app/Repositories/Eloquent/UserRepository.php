<?php

namespace App\Repositories\Eloquent;

use App\Models\User;
use App\Repositories\IUserRepositories;
 use App\Traits\ResponseTrait;


class UserRepository  extends BaseRepository implements IUserRepositories
{
    use ResponseTrait ;
    public function __construct()
    {
        $this->model = new User();
    }





}
