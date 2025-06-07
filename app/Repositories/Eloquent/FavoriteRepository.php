<?php

namespace App\Repositories\Eloquent;

use App\Models\Admin;
use App\Models\Favorite;
use App\Models\Treatment;
use App\Repositories\IAdminRepositories;
use App\Repositories\IFavoriteRepositories;
use App\Repositories\ITreatmentRepositories;
use App\Traits\ResponseTrait;


class FavoriteRepository  extends BaseRepository implements IFavoriteRepositories
{
    use ResponseTrait ;
    public function __construct()
    {
        $this->model = new Favorite();
    }




}
