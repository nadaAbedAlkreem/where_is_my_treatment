<?php

namespace App\Repositories\Eloquent;

use App\Models\Admin;
use App\Models\Treatment;
use App\Repositories\IAdminRepositories;
use App\Repositories\ITreatmentRepositories;
use App\Traits\ResponseTrait;


class TreatmentRepository  extends BaseRepository implements ITreatmentRepositories
{
    use ResponseTrait ;
    public function __construct()
    {
        $this->model = new Treatment();
    }




}
