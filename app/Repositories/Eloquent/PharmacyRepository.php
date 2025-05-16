<?php

namespace App\Repositories\Eloquent;

use App\Models\Admin;
use App\Models\Pharmacy;
use App\Models\Treatment;
use App\Repositories\IAdminRepositories;
use App\Repositories\IPharmacyRepositories;
use App\Repositories\ITreatmentRepositories;
use App\Traits\ResponseTrait;


class PharmacyRepository  extends BaseRepository implements IPharmacyRepositories
{
    use ResponseTrait ;
    public function __construct()
    {
        $this->model = new Pharmacy();
    }




}
