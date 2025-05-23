<?php

namespace App\Repositories\Eloquent;

use App\Models\Admin;
use App\Models\Location;
use App\Repositories\IAdminRepositories;
use App\Repositories\ILocationRepositories;
use App\Traits\ResponseTrait;


class LocationRepository  extends BaseRepository implements ILocationRepositories
{
    use ResponseTrait ;
    public function __construct()
    {
        $this->model = new Location();
    }

}
