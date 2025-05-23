<?php

namespace App\Repositories\Eloquent;

use App\Models\Admin;
use App\Models\Pharmacy;
use App\Models\PharmacyStock;
use App\Models\Treatment;
use App\Repositories\IAdminRepositories;
use App\Repositories\IPharmacyRepositories;
use App\Repositories\IPharmacyStockRepositories;
use App\Repositories\ITreatmentRepositories;
use App\Traits\ResponseTrait;


class PharmacyStockRepository  extends BaseRepository implements IPharmacyStockRepositories
{
    use ResponseTrait ;
    public function __construct()
    {
        $this->model = new PharmacyStock();
    }




}
