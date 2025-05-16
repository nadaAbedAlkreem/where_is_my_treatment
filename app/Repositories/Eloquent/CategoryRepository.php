<?php

namespace App\Repositories\Eloquent;

use App\Models\Admin;
use App\Models\Category;
use App\Repositories\IAdminRepositories;
use App\Repositories\ICategoryRepositories;
use App\Traits\ResponseTrait;


class CategoryRepository  extends BaseRepository implements ICategoryRepositories
{
    use ResponseTrait ;
    public function __construct()
    {
        $this->model = new Category();
    }




}
